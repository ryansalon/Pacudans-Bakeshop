<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Home extends BaseController
{
    public function index()
    {
        $productModel = new ProductModel();
        
        // Use the current date (as an integer) to seed the random number generator
        // This ensures the same products are shown all day, but change at midnight
        $seed = date('Ymd');
        $dayName = date('l');
        
        $data = [
            // Fetch 4 "random" products seeded by current date
            'featured_products' => $productModel->orderBy("RAND($seed)")->limit(4)->findAll(),
            'current_day'       => $dayName,
            'title'             => 'Welcome to Pacudan\'s Bakeshop'
        ];

        return view('home', $data);
    }

    public function checkOrderStatus()
    {
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON(['updated' => 0]);
        }

        $userId = session()->get('user_id');
        $lastCheck = $this->request->getGet('last_check');
        $orderModel = new \App\Models\OrderModel();

        $updatedOrders = $orderModel->where('user_id', $userId)
                                    ->where('updated_at >', $lastCheck)
                                    ->where('updated_at !=', 'created_at') // only actual updates
                                    ->countAllResults();

        return $this->response->setJSON(['updated' => $updatedOrders]);
    }

    public function getNotificationCount()
    {
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON(['count' => 0]);
        }

        $orderModel = new \App\Models\OrderModel();
        
        if (session()->get('role') === 'admin') {
            // Count how many customers ordered (Pending orders)
            $count = $orderModel->where('status', 'pending')->countAllResults();
        } else {
            // Count current active orders for user
            $count = $orderModel->where('user_id', session()->get('user_id'))
                                ->where('status', 'pending')
                                ->countAllResults();
        }

        return $this->response->setJSON(['count' => $count]);
    }
}
