<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\ProductVariantModel;
use App\Models\InventoryLogModel;
use App\Models\UserModel;
use App\Models\NotificationModel;

class Cart extends BaseController
{
    public function index()
    {
        $session = session();
        $cart = $session->get('cart') ?? [];

        return view('cart/index', [
            'cart'  => $cart,
            'title' => 'Shopping Cart'
        ]);
    }

    public function add()
    {
        $session = session();
        $productModel = new ProductModel();
        $variantModel = new ProductVariantModel();

        $productId = $this->request->getPost('product_id');
        $variantId = $this->request->getPost('variant_id');
        $quantity = max(1, (int) ($this->request->getPost('quantity') ?? 1));
        $isBuyNow = (string) $this->request->getPost('buy_now') === '1';

        $product = $productModel->find($productId);
        if (!$product) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['success' => false, 'message' => 'Product not found.']);
            }
            return redirect()->back()->with('error', 'Product not found.');
        }

        if ((int) $product['stock_quantity'] <= 0) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['success' => false, 'message' => 'This item is currently out of stock.']);
            }
            return redirect()->back()->with('error', 'This item is currently out of stock.');
        }

        $cartPrice = $product['price'];
        $sizeName = '';
        $cartKey = 'p' . $productId;

        if ($variantId) {
            $variant = $variantModel->where('product_id', $productId)->find($variantId);
            if ($variant) {
                $cartPrice = $variant['price'];
                $sizeName = $variant['size_name'];
                $cartKey = 'v' . $variantId;
            }
        } else {
            // If added from grid and variants exist, default to the lowest-priced variant
            $defaultVariant = $variantModel->where('product_id', $productId)->orderBy('price', 'ASC')->first();
            if ($defaultVariant) {
                $variantId = $defaultVariant['variant_id'];
                $cartPrice = $defaultVariant['price'];
                $sizeName = $defaultVariant['size_name'];
                $cartKey = 'v' . $variantId;
            }
        }

        if ($isBuyNow) {
            // Store direct_order separately without destroying the user's main cart
            $directItem = [
                'id'         => $product['product_id'],
                'variant_id' => $variantId,
                'name'       => $product['name'],
                'size'       => $sizeName,
                'price'      => $cartPrice,
                'image'      => $product['image_url'],
                'quantity'   => min($quantity, (int) $product['stock_quantity'])
            ];

            $session->set('direct_order', $directItem);
            return redirect()->to(base_url('checkout?direct=1'));
        }

        $cart = $session->get('cart') ?? [];
        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] = min((int) $product['stock_quantity'], $cart[$cartKey]['quantity'] + $quantity);
        } else {
            $cart[$cartKey] = [
                'id'         => $product['product_id'],
                'variant_id' => $variantId,
                'name'       => $product['name'],
                'size'       => $sizeName,
                'price'      => $cartPrice,
                'image'      => $product['image_url'],
                'quantity'   => min($quantity, (int) $product['stock_quantity'])
            ];
        }

        $session->set('cart', $cart);

        $totalCount = 0;
        foreach ($cart as $item) {
            $totalCount += $item['quantity'];
        }

        $addedMsg = 'Added ' . $product['name'] . ($sizeName ? " ($sizeName)" : '') . ' to cart.';

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success'    => true,
                'message'    => $addedMsg,
                'cart_count' => $totalCount
            ]);
        }

        return redirect()->to(base_url('cart'))->with('msg', $addedMsg);
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
        $quantities = $this->request->getPost('quantity') ?? [];
        $removedCount = 0;

        foreach ($quantities as $key => $qty) {
            $qty = (int) $qty;
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
        $message = ($removedCount > 0) ? 'Cart updated and items removed.' : 'Cart quantities updated.';
        return redirect()->to(base_url('cart'))->with('msg', $message);
    }

    public function checkout()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('login'))->with('error', 'Please sign in to proceed to checkout.');
        }

        $isDirect = $this->request->getGet('direct') === '1';
        $session = session();

        if ($isDirect) {
            $item = $session->get('direct_order');
            if (!$item) {
                return redirect()->to(base_url('menu'));
            }
            $cart = ['direct' => $item];
        } else {
            $cart = $session->get('cart') ?? [];
            if (empty($cart)) {
                return redirect()->to(base_url('menu'));
            }
        }

        $userModel = new UserModel();
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
            if (!$item) {
                return redirect()->to(base_url('menu'));
            }
            $cart = ['direct' => $item];
        } else {
            $cart = $session->get('cart') ?? [];
            if (empty($cart)) {
                return redirect()->to(base_url('menu'));
            }
        }

        $orderModel = new OrderModel();
        $orderItemModel = new OrderItemModel();
        $productModel = new ProductModel();
        $inventoryLogModel = new InventoryLogModel();
        $userModel = new UserModel();

        $userId = $session->get('user_id');
        $phone = trim((string) $this->request->getPost('phone'));
        $address = trim((string) $this->request->getPost('address'));

        if ($phone === '' || $address === '') {
            return redirect()->back()->withInput()->with('error', 'Please provide both contact number and delivery address.');
        }

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

            $product = $productModel->find($item['id']);
            if ($product) {
                $newStock = max(0, (int) $product['stock_quantity'] - (int) $item['quantity']);
                $productModel->update($item['id'], ['stock_quantity' => $newStock]);
                $inventoryLogModel->insert([
                    'product_id'      => $item['id'],
                    'change_quantity' => -((int) $item['quantity']),
                    'reason'          => 'Order #' . $orderId,
                    'log_date'        => date('Y-m-d H:i:s')
                ]);
            }
        }

        if ($isDirect) {
            $session->remove('direct_order');
        } else {
            $session->remove('cart');
        }

        // Notify all admin users dynamically instead of hardcoding user_id = 2
        $notifModel = new NotificationModel();
        $admins = $userModel->where('role', 'admin')->findAll();
        foreach ($admins as $admin) {
            $notifModel->insert([
                'user_id' => $admin['user_id'],
                'message' => "New Order #$orderId received and waiting for approval.",
                'link'    => 'admin/orders/' . $orderId
            ]);
        }

        return redirect()->to(base_url('menu'))->with('popup_msg', 'Your order has been placed! Sit back and relax while we prepare your treats. We will notify you once it is on the way.');
    }
}
