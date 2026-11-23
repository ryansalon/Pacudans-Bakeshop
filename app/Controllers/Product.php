<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\ProductVariantModel;

class Product extends BaseController
{
    private function getAllProductsWithMeta(): array
    {
        $productModel = new ProductModel();
        return $productModel->select('products.*, categories.name as category_name, MIN(product_variants.price) as min_price, COUNT(product_variants.variant_id) as variant_count')
                            ->join('categories', 'categories.category_id = products.category_id', 'left')
                            ->join('product_variants', 'product_variants.product_id = products.product_id', 'left')
                            ->groupBy('products.product_id')
                            ->orderBy('categories.category_id', 'ASC')
                            ->orderBy('products.name', 'ASC')
                            ->findAll();
    }

    public function index()
    {
        $categoryModel = new CategoryModel();

        return view('products/index', [
            'products'         => $this->getAllProductsWithMeta(),
            'categories'       => $categoryModel->orderBy('category_id', 'ASC')->findAll(),
            'activeCategoryId' => 0,
            'title'            => 'Our Menu'
        ]);
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

        return view('products/show', [
            'product'  => $product,
            'variants' => $variants,
            'title'    => rtrim((string) $product['name'], '*')
        ]);
    }

    public function category($id = null)
    {
        $categoryModel = new CategoryModel();
        $category = $categoryModel->find($id);

        if (!$category) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('products/index', [
            'products'         => $this->getAllProductsWithMeta(),
            'categories'       => $categoryModel->orderBy('category_id', 'ASC')->findAll(),
            'category'         => $category,
            'activeCategoryId' => (int) $category['category_id'],
            'title'            => $category['name']
        ]);
    }
}
