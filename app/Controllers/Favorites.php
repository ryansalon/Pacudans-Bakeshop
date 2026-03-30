<?php

namespace App\Controllers;

use App\Models\FavoritesModel;
use App\Models\ProductModel;

class Favorites extends BaseController
{
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('login'))->with('error', 'Please login to view favorites.');
        }

        $favModel = new FavoritesModel();
        $productModel = new ProductModel();

        $favorites = $favModel->select('products.*, categories.name as category_name')
                             ->join('products', 'products.product_id = favorites.product_id')
                             ->join('categories', 'categories.category_id = products.category_id')
                             ->where('favorites.user_id', session()->get('user_id'))
                             ->findAll();

        $data = [
            'title'     => 'My Favorites',
            'favorites' => $favorites
        ];

        return view('favorites', $data);
    }

    public function toggle($productId)
    {
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please login first',
                'redirect' => base_url('login')
            ]);
        }

        $favModel = new FavoritesModel();
        $userId = session()->get('user_id');

        $existing = $favModel->where('user_id', $userId)
                            ->where('product_id', $productId)
                            ->first();

        if ($existing) {
            $favModel->delete($existing['favorite_id']);
            $action = 'removed';
            $msg = 'Removed from favorites';
        } else {
            $favModel->insert([
                'user_id'    => $userId,
                'product_id' => $productId
            ]);
            $action = 'added';
            $msg = 'Added to favorites!';
        }

        $count = $favModel->where('user_id', $userId)->countAllResults();

        return $this->response->setJSON([
            'success'   => true,
            'action'    => $action,
            'message'   => $msg,
            'fav_count' => $count
        ]);
    }

    public function remove($productId)
    {
        if (!session()->get('isLoggedIn')) return redirect()->to(base_url('login'));

        $favModel = new FavoritesModel();
        $favModel->where('user_id', session()->get('user_id'))
                 ->where('product_id', $productId)
                 ->delete();

        return redirect()->to(base_url('favorites'))->with('msg', 'Item removed from favorites.');
    }

    public function check($productId)
    {
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON(['isFavorite' => false]);
        }

        $favModel = new FavoritesModel();
        $userId = session()->get('user_id');
        $exists = $favModel->where('user_id', $userId)
                          ->where('product_id', $productId)
                          ->first();
        
        $count = $favModel->where('user_id', $userId)->countAllResults();

        return $this->response->setJSON([
            'isFavorite' => (bool)$exists,
            'fav_count'  => $count
        ]);
    }
}
