<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderItemModel extends Model
{
    protected $table            = 'order_items';
    protected $primaryKey       = 'order_item_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['order_id', 'product_id', 'size', 'quantity', 'price'];

    // Dates
    protected $useTimestamps = false; 
    protected $createdField  = 'created_at';

    // Validation
    protected $validationRules      = [
        'order_id'   => 'required|is_natural_no_zero',
        'product_id' => 'required|is_natural_no_zero',
        'quantity'   => 'required|is_natural_no_zero',
        'price'      => 'required|numeric',
    ];
}
