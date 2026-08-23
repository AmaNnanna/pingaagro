<?php
class InsightsController extends Controller
{
    private $postModel;

    public function __construct()
    {
        // Load the Post model once — available to all methods
        $this->postModel = $this->model('Post');
    }

    /**
     * /insights — Show all published posts
     */
    public function index()
    {
        $posts      = $this->postModel->getPublishedPosts();
        $categories = $this->postModel->getCategories();

        $data = [
            'title'      => 'Insights | ' . SITENAME,
            'metaDesc'   => 'Perspectives on poultry farming, agricultural investment, and community development from the Pinga Agro team.',
            'posts'      => $posts,
            'categories' => $categories,
            'featured'   => !empty($posts) ? $posts[0] : null,     // First post is featured
            'remaining'  => !empty($posts) ? array_slice($posts, 1) : [], // Rest go in the grid
        ];

        $this->view('pages/insights', $data);
    }

    /**
     * /insights/{slug} — Show a single post
     */
    public function post(string $slug)
    {
        $post = $this->postModel->getPostBySlug($slug);

        // If post doesn't exist, send to 404
        if (!$post) {
            $this->view('pages/404', ['title' => 'Post Not Found | ' . SITENAME]);
            return;
        }

        $data = [
            'title'    => $post->title . ' | ' . SITENAME,
            'metaDesc' => $post->excerpt,
            'post'     => $post,
        ];

        $this->view('pages/post', $data);
    }

    /**
     * /insights/category/{slug} — Filter posts by category
     */
    public function category(string $slug)
    {
        $posts      = $this->postModel->getPostsByCategory($slug);
        $categories = $this->postModel->getCategories();

        $data = [
            'title'        => 'Category: ' . ucfirst(str_replace('-', ' ', $slug)) . ' | ' . SITENAME,
            'posts'        => $posts,
            'categories'   => $categories,
            'featured'     => !empty($posts) ? $posts[0] : null,
            'remaining'    => !empty($posts) ? array_slice($posts, 1) : [],
            'activeCategory' => $slug,
        ];

        $this->view('pages/insights', $data);
    }
}
