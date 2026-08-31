<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $cart = [];
        foreach (cartItems() as $productId => $item) {
            $product = (new Product())->find($productId);
            if (!$product) {
                continue;
            }
            $cart[] = [
                'product'  => $product,
                'quantity' => $item['quantity'],
            ];
        }

        $this->view('cart/index', [
            'title'    => 'Shopping Cart',
            'activeNav' => 'cart',
            'cart'     => $cart,
            'total'    => cartTotal(),
        ]);
    }

    public function add()
    {
        verifyCsrf();

        $productId = (int) ($_POST['product_id'] ?? 0);
        $quantity  = max(1, (int) ($_POST['quantity'] ?? 1));

        $product = (new Product())->find($productId);

        if (!$product || !$product['is_active']) {
            flash('danger', 'Product not found.');
            redirect('products');
        }

        if ($product['stock'] <= 0) {
            flash('warning', 'This product is currently out of stock.');
            redirect('products');
        }

        $items = cartItems();

        $items[$productId] = [
            'product_id' => $product['id'],
            'name'       => $product['name'],
            'price'      => (float) $product['price'],
            'quantity'   => ($items[$productId]['quantity'] ?? 0) + $quantity,
        ];

        Session::set(CART_SESSION, $items);

        flash('success', $product['name'] . ' added to your cart.');
        redirect('cart');
    }

    public function update()
    {
        verifyCsrf();

        $productId = (int) ($_POST['product_id'] ?? 0);
        $quantity  = (int) ($_POST['quantity'] ?? 0);
        $items     = cartItems();

        if (!isset($items[$productId])) {
            redirect('cart');
        }

        if ($quantity <= 0) {
            unset($items[$productId]);
        } else {
            $items[$productId]['quantity'] = $quantity;
        }

        Session::set(CART_SESSION, $items);
        redirect('cart');
    }

    public function remove()
    {
        verifyCsrf();

        $productId = (int) ($_POST['product_id'] ?? 0);
        $items     = cartItems();

        if (isset($items[$productId])) {
            unset($items[$productId]);
            Session::set(CART_SESSION, $items);
            flash('success', 'Product removed from your cart.');
        }

        redirect('cart');
    }

    public function clear()
    {
        verifyCsrf();
        Session::remove(CART_SESSION);
        flash('info', 'Your cart has been cleared.');
        redirect('cart');
    }
}
