<?php

namespace App\Models;

use CodeIgniter\Model;

class FavoritesModel extends Model
{
    protected $table            = 'favorites';
    protected $primaryKey       = 'favorite_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['user_id', 'product_id'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = ''; // No updated_at for favorites
}
