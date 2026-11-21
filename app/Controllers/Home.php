<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;

class Home extends BaseController
{
    public function index()
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();

        $seed = date('Ymd');
        $dayName = date('l');

        $featured = $productModel->select('products.*, categories.name as category_name, MIN(product_variants.price) as min_price, COUNT(product_variants.variant_id) as variant_count')
                                 ->join('categories', 'categories.category_id = products.category_id', 'left')
                                 ->join('product_variants', 'product_variants.product_id = products.product_id', 'left')
                                 ->groupBy('products.product_id')
                                 ->orderBy("RAND($seed)")
                                 ->limit(4)
                                 ->findAll();

        // Pick a whole celebration cake (highest-priced cake with an image) for the masthead tile
        $signature = $productModel->select('products.*, categories.name as category_name')
                                  ->join('categories', 'categories.category_id = products.category_id', 'left')
                                  ->where('categories.name', 'Cakes')
                                  ->where('products.price >=', 100)
                                  ->orderBy('products.price', 'DESC')
                                  ->first();
        if (!$signature) {
            $signature = $productModel->select('products.*, categories.name as category_name')
                                      ->join('categories', 'categories.category_id = products.category_id', 'left')
                                      ->orderBy('products.price', 'DESC')
                                      ->first();
        }

        // Compute live price ranges so page copy never contradicts actual DB catalog prices
        $priceBounds = $productModel->selectMin('price', 'min_p')->selectMax('price', 'max_p')->first();
        $categories = $categoryModel->orderBy('category_id', 'ASC')->findAll();
        $totalProducts = $productModel->countAll();

        $data = [
            'featured_products' => $featured,
            'signature_product' => $signature,
            'categories'        => $categories,
            'total_products'    => $totalProducts,
            'min_price'         => (float) ($priceBounds['min_p'] ?? 0),
            'max_price'         => (float) ($priceBounds['max_p'] ?? 0),
            'current_day'       => $dayName,
            'title'             => 'Pacudan\'s Bakeshop & Coffee Bar'
        ];

        return view('home', $data);
    }
}
