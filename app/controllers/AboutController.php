<?php
class AboutController extends Controller {

    private $galleryModel;

    public function __construct() {
        $this->galleryModel = $this->model('Gallery');
    }

    public function index() {
        $data = [
            'title'        => 'About Us | ' . SITENAME,
            'metaDesc'     => 'Learn about Pinga Agro Investment Limited — our story, mission, values, and the people behind one of Southeast Nigeria\'s leading poultry operations.',
            'images'       => $this->galleryModel->getImages(6, 0),
            'totalImages'  => $this->galleryModel->countImages(),
        ];
        $this->view('pages/about', $data);
    }

    /**
     * AJAX endpoint — /about/loadmore?offset=6
     * Returns JSON array of image records
     */
    public function loadmore() {
        header('Content-Type: application/json');

        $offset = (int)($_GET['offset'] ?? 0);
        $images = $this->galleryModel->getImages(6, $offset);

        $result = [];
        foreach ($images as $img) {
            $result[] = [
                'filename' => htmlspecialchars($img->filename),
                'caption'  => htmlspecialchars($img->caption  ?? ''),
                'location' => htmlspecialchars($img->location ?? ''),
            ];
        }

        echo json_encode($result);
        exit;
    }
}