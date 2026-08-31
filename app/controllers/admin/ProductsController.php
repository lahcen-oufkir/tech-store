<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Validation;
use App\Models\Category;
use App\Models\Product;

class ProductsController extends Controller
{
    private function categories()
    {
        return (new Category())->all();
    }

    public function index()
    {
        $search = trim($_GET['search'] ?? '');

        if ($search !== '') {
            $products = (new Product())->adminSearch($search);
        } else {
            $products = (new Product())->adminAll();
        }

        $this->adminView('admin/products/index', [
            'title'       => 'Products',
            'adminActive' => 'products',
            'products'    => $products,
            'search'      => $search,
        ]);
    }

    public function create()
    {
        $this->adminView('admin/products/form', [
            'title'      => 'Add Product',
            'adminActive' => 'products',
            'product'    => null,
            'categories' => $this->categories(),
        ]);
    }

    public function store()
    {
        verifyCsrf();

        $validator = new Validation($_POST, [
            'name'        => 'required|max:150',
            'slug'        => 'required|max:160|unique:products,slug',
            'category_id' => 'numeric',
            'price'       => 'required|numeric|min_value:0',
            'old_price'   => 'numeric|min_value:0',
            'stock'       => 'required|numeric|min_value:0',
            'description' => 'max:5000',
        ]);

        if ($validator->fails()) {
            $this->adminView('admin/products/form', [
                'title'       => 'Add Product',
                'adminActive' => 'products',
                'product'     => $_POST,
                'categories'  => $this->categories(),
                'errors'      => $validator->errors(),
            ]);
            return;
        }

        $image = uploadImage($_FILES['image'] ?? null);
        if ($image === false) {
            $this->adminView('admin/products/form', [
                'title'       => 'Add Product',
                'adminActive' => 'products',
                'product'     => $_POST,
                'categories'  => $this->categories(),
                'errors'      => $validator->errors(),
            ]);
            return;
        }

        (new Product())->create([
            'category_id' => $_POST['category_id'] ? (int) $_POST['category_id'] : null,
            'name'        => trim($_POST['name']),
            'slug'        => slugify($_POST['slug']),
            'description' => trim($_POST['description'] ?? ''),
            'price'       => $_POST['price'],
            'old_price'   => $_POST['old_price'] !== '' ? $_POST['old_price'] : null,
            'stock'       => (int) $_POST['stock'],
            'image'       => $image,
            'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
            'is_active'   => isset($_POST['is_active']) ? 1 : 0,
        ]);

        flash('success', 'Product created successfully.');
        redirect('admin/products');
    }

    public function edit($id)
    {
        $product = (new Product())->find($id);

        if (!$product) {
            flash('danger', 'Product not found.');
            redirect('admin/products');
        }

        $this->adminView('admin/products/form', [
            'title'       => 'Edit Product',
            'adminActive' => 'products',
            'product'     => $product,
            'categories'  => $this->categories(),
        ]);
    }

    public function update($id)
    {
        verifyCsrf();

        $product = (new Product())->find($id);
        if (!$product) {
            flash('danger', 'Product not found.');
            redirect('admin/products');
        }

        $validator = new Validation($_POST, [
            'name'        => 'required|max:150',
            'slug'        => 'required|max:160|unique:products,slug,' . $id,
            'category_id' => 'numeric',
            'price'       => 'required|numeric|min_value:0',
            'old_price'   => 'numeric|min_value:0',
            'stock'       => 'required|numeric|min_value:0',
            'description' => 'max:5000',
        ]);

        if ($validator->fails()) {
            $this->adminView('admin/products/form', [
                'title'       => 'Edit Product',
                'adminActive' => 'products',
                'product'     => array_merge($product, $_POST),
                'categories'  => $this->categories(),
                'errors'      => $validator->errors(),
            ]);
            return;
        }

        $image = uploadImage($_FILES['image'] ?? null, $product['image']);
        if ($image === false) {
            $this->adminView('admin/products/form', [
                'title'       => 'Edit Product',
                'adminActive' => 'products',
                'product'     => array_merge($product, $_POST),
                'categories'  => $this->categories(),
                'errors'      => $validator->errors(),
            ]);
            return;
        }

        (new Product())->update($id, [
            'category_id' => $_POST['category_id'] ? (int) $_POST['category_id'] : null,
            'name'        => trim($_POST['name']),
            'slug'        => slugify($_POST['slug']),
            'description' => trim($_POST['description'] ?? ''),
            'price'       => $_POST['price'],
            'old_price'   => $_POST['old_price'] !== '' ? $_POST['old_price'] : null,
            'stock'       => (int) $_POST['stock'],
            'image'       => $image,
            'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
            'is_active'   => isset($_POST['is_active']) ? 1 : 0,
        ]);

        flash('success', 'Product updated successfully.');
        redirect('admin/products');
    }

    public function destroy($id)
    {
        verifyCsrf();

        $product = (new Product())->find($id);
        if ($product) {
            deleteImage($product['image']);
            (new Product())->delete($id);
            flash('success', 'Product deleted.');
        }

        redirect('admin/products');
    }
}
