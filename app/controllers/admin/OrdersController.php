<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Validation;
use App\Models\Order;

class OrdersController extends Controller
{
    public function index()
    {
        $this->adminView('admin/orders/index', [
            'title'       => 'Orders',
            'adminActive' => 'orders',
            'orders'      => (new Order())->recent(100),
        ]);
    }

    public function show($id)
    {
        $order = (new Order())->withItems($id);

        if (!$order) {
            flash('danger', 'Order not found.');
            redirect('admin/orders');
        }

        $this->adminView('admin/orders/show', [
            'title'       => 'Order ' . $order['order_number'],
            'adminActive' => 'orders',
            'order'       => $order,
        ]);
    }

    public function updateStatus($id)
    {
        verifyCsrf();

        $validator = new Validation($_POST, [
            'status' => 'required|in:pending,confirmed,shipped,delivered,cancelled',
        ]);

        if ($validator->fails()) {
            flash('danger', 'Invalid status.');
            redirect('admin/orders/show/' . $id);
        }

        (new Order())->update($id, ['status' => $_POST['status']]);
        flash('success', 'Order status updated.');
        redirect('admin/orders/show/' . $id);
    }
}
