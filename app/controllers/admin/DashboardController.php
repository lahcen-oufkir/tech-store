<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\ContactMessage;
use App\Models\Order;
use App\Models\Product;
use App\Models\RepairRequest;
use App\Models\Service;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $orderModel = new Order();

        $this->adminView('admin/dashboard', [
            'title'       => 'Dashboard',
            'adminActive' => 'dashboard',
            'stats'       => [
                'products'    => (new Product())->count(),
                'services'    => (new Service())->count(),
                'orders'      => $orderModel->count(),
                'revenue'     => $orderModel->totalRevenue(),
                'customers'   => count((new User())->customers()),
                'repairs'     => (new RepairRequest())->count(),
                'unread'      => (new ContactMessage())->unreadCount(),
                'pending'     => ($orderModel->countByStatus()['pending'] ?? 0) + ($orderModel->countByStatus()['confirmed'] ?? 0),
            ],
            'recentOrders'   => $orderModel->recent(6),
            'recentRepairs'  => (new RepairRequest())->recent(6),
            'recentMessages' => (new ContactMessage())->recent(6),
            'revenueByMonth' => $orderModel->revenueByMonth(6),
        ]);
    }
}
