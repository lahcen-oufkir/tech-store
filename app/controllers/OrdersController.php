<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Core\Validation;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;

class OrdersController extends Controller
{
    public function checkout()
    {
        requireLogin();

        if (cartCount() === 0) {
            flash('info', 'Your cart is empty. Add some products first.');
            redirect('products');
        }

        $items = $this->cartWithProducts();

        $this->view('orders/checkout', [
            'title'    => 'Checkout',
            'activeNav' => 'cart',
            'items'    => $items,
            'total'    => cartTotal(),
            'user'     => currentUser(),
        ]);
    }

    public function store()
    {
        requireLogin();
        verifyCsrf();

        if (cartCount() === 0) {
            flash('danger', 'Your cart is empty.');
            redirect('products');
        }

        $validator = new Validation($_POST, [
            'customer_name'  => 'required|max:100',
            'customer_email' => 'required|email|max:150',
            'customer_phone' => 'required|max:20',
            'shipping_address' => 'required|max:255',
            'payment_method' => 'required|in:pay_in_store,cash_on_delivery',
        ]);

        if ($validator->fails()) {
            $items = $this->cartWithProducts();
            $this->view('orders/checkout', [
                'title'    => 'Checkout',
                'activeNav' => 'cart',
                'items'    => $items,
                'total'    => cartTotal(),
                'user'     => currentUser(),
                'errors'   => $validator->errors(),
            ]);
            return;
        }

        $orderModel = new Order();
        $orderId    = $orderModel->create([
            'order_number'     => $this->generateOrderNumber(),
            'user_id'          => currentUser()['id'],
            'customer_name'    => trim($_POST['customer_name']),
            'customer_email'   => trim($_POST['customer_email']),
            'customer_phone'   => trim($_POST['customer_phone']),
            'shipping_address' => trim($_POST['shipping_address']),
            'payment_method'   => $_POST['payment_method'],
            'status'           => 'pending',
            'total'            => cartTotal(),
            'notes'            => trim($_POST['notes'] ?? ''),
        ]);

        $productModel = new Product();

        foreach (cartItems() as $productId => $item) {
            (new OrderItem())->create([
                'order_id'     => $orderId,
                'product_id'   => $productId,
                'product_name' => $item['name'],
                'quantity'     => $item['quantity'],
                'price'        => $item['price'],
            ]);

            // Only reduce stock when enough is available
            $productModel->decrementStockSafely($productId, $item['quantity']);
        }

        $orderNumber = $orderModel->find($orderId)['order_number'];

        Session::remove(CART_SESSION);

        flash('success', 'Order ' . $orderNumber . ' placed successfully. Thank you!');
        redirect('customer/orders');
    }

    private function cartWithProducts()
    {
        $items = [];
        foreach (cartItems() as $productId => $item) {
            $product = (new Product())->find($productId);
            if ($product) {
                $items[] = ['product' => $product, 'quantity' => $item['quantity']];
            }
        }
        return $items;
    }

    private function generateOrderNumber()
    {
        return 'TM-' . date('Ymd') . '-' . random_int(100, 999);
    }
}
