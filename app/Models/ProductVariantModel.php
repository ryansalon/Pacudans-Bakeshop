<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductVariantModel extends Model
{
    protected $table            = 'product_variants';
    protected $primaryKey       = 'variant_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['product_id', 'size_name', 'price', 'stock_quantity'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
