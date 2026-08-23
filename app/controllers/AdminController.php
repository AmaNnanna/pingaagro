<?php

/**
 * Admin Controller
 * All routes begin with /admin
 * Every method (except login) first calls requireAuth()
 */
class AdminController extends Controller
{

    private $adminModel;
    private $postModel;
    private $contactModel;

    public function __construct()
    {
        $this->adminModel   = $this->model('AdminUser');
        $this->postModel    = $this->model('Post');
        $this->contactModel = $this->model('Contact');
    }

    // ── AUTH GUARD ──────────────────────────────────────────
    /**
     * Call at the top of every protected method.
     * Redirects to login if not authenticated.
     */
    private function requireAuth(): void
    {
        if (empty($_SESSION['admin_logged_in'])) {
            $this->redirect(URLROOT . '/admin/login');
        }
        $this->checkSessionTimeout();
    }

    // ── DASHBOARD ───────────────────────────────────────────
    public function index(): void
    {
        $this->requireAuth();

        $data = [
            'title'           => 'Dashboard | Admin',
            'stats'           => $this->adminModel->getDashboardStats(),
            'recentPosts'     => $this->adminModel->getRecentPosts(),
            'recentContacts'  => $this->adminModel->getRecentContacts(),
            'adminName'       => $_SESSION['admin_name'] ?? 'Admin',
        ];

        $this->view('admin/dashboard', $data, 'admin');
    }

    // ── LOGIN ────────────────────────────────────────────────
    public function login(): void
    {
        if (!empty($_SESSION['admin_logged_in'])) {
            $this->redirect(URLROOT . '/admin');
        }

        $data = [
            'title'    => 'Admin Login | ' . SITENAME,
            'error'    => '',
            'old'      => [],
            'locked'   => false,
            'waitMins' => 0,
        ];

        // ── Brute force check ──────────────────────────────────
        $maxAttempts  = 5;
        $lockoutSecs  = 2 * 60; // 2 minutes

        $attempts  = $_SESSION['login_attempts']     ?? 0;
        $lastTime  = $_SESSION['last_attempt_time']  ?? 0;

        if ($attempts >= $maxAttempts) {
            $elapsed = time() - $lastTime;
            if ($elapsed < $lockoutSecs) {
                $data['locked']   = true;
                $data['waitMins'] = ceil(($lockoutSecs - $elapsed) / 60);
                $this->view('admin/login', $data, 'none');
                return;
            } else {
                // Lockout expired — reset
                $_SESSION['login_attempts']    = 0;
                $_SESSION['last_attempt_time'] = 0;
            }
        }
        // ──────────────────────────────────────────────────────

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Security::verifyCsrf();

            $email    = trim($_POST['email']    ?? '');
            $password = trim($_POST['password'] ?? '');
            $data['old'] = ['email' => $email];

            if (empty($email) || empty($password)) {
                $data['error'] = 'Please enter both email and password.';
            } else {
                $user = $this->adminModel->findByEmail($email);

                if ($user && password_verify($password, $user->password)) {
                    // Success — reset attempts and log in
                    $_SESSION['login_attempts']    = 0;
                    $_SESSION['last_attempt_time'] = 0;

                    session_regenerate_id(true);
                    $_SESSION['admin_logged_in'] = true;
                    $_SESSION['admin_id']        = $user->id;
                    $_SESSION['admin_name']      = $user->name;
                    $_SESSION['admin_email']     = $user->email;
                    $_SESSION['last_activity']   = time();
                    $this->redirect(URLROOT . '/admin');
                } else {
                    // Failed — increment attempt counter
                    $_SESSION['login_attempts']    = $attempts + 1;
                    $_SESSION['last_attempt_time'] = time();

                    $remaining = $maxAttempts - ($_SESSION['login_attempts']);
                    if ($remaining > 0) {
                        $data['error'] = 'Invalid email or password. '
                            . $remaining . ' attempt' . ($remaining === 1 ? '' : 's') . ' remaining.';
                    } else {
                        $data['error'] = 'Too many failed attempts. '
                            . 'You are locked out for 2 minutes.';
                    }
                }
            }
        }

        $this->view('admin/login', $data, 'none');
    }

    // ── LOGOUT ───────────────────────────────────────────────
    public function logout(): void
    {
        session_destroy();
        $this->redirect(URLROOT . '/admin/login');
    }

    // ── POSTS LIST ───────────────────────────────────────────
    public function posts(): void
    {
        $this->requireAuth();

        $data = [
            'title'     => 'All Posts | Admin',
            'posts'     => $this->postModel->adminGetAllPosts(),
            'adminName' => $_SESSION['admin_name'] ?? 'Admin',
            'flash'     => $_SESSION['flash'] ?? null,
        ];

        // Clear flash message after reading it
        unset($_SESSION['flash']);

        $this->view('admin/posts/index', $data, 'admin');
    }

    // ── CREATE POST ──────────────────────────────────────────
    public function newpost(): void
    {
        $this->requireAuth();

        $data = [
            'title'      => 'New Post | Admin',
            'categories' => $this->postModel->getCategories(),
            'errors'     => [],
            'old'        => [],
            'adminName'  => $_SESSION['admin_name'] ?? 'Admin',
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $old = [
                'title'          => trim($_POST['title']          ?? ''),
                'slug'           => trim($_POST['slug']           ?? ''),
                'excerpt'        => trim($_POST['excerpt']        ?? ''),
                'body'           => $_POST['body']                ?? '',
                'category_id'   => (int)($_POST['category_id']  ?? 0),
                'featured_image' => trim($_POST['featured_image'] ?? ''),
                'author'         => trim($_POST['author']         ?? 'Pinga Agro Team'),
                'status'         => $_POST['status']              ?? 'draft',
            ];
            $data['old'] = $old;
            $errors = $this->validatePost($old);

            if (empty($errors)) {
                if ($this->postModel->adminCreatePost($old)) {
                    $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Post created successfully.'];
                    $this->redirect(URLROOT . '/admin/posts');
                } else {
                    $errors['general'] = 'Failed to save the post. Please try again.';
                }
            }

            $data['errors'] = $errors;
        }

        $this->view('admin/posts/create', $data, 'admin');
    }

    // ── EDIT POST ────────────────────────────────────────────
    public function editpost(int $id): void
    {
        $this->requireAuth();

        $post = $this->postModel->adminGetPostById($id);
        if (!$post) {
            $_SESSION['flash'] = ['type' => 'error', 'msg' => 'Post not found.'];
            $this->redirect(URLROOT . '/admin/posts');
        }

        $data = [
            'title'      => 'Edit Post | Admin',
            'post'       => $post,
            'categories' => $this->postModel->getCategories(),
            'errors'     => [],
            'adminName'  => $_SESSION['admin_name'] ?? 'Admin',
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $updated = [
                'title'          => trim($_POST['title']          ?? ''),
                'slug'           => trim($_POST['slug']           ?? ''),
                'excerpt'        => trim($_POST['excerpt']        ?? ''),
                'body'           => $_POST['body']                ?? '',
                'category_id'   => (int)($_POST['category_id']  ?? 0),
                'featured_image' => trim($_POST['featured_image'] ?? ''),
                'author'         => trim($_POST['author']         ?? 'Pinga Agro Team'),
                'status'         => $_POST['status']              ?? 'draft',
            ];
            $errors = $this->validatePost($updated, $id);

            if (empty($errors)) {
                if ($this->postModel->adminUpdatePost($id, $updated)) {
                    $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Post updated successfully.'];
                    $this->redirect(URLROOT . '/admin/posts');
                } else {
                    $errors['general'] = 'Failed to update the post. Please try again.';
                }
            }

            // Rebuild post object with updated values for form repopulation
            foreach ($updated as $key => $val) {
                $data['post']->$key = $val;
            }
            $data['errors'] = $errors;
        }

        $this->view('admin/posts/edit', $data, 'admin');
    }

    // ── DELETE POST ──────────────────────────────────────────
    public function deletepost(int $id): void
    {
        $this->requireAuth();

        // Only allow POST requests for deletions
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(URLROOT . '/admin/posts');
        }

        if ($this->postModel->adminDeletePost($id)) {
            $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Post deleted.'];
        } else {
            $_SESSION['flash'] = ['type' => 'error', 'msg' => 'Could not delete post.'];
        }

        $this->redirect(URLROOT . '/admin/posts');
    }

    // ── CONTACTS ─────────────────────────────────────────────
    public function contacts(): void
    {
        $this->requireAuth();

        $data = [
            'title'     => 'Contact Submissions | Admin',
            'contacts'  => $this->contactModel->getAllSubmissions(),
            'adminName' => $_SESSION['admin_name'] ?? 'Admin',
            'flash'     => $_SESSION['flash'] ?? null,
        ];

        unset($_SESSION['flash']);

        $this->view('admin/contacts/index', $data, 'admin');
    }

    // ── MARK CONTACT AS READ ─────────────────────────────────
    public function readcontact(int $id): void
    {
        $this->requireAuth();
        $this->contactModel->markAsRead($id);
        $this->redirect(URLROOT . '/admin/contacts');
    }

    // ── POST VALIDATION (shared by create and edit) ───────────
    private function validatePost(array $data, int $excludeId = 0): array
    {
        $errors = [];

        if (empty($data['title'])) {
            $errors['title'] = 'Post title is required.';
        }

        if (empty($data['slug'])) {
            $errors['slug'] = 'Post slug is required.';
        } elseif (!preg_match('/^[a-z0-9\-]+$/', $data['slug'])) {
            $errors['slug'] = 'Slug may only contain lowercase letters, numbers, and hyphens.';
        } elseif ($this->postModel->slugExists($data['slug'], $excludeId)) {
            $errors['slug'] = 'This slug is already in use. Please choose another.';
        }

        if (empty(strip_tags($data['body']))) {
            $errors['body'] = 'Post content is required.';
        }

        return $errors;
    }

    // ── REVIEWS ──────────────────────────────────────────────
    public function reviews(): void
    {
        $this->requireAuth();

        $reviewModel = $this->model('Review');

        $data = [
            'title'   => 'Reviews | Admin',
            'reviews' => $reviewModel->getAllReviews(),
            'flash'   => $_SESSION['flash'] ?? null,
        ];
        unset($_SESSION['flash']);

        $this->view('admin/reviews/index', $data, 'admin');
    }

    public function approvereview(int $id): void
    {
        $this->requireAuth();
        $reviewModel = $this->model('Review');
        $reviewModel->updateStatus($id, 'approved');
        $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Review approved and published.'];
        $this->redirect(URLROOT . '/admin/reviews');
    }

    public function rejectreview(int $id): void
    {
        $this->requireAuth();
        $reviewModel = $this->model('Review');
        $reviewModel->updateStatus($id, 'rejected');
        $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Review rejected.'];
        $this->redirect(URLROOT . '/admin/reviews');
    }
}
