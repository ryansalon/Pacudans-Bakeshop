<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\ProductVariantModel;

class Product extends BaseController
{
    public function index()
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();

        $products = $productModel->select('products.*, categories.name as category_name, MIN(product_variants.price) as min_price, COUNT(product_variants.variant_id) as variant_count')
                                 ->join('categories', 'categories.category_id = products.category_id', 'left')
                                 ->join('product_variants', 'product_variants.product_id = products.product_id', 'left')
                                 ->groupBy('products.product_id')
                                 ->orderBy('categories.category_id', 'ASC')
                                 ->orderBy('products.name', 'ASC')
                                 ->findAll();

        $data = [
            'products'   => $products,
            'categories' => $categoryModel->findAll(),
            'title'      => 'Our Menu'
        ];

        return view('products/index', $data);
    }

    public function show($id = null)
    {
        $productModel = new ProductModel();
        $variantModel = new ProductVariantModel();

        $product = $productModel->select('products.*, categories.name as category_name')
                                ->join('categories', 'categories.category_id = products.category_id', 'left')
                                ->find($id);

        if (!$product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $variants = $variantModel->where('product_id', $id)->orderBy('price', 'ASC')->findAll();

        $data = [
            'product'  => $product,
            'variants' => $variants,
            'title'    => $product['name']
        ];

        return view('products/show', $data);
    }

    public function category($id = null)
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();

        $category = $categoryModel->find($id);
        if (!$category) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $products = $productModel->select('products.*, categories.name as category_name, MIN(product_variants.price) as min_price, COUNT(product_variants.variant_id) as variant_count')
                                 ->join('categories', 'categories.category_id = products.category_id', 'left')
                                 ->join('product_variants', 'product_variants.product_id = products.product_id', 'left')
                                 ->where('products.category_id', $id)
                                 ->groupBy('products.product_id')
                                 ->orderBy('products.name', 'ASC')
                                 ->findAll();

        $data = [
            'products'   => $products,
            'categories' => $categoryModel->findAll(),
            'category'   => $category,
            'title'      => $category['name']
        ];

        return view('products/index', $data);
    }
}
