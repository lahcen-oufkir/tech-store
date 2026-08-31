<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Validation;
use App\Models\Service;

class ServicesController extends Controller
{
    public function index()
    {
        $this->adminView('admin/services/index', [
            'title'       => 'Services',
            'adminActive' => 'services',
            'services'    => (new Service())->all(),
        ]);
    }

    public function store()
    {
        verifyCsrf();

        $validator = new Validation($_POST, [
            'name'        => 'required|max:150',
            'description' => 'max:2000',
            'price'       => 'numeric|min_value:0',
            'icon'        => 'max:100',
        ]);

        if ($validator->fails()) {
            flash('danger', reset($validator->errors()));
            redirect('admin/services');
        }

        (new Service())->create([
            'name'        => trim($_POST['name']),
            'description' => trim($_POST['description'] ?? ''),
            'price'       => $_POST['price'] !== '' ? $_POST['price'] : null,
            'icon'        => trim($_POST['icon'] ?? ''),
            'is_active'   => isset($_POST['is_active']) ? 1 : 0,
        ]);

        flash('success', 'Service created.');
        redirect('admin/services');
    }

    public function edit($id)
    {
        $service = (new Service())->find($id);

        if (!$service) {
            flash('danger', 'Service not found.');
            redirect('admin/services');
        }

        $this->adminView('admin/services/form', [
            'title'       => 'Edit Service',
            'adminActive' => 'services',
            'service'     => $service,
        ]);
    }

    public function update($id)
    {
        verifyCsrf();

        $validator = new Validation($_POST, [
            'name'        => 'required|max:150',
            'description' => 'max:2000',
            'price'       => 'numeric|min_value:0',
            'icon'        => 'max:100',
        ]);

        if ($validator->fails()) {
            flash('danger', reset($validator->errors()));
            redirect('admin/services/edit/' . $id);
        }

        (new Service())->update($id, [
            'name'        => trim($_POST['name']),
            'description' => trim($_POST['description'] ?? ''),
            'price'       => $_POST['price'] !== '' ? $_POST['price'] : null,
            'icon'        => trim($_POST['icon'] ?? ''),
            'is_active'   => isset($_POST['is_active']) ? 1 : 0,
        ]);

        flash('success', 'Service updated.');
        redirect('admin/services');
    }

    public function destroy($id)
    {
        verifyCsrf();
        (new Service())->delete($id);
        flash('success', 'Service deleted.');
        redirect('admin/services');
    }
}
