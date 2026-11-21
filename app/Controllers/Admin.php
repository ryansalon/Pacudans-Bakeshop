<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\NotificationModel;

class Admin extends BaseController
{
    public function index()
    {
        $orderModel = new OrderModel();
        $productModel = new ProductModel();
        $orderItemModel = new OrderItemModel();

        $topProducts = $orderItemModel->select('products.name, SUM(order_items.quantity) as total_sold')
                                      ->join('products', 'products.product_id = order_items.product_id')
                                      ->groupBy('order_items.product_id')
                                      ->orderBy('total_sold', 'DESC')
                                      ->limit(5)
                                      ->findAll();

        $bottomProducts = $orderItemModel->select('products.name, SUM(order_items.quantity) as total_sold')
                                         ->join('products', 'products.product_id = order_items.product_id')
                                         ->groupBy('order_items.product_id')
                                         ->orderBy('total_sold', 'ASC')
                                         ->limit(5)
                                         ->findAll();

        $revenueWeekly = $orderModel->selectSum('total_amount')
                                    ->where('status !=', 'cancelled')
                                    ->where('created_at >=', date('Y-m-d', strtotime('-7 days')))
                                    ->first()['total_amount'] ?? 0;

        $revenueMonthly = $orderModel->selectSum('total_amount')
                                     ->where('status !=', 'cancelled')
                                     ->where('created_at >=', date('Y-m-d', strtotime('-30 days')))
                                     ->first()['total_amount'] ?? 0;

        $revenueYearly = $orderModel->selectSum('total_amount')
                                    ->where('status !=', 'cancelled')
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
        $categoryModel = new CategoryModel();
        $data = [
            'title'      => 'Manage Inventory',
            'categories' => $categoryModel->orderBy('name', 'ASC')->findAll(),
            'products'   => $productModel->select('products.*, categories.name as category_name')
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
        return view('admin/products/add', [
            'title'      => 'Add New Product',
            'categories' => $categoryModel->findAll()
        ]);
    }

    public function storeProduct()
    {
        $productModel = new ProductModel();

        $rules = [
            'name'           => 'required|min_length[3]',
            'price'          => 'required|numeric',
            'category_id'    => 'required|is_natural_no_zero',
            'stock_quantity' => 'permit_empty|is_natural'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $imageUrl = trim((string) $this->request->getPost('image_url'));
        $imageFile = $this->request->getFile('image_file');
        if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
            $uploadDir = FCPATH . 'assets/images/uploads';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0775, true);
            }
            $newName = $imageFile->getRandomName();
            $imageFile->move($uploadDir, $newName);
            $imageUrl = 'assets/images/uploads/' . $newName;
        }

        $stockQty = $this->request->getPost('stock_quantity');
        $stockQty = ($stockQty === null || $stockQty === '') ? 100 : (int) $stockQty;

        $productModel->save([
            'name'           => trim((string) $this->request->getPost('name')),
            'description'    => trim((string) $this->request->getPost('description')),
            'price'          => $this->request->getPost('price'),
            'category_id'    => $this->request->getPost('category_id'),
            'stock_quantity' => $stockQty,
            'image_url'      => $imageUrl
        ]);

        return redirect()->to(base_url('admin/products'))->with('msg', 'Product added to menu.');
    }

    public function updateProduct()
    {
        $productModel = new ProductModel();
        $productId = (int) $this->request->getPost('product_id');

        $product = $productModel->find($productId);
        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        $rules = [
            'name'           => 'required|min_length[3]',
            'price'          => 'required|numeric',
            'category_id'    => 'required|is_natural_no_zero',
            'stock_quantity' => 'required|is_natural'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', 'Please enter valid product details.');
        }

        $updateData = [
            'name'           => trim((string) $this->request->getPost('name')),
            'description'    => trim((string) $this->request->getPost('description')),
            'price'          => $this->request->getPost('price'),
            'category_id'    => (int) $this->request->getPost('category_id'),
            'stock_quantity' => (int) $this->request->getPost('stock_quantity'),
        ];

        $imageUrl = trim((string) $this->request->getPost('image_url'));
        if ($imageUrl !== '') {
            $updateData['image_url'] = $imageUrl;
        }

        $imageFile = $this->request->getFile('image_file');
        if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
            $uploadDir = FCPATH . 'assets/images/uploads';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0775, true);
            }
            $newName = $imageFile->getRandomName();
            $imageFile->move($uploadDir, $newName);
            $updateData['image_url'] = 'assets/images/uploads/' . $newName;
        }

        $productModel->update($productId, $updateData);
        return redirect()->to(base_url('admin/products'))->with('msg', 'Product "' . $updateData['name'] . '" updated.');
    }

    public function deleteProduct($id)
    {
        $productModel = new ProductModel();
        $product = $productModel->find($id);

        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        $productModel->delete($id);
        return redirect()->to(base_url('admin/products'))->with('msg', 'Product "' . $product['name'] . '" removed.');
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

        $order = $orderModel->select('orders.*, users.name as customer_name, users.email as customer_email, users.phone as customer_phone, users.address as customer_address')
                            ->join('users', 'users.user_id = orders.user_id')
                            ->find($id);

        if (!$order) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $items = $orderItemModel->select('order_items.*, products.name as product_name')
                                ->join('products', 'products.product_id = order_items.product_id')
                                ->where('order_id', $id)
                                ->findAll();

        return view('admin/orders/view', [
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
