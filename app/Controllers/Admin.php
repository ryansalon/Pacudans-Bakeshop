<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\OrderModel;
use App\Models\OrderItemModel;

class Admin extends BaseController
{
    public function index()
    {
        $orderModel = new OrderModel();
        $productModel = new ProductModel();
        $orderItemModel = new OrderItemModel();
        
        // Product Popularity (Top 5)
        $topProducts = $orderItemModel->select('products.name, SUM(order_items.quantity) as total_sold')
                                      ->join('products', 'products.product_id = order_items.product_id')
                                      ->groupBy('order_items.product_id')
                                      ->orderBy('total_sold', 'DESC')
                                      ->limit(5)
                                      ->findAll();

        // Product Popularity (Bottom 5)
        $bottomProducts = $orderItemModel->select('products.name, SUM(order_items.quantity) as total_sold')
                                         ->join('products', 'products.product_id = order_items.product_id')
                                         ->groupBy('order_items.product_id')
                                         ->orderBy('total_sold', 'ASC')
                                         ->limit(5)
                                         ->findAll();

        // Revenue Board
        $revenueWeekly = $orderModel->selectSum('total_amount')
                                    ->where('created_at >=', date('Y-m-d', strtotime('-7 days')))
                                    ->first()['total_amount'] ?? 0;

        $revenueMonthly = $orderModel->selectSum('total_amount')
                                     ->where('created_at >=', date('Y-m-d', strtotime('-30 days')))
                                     ->first()['total_amount'] ?? 0;

        $revenueYearly = $orderModel->selectSum('total_amount')
                                    ->where('created_at >=', date('Y-m-d', strtotime('-365 days')))
                                    ->first()['total_amount'] ?? 0;

        $data = [
            'title'           => 'Admin Dashboard',
            'total_orders'    => $orderModel->countAll(),
            'pending_orders'  => $orderModel->where('status', 'pending')->countAllResults(),
            'total_products'  => $productModel->countAll(),
            'recent_orders'   => $orderModel->select('orders.*, users.name as customer_name')
                                            ->join('users', 'users.user_id = orders.user_id')
                                            ->orderBy('created_at', 'DESC')
                                            ->limit(5)->findAll(),
            'top_products'    => $topProducts,
            'bottom_products' => $bottomProducts,
            'revenue'         => [
                'weekly'  => $revenueWeekly,
                'monthly' => $revenueMonthly,
                'yearly'  => $revenueYearly
            ]
        ];

        return view('admin/dashboard', $data);
    }

    public function products()
    {
        $productModel = new ProductModel();
        $data = [
            'title'    => 'Manage Inventory',
            'products' => $productModel->select('products.*, categories.name as category_name')
                                       ->join('categories', 'categories.category_id = products.category_id')
                                       ->orderBy('categories.name', 'ASC')
                                       ->orderBy('products.name', 'ASC')
                                       ->findAll()
        ];
        return view('admin/products/index', $data);
    }

    public function addProduct()
    {
        $categoryModel = new CategoryModel();
        $data = [
            'title'      => 'Add New Product',
            'categories' => $categoryModel->findAll()
        ];
        return view('admin/products/add', $data);
    }

    public function storeProduct()
    {
        $productModel = new ProductModel();
        
        $rules = [
            'name'           => 'required|min_length[3]',
            'price'          => 'required|numeric',
            'category_id'    => 'required'
        ];

        if ($this->validate($rules)) {
            $productModel->save([
                'name'           => $this->request->getPost('name'),
                'description'    => $this->request->getPost('description'),
                'price'          => $this->request->getPost('price'),
                'category_id'    => $this->request->getPost('category_id'),
                'image_url'      => $this->request->getPost('image_url')
            ]);
            return redirect()->to(base_url('admin/products'))->with('msg', 'Product added successfully.');
        } else {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }
    }

    public function orders()
    {
        $orderModel = new OrderModel();
        $data = [
            'title'  => 'Manage Orders',
            'orders' => $orderModel->select('orders.*, users.name as customer_name')
                                   ->join('users', 'users.user_id = orders.user_id')
                                   ->orderBy('created_at', 'DESC')
                                   ->findAll()
        ];
        return view('admin/orders/index', $data);
    }

    public function viewOrder($id)
    {
        $orderModel = new OrderModel();
        $orderItemModel = new OrderItemModel();

        $order = $orderModel->select('orders.*, users.name as customer_name, users.email as customer_email')
                            ->join('users', 'users.user_id = orders.user_id')
                            ->find($id);

        if (!$order) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $items = $orderItemModel->select('order_items.*, products.name as product_name')
                                ->join('products', 'products.product_id = order_items.product_id')
                                ->where('order_id', $id)
                                ->findAll();

        $data = [
            'title' => 'Order Details #' . $id,
            'order' => $order,
            'items' => $items
        ];

        return view('admin/orders/view', $data);
    }

    public function updateOrderStatus()
    {
        $orderModel = new OrderModel();
        $orderId = $this->request->getPost('order_id');
        $status = $this->request->getPost('status');

        $order = $orderModel->find($orderId);
        
        if (!$order) {
            return redirect()->back()->with('error', 'Order not found.');
        }

        // Allow update only if currently pending OR if status is somehow empty
        $currentStatus = strtolower($order['status']);
        if ($currentStatus !== 'pending' && !empty($currentStatus)) {
            return redirect()->back()->with('error', 'Only pending orders can be updated.');
        }

        if (!$orderModel->update($orderId, ['status' => $status])) {
            $errors = $orderModel->errors();
            return redirect()->back()->with('error', 'Update failed: ' . implode(', ', $errors));
        }

        // Task: Trigger Logic - User Notification
        if ($status === 'completed') {
            $notifModel = new \App\Models\NotificationModel();
            $notifModel->insert([
                'user_id' => $order['user_id'],
                'message' => "Your order is complete! Delivery is on the way. Please prepare " . number_format($order['total_amount'], 2) . " pesos.",
                'link'    => 'profile/order/' . $orderId
            ]);
        }

        return redirect()->back()->with('msg', 'Order status updated to ' . ucfirst($status));
    }

    public function checkNewOrders()
    {
        $lastCheck = $this->request->getGet('last_check');
        $orderModel = new OrderModel();
        
        $newOrders = $orderModel->where('created_at >', $lastCheck)
                                ->countAllResults();
        
        return $this->response->setJSON(['new_orders' => $newOrders]);
    }
}
