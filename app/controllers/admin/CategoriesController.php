<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Validation;
use App\Models\Category;

class CategoriesController extends Controller
{
    public function index()
    {
        $this->adminView('admin/categories/index', [
            'title'       => 'Categories',
            'adminActive' => 'categories',
            'categories'  => (new Category())->withProductCount(),
        ]);
    }

    public function store()
    {
        verifyCsrf();

        $validator = new Validation($_POST, [
            'name'        => 'required|max:100',
            'slug'        => 'required|max:120|unique:categories,slug',
            'description' => 'max:1000',
        ]);

        if ($validator->fails()) {
            flash('danger', reset($validator->errors()));
            redirect('admin/categories');
        }

        (new Category())->create([
            'name'        => trim($_POST['name']),
            'slug'        => slugify($_POST['slug']),
            'description' => trim($_POST['description'] ?? ''),
        ]);

        flash('success', 'Category created.');
        redirect('admin/categories');
    }

    public function edit($id)
    {
        $category = (new Category())->find($id);

        if (!$category) {
            flash('danger', 'Category not found.');
            redirect('admin/categories');
        }

        $this->adminView('admin/categories/form', [
            'title'       => 'Edit Category',
            'adminActive' => 'categories',
            'category'    => $category,
        ]);
    }

    public function update($id)
    {
        verifyCsrf();

        $validator = new Validation($_POST, [
            'name'        => 'required|max:100',
            'slug'        => 'required|max:120|unique:categories,slug,' . $id,
            'description' => 'max:1000',
        ]);

        if ($validator->fails()) {
            flash('danger', reset($validator->errors()));
            redirect('admin/categories/edit/' . $id);
        }

        (new Category())->update($id, [
            'name'        => trim($_POST['name']),
            'slug'        => slugify($_POST['slug']),
            'description' => trim($_POST['description'] ?? ''),
        ]);

        flash('success', 'Category updated.');
        redirect('admin/categories');
    }

    public function destroy($id)
    {
        verifyCsrf();

        $category = (new Category())->find($id);

        if ($category) {
            // Move products to "no category" before deleting
            (new \App\Models\Product())->updateByCategory($id);
            (new Category())->delete($id);
            flash('success', 'Category deleted.');
        }

        redirect('admin/categories');
    }
}
