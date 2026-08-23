<?php
class AboutController extends Controller {
    public function index() {
        $data = [
            'title'    => 'About Us | ' . SITENAME,
            'metaDesc' => 'Learn about Pinga Agro Investment Limited — our story, mission, values, and the people behind one of Southeast Nigeria\'s leading poultry operations.',
        ];
        $this->view('pages/about', $data);
    }
}