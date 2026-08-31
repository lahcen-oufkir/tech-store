<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Order;
use App\Models\User;

class CustomersController extends Controller
{
    public function index()
    {
        $this->adminView('admin/customers/index', [
            'title'       => 'Customers',
            'adminActive' => 'customers',
            'customers'   => (new User())->customers(),
        ]);
    }

    public function show($id)
    {
        $user = (new User())->find($id);

        if (!$user || $user['role'] !== 'customer') {
            flash('danger', 'Customer not found.');
            redirect('admin/customers');
        }

        $this->adminView('admin/customers/show', [
            'title'       => 'Customer - ' . $user['name'],
            'adminActive' => 'customers',
            'customer'    => $user,
            'orders'      => (new Order())->byUser($id),
        ]);
    }
}
