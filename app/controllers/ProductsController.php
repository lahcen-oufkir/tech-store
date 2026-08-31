<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Category;
use App\Models\Product;

class ProductsController extends Controller
{
    public function index()
    {
        $search      = trim($_GET['search'] ?? '');
        $categorySlug = trim($_GET['category'] ?? '');

        $categories = (new Category())->withProductCount();
        $category   = $categorySlug ? (new Category())->findBySlug($categorySlug) : null;

        $productModel = new Product();

        if ($search !== '') {
            $products = $productModel->search($search, $category ? $category['id'] : null);
        } elseif ($category) {
            $products = $productModel->byCategory($category['id']);
        } else {
            $products = $productModel->active();
        }

        $this->view('products/index', [
            'title'      => $category ? $category['name'] : 'Products',
            'activeNav'  => 'products',
            'products'   => $products,
            'categories' => $categories,
            'search'     => $search,
            'currentCategory' => $categorySlug,
        ]);
    }

    public function show($slug)
    {
        $product = (new Product())->findBySlug($slug);

        if (!$product || !$product['is_active']) {
            http_response_code(404);
            $this->view('errors/404');
            return;
        }

        $this->view('products/details', [
            'title'    => $product['name'],
            'activeNav' => 'products',
            'product'  => $product,
            'related'  => (new Product())->related($product['id'], $product['category_id']),
        ]);
    }
}
