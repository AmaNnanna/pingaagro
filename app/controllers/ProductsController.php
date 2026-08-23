<?php
class ProductsController extends Controller {
    public function index() {
        $data = [
            'title'    => 'Our Products | ' . SITENAME,
            'metaDesc' => 'Premium eggs, broilers, and layers from Pinga Agro Investment Limited — quality poultry products from the heart of Southeast Nigeria.',
        ];
        $this->view('pages/products', $data);
    }
}