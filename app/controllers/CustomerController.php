<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Core\Validation;
use App\Models\Order;
use App\Models\RepairRequest;
use App\Models\User;

class CustomerController extends Controller
{
    public function index()
    {
        requireLogin();

        $user = currentUser();

        $this->view('customer/index', [
            'title'       => 'My Dashboard',
            'activeNav'   => 'customer',
            'user'        => (new User())->find($user['id']),
            'orders'      => (new Order())->byUser($user['id']),
            'repairs'     => (new RepairRequest())->byUser($user['id']),
        ]);
    }

    public function orders()
    {
        requireLogin();

        $orders = (new Order())->byUser(currentUser()['id']);

        foreach ($orders as &$order) {
            $order['items'] = (new \App\Models\OrderItem())->forOrder($order['id']);
        }
        unset($order);

        $this->view('customer/orders', [
            'title'     => 'My Orders',
            'activeNav' => 'customer',
            'orders'    => $orders,
        ]);
    }

    public function repairs()
    {
        requireLogin();

        $this->view('customer/repairs', [
            'title'   => 'My Repair Requests',
            'activeNav' => 'customer',
            'repairs' => (new RepairRequest())->byUser(currentUser()['id']),
        ]);
    }

    public function profile()
    {
        requireLogin();

        $this->view('customer/profile', [
            'title'   => 'My Profile',
            'activeNav' => 'customer',
            'user'    => (new User())->find(currentUser()['id']),
        ]);
    }

    public function updateProfile()
    {
        requireLogin();
        verifyCsrf();

        $validator = new Validation($_POST, [
            'name'    => 'required|min:2|max:100',
            'email'   => 'required|email|max:150|unique:users,email,' . currentUser()['id'],
            'phone'   => 'max:20',
            'address' => 'max:255',
        ]);

        if ($validator->fails()) {
            $this->view('customer/profile', [
                'title'   => 'My Profile',
                'activeNav' => 'customer',
                'user'    => (new User())->find(currentUser()['id']),
                'errors'  => $validator->errors(),
            ]);
            return;
        }

        $userModel = new User();
        $userModel->update(currentUser()['id'], [
            'name'    => trim($_POST['name']),
            'email'   => trim($_POST['email']),
            'phone'   => trim($_POST['phone'] ?? ''),
            'address' => trim($_POST['address'] ?? ''),
        ]);

        $updated = $userModel->find(currentUser()['id']);
        Session::set('user', $updated);

        flash('success', 'Profile updated successfully.');
        redirect('customer/profile');
    }
}
