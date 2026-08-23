<?php
class HomeController extends Controller
{

    public function index()
    {
        $postModel   = $this->model('Post');
        $reviewModel = $this->model('Review');

        $posts   = $postModel->getPublishedPosts(3);
        $reviews = $reviewModel->getRandomApprovedReviews(6);

        $data = [
            'title'    => 'Home | ' . SITENAME,
            'metaDesc' => 'Pinga Agro Investment Limited — Another Name for Quality. Premium poultry production and agricultural authority in Southeast Nigeria.',
            'posts'    => $posts,
            'reviews'  => $reviews,
        ];

        $this->view('pages/home', $data);
    }
}
