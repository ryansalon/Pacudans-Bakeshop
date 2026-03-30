<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table            = 'orders';
    protected $primaryKey       = 'order_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['user_id', 'order_date', 'status', 'total_amount'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'user_id'      => 'required|is_natural_no_zero',
        'status'       => 'required|in_list[pending,completed,cancelled]',
        'total_amount' => 'required|numeric',
    ];
}
