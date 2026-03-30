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
        
        $data = [
            'title'          => 'Admin Dashboard',
            'total_orders'   => $orderModel->countAll(),
            'pending_orders' => $orderModel->where('status', 'pending')->countAllResults(),
            'total_products' => $productModel->countAll(),
            'recent_orders'  => $orderModel->select('orders.*, users.name as customer_name')
                                           ->join('users', 'users.user_id = orders.user_id')
                                           ->orderBy('created_at', 'DESC')
                                           ->limit(5)->findAll()
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

        return redirect()->back()->with('msg', 'Order status updated to ' . ucfirst($status));
    }
}
