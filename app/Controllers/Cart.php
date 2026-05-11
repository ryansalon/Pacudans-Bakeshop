<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\ProductVariantModel;

class Cart extends BaseController
{
    public function index()
    {
        $session = session();
        $cart = $session->get('cart') ?? [];
        
        $data = [
            'cart'  => $cart,
            'title' => 'Shopping Cart'
        ];

        return view('cart/index', $data);
    }

    public function add()
    {
        $session = session();
        $productModel = new ProductModel();
        $variantModel = new ProductVariantModel();
        
        $productId = $this->request->getPost('product_id');
        $variantId = $this->request->getPost('variant_id');
        $quantity = (int)($this->request->getPost('quantity') ?? 1);
        $isBuyNow = (string)$this->request->getPost('buy_now') === '1';
        
        $product = $productModel->find($productId);
        if (!$product) {
            return $this->response->setJSON(['success' => false, 'message' => 'Product not found.']);
        }

        $cartPrice = $product['price'];
        $sizeName = '';
        $cartKey = 'p' . $productId;

        if ($variantId) {
            $variant = $variantModel->find($variantId);
            if ($variant) {
                $cartPrice = $variant['price'];
                $sizeName = $variant['size_name'];
                $cartKey = 'v' . $variantId;
            }
        }

        if ($isBuyNow) {
            // Completely clear the main cart to ensure "Direct Order" 
            // only includes this specific item.
            $session->remove('cart');
            
            $directItem = [
                'id'         => $product['product_id'],
                'variant_id' => $variantId,
                'name'       => $product['name'],
                'size'       => $sizeName,
                'price'      => $cartPrice,
                'image'      => $product['image_url'],
                'quantity'   => $quantity
            ];
            
            $session->set('direct_order', $directItem);
            return redirect()->to(base_url('checkout?direct=1'));
        }

        // "Add to Cart" accumulates as normal
        $cart = $session->get('cart') ?? [];
        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $quantity;
        } else {
            $cart[$cartKey] = [
                'id'         => $product['product_id'],
                'variant_id' => $variantId,
                'name'       => $product['name'],
                'size'       => $sizeName,
                'price'      => $cartPrice,
                'image'      => $product['image_url'],
                'quantity'   => $quantity
            ];
        }

        $session->set('cart', $cart);

        $totalCount = 0;
        foreach ($cart as $item) {
            $totalCount += $item['quantity'];
        }

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => true, 
                'message' => 'Added ' . $product['name'] . ($sizeName ? " ($sizeName)" : "") . ' to cart!',
                'cart_count' => $totalCount
            ]);
        }

        return redirect()->to(base_url('cart'));
    }

    public function remove($key)
    {
        $session = session();
        $cart = $session->get('cart') ?? [];
        
        if (isset($cart[$key])) {
            $productName = $cart[$key]['name'];
            unset($cart[$key]);
            $session->set('cart', $cart);
            return redirect()->to(base_url('cart'))->with('msg', $productName . ' removed from cart.');
        }
        
        return redirect()->to(base_url('cart'));
    }

    public function update()
    {
        $session = session();
        $cart = $session->get('cart') ?? [];
        $quantities = $this->request->getPost('quantity');
        $removedCount = 0;

        foreach ($quantities as $key => $qty) {
            if (isset($cart[$key])) {
                if ($qty <= 0) {
                    unset($cart[$key]);
                    $removedCount++;
                } else {
                    $cart[$key]['quantity'] = $qty;
                }
            }
        }

        $session->set('cart', $cart);
        $message = ($removedCount > 0) ? 'Cart updated and items removed.' : 'Cart updated successfully.';
        return redirect()->to(base_url('cart'))->with('msg', $message);
    }

    public function checkout()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('login'))->with('error', 'Please login to checkout.');
        }

        $isDirect = $this->request->getGet('direct') === '1';
        $session = session();

        if ($isDirect) {
            $item = $session->get('direct_order');
            if (!$item) return redirect()->to(base_url('menu'));
            $cart = ['direct' => $item];
        } else {
            $cart = $session->get('cart') ?? [];
            if (empty($cart)) return redirect()->to(base_url('menu'));
        }

        $userModel = new \App\Models\UserModel();
        $user = $userModel->find(session()->get('user_id'));

        return view('cart/checkout', [
            'title'    => 'Checkout', 
            'cart'     => $cart,
            'user'     => $user,
            'isDirect' => $isDirect
        ]);
    }

    public function processCheckout()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        $session = session();
        $isDirect = $this->request->getPost('is_direct') === '1';

        if ($isDirect) {
            $item = $session->get('direct_order');
            if (!$item) return redirect()->to(base_url('menu'));
            $cart = ['direct' => $item];
        } else {
            $cart = $session->get('cart') ?? [];
            if (empty($cart)) return redirect()->to(base_url('menu'));
        }

        $orderModel = new OrderModel();
        $orderItemModel = new OrderItemModel();
        $userModel = new \App\Models\UserModel();

        // Update user info
        $userId = $session->get('user_id');
        $phone = $this->request->getPost('phone');
        $address = $this->request->getPost('address');

        $userModel->update($userId, [
            'phone'   => $phone,
            'address' => $address
        ]);

        $totalAmount = 0;
        foreach ($cart as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }

        $orderId = $orderModel->insert([
            'user_id'      => $userId,
            'status'       => 'pending',
            'total_amount' => $totalAmount,
            'order_date'   => date('Y-m-d H:i:s')
        ]);

        foreach ($cart as $item) {
            $orderItemModel->insert([
                'order_id'   => $orderId,
                'product_id' => $item['id'],
                'size'       => $item['size'],
                'quantity'   => $item['quantity'],
                'price'      => $item['price']
            ]);
        }

        if ($isDirect) {
            $session->remove('direct_order');
        } else {
            $session->remove('cart');
        }

        // Task: Trigger Logic - Admin Notification
        $notifModel = new \App\Models\NotificationModel();
        $notifModel->insert([
            'user_id' => 2, // Admin ID from users table
            'message' => "New Order Received! Order #$orderId is waiting for your approval.",
            'link'    => 'admin/orders/' . $orderId
        ]);

        return redirect()->to(base_url('menu'))->with('popup_msg', 'Your order has been placed! Sit back and relax while we prepare your favorite treats with love. We\'ll notify you once it\'s on the way!');
    }
}
