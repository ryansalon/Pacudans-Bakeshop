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
}
