<?php
class ReviewController extends Controller
{
    private $reviewModel;

    public function __construct()
    {
        $this->reviewModel = $this->model('Review');
    }

    /**
     * GET /review — Show all approved reviews
     */
    public function index(): void
    {
        $data = [
            'title'    => 'Customer Reviews | ' . SITENAME,
            'metaDesc' => 'Read what farmers, partners and customers say about Pinga Agro Investment Limited.',
            'reviews'  => $this->reviewModel->getApprovedReviews(),
        ];
        $this->view('pages/review', $data);
    }

    /**
     * GET /review/create — Show the submission form
     */
    public function create(): void
    {
        $data = [
            'title'   => 'Share Your Experience | ' . SITENAME,
            'success' => false,
            'errors'  => [],
            'old'     => [],
        ];
        $this->view('pages/review-create', $data);
    }

    /**
     * POST /review/submit — Process the submission
     */
    public function submit(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(URLROOT . '/review/create');
        }

        $old = [
            'name'        => trim($_POST['name']        ?? ''),
            'designation' => trim($_POST['designation'] ?? ''),
            'review'      => trim($_POST['review']      ?? ''),
        ];

        $errors = [];

        if (empty($old['name'])) {
            $errors['name'] = 'Your name is required.';
        }

        if (empty($old['review'])) {
            $errors['review'] = 'Please write your review.';
        } elseif (strlen($old['review']) < 30) {
            $errors['review'] = 'Your review is too short — please share a bit more.';
        }

        $imageName = null;

        if (!empty($_FILES['image']['name'])) {
            $file    = $_FILES['image'];
            $maxSize = 500 * 1024; // 500KB

            // ── Check for upload errors first ──────────────────────
            if ($file['error'] !== UPLOAD_ERR_OK) {
                $errors['image'] = 'Upload failed. Please try again.';
            } else {

                // ── Validate file size ──────────────────────────────
                if ($file['size'] > $maxSize) {
                    $errors['image'] = 'Image must be under 500KB.';
                } else {

                    // ── Validate MIME type from actual file content ─
                    // NOT from the extension or browser-reported type
                    // An attacker can fake both of those
                    $finfo    = new finfo(FILEINFO_MIME_TYPE);
                    $mimeType = $finfo->file($file['tmp_name']);
                    $allowed  = ['image/jpeg', 'image/png', 'image/webp'];

                    if (!in_array($mimeType, $allowed)) {
                        $errors['image'] = 'Image must be JPG, PNG, or WebP.';
                    } else {

                        // ── Verify it is actually a valid image ─────
                        // getimagesize() reads the image header
                        // A PHP file disguised as an image will fail this
                        $imageInfo = getimagesize($file['tmp_name']);
                        if ($imageInfo === false) {
                            $errors['image'] = 'The uploaded file is not a valid image.';
                        } else {

                            // ── Generate safe filename ──────────────
                            // Map MIME to extension — never trust the original filename
                            $extMap    = [
                                'image/jpeg' => 'jpg',
                                'image/png'  => 'png',
                                'image/webp' => 'webp',
                            ];
                            $ext       = $extMap[$mimeType];
                            $imageName = 'review_' . time() . '_'
                                . bin2hex(random_bytes(4)) . '.' . $ext;

                            $uploadDir = BASEPATH . 'public/images/reviews/';

                            if (!is_dir($uploadDir)) {
                                mkdir($uploadDir, 0755, true);
                            }

                            if (!move_uploaded_file($file['tmp_name'], $uploadDir . $imageName)) {
                                $errors['image'] = 'Image could not be saved. Please try again.';
                                $imageName = null;
                            }
                        }
                    }
                }
            }
        }

        if (!empty($errors)) {
            $data = [
                'title'   => 'Share Your Experience | ' . SITENAME,
                'success' => false,
                'errors'  => $errors,
                'old'     => $old,
            ];
            $this->view('pages/review-create', $data);
            return;
        }

        $saved = $this->reviewModel->submitReview([
            'name'        => $old['name'],
            'designation' => $old['designation'],
            'review'      => $old['review'],
            'image'       => $imageName,
        ]);

        $data = [
            'title'   => $saved ? 'Thank You | ' . SITENAME : 'Share Your Experience | ' . SITENAME,
            'success' => $saved,
            'errors'  => $saved ? [] : ['general' => 'Something went wrong. Please try again.'],
            'old'     => $saved ? [] : $old,
        ];

        $this->view('pages/review-create', $data);
    }
}
