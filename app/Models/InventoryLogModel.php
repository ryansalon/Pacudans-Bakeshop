<?php

namespace App\Models;

use CodeIgniter\Model;

class InventoryLogModel extends Model
{
    protected $table            = 'inventory_logs';
    protected $primaryKey       = 'log_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['product_id', 'change_quantity', 'reason', 'log_date'];

    // Dates
    protected $useTimestamps = false; // Using log_date instead
    
    // Validation
    protected $validationRules      = [
        'product_id'      => 'required|is_natural_no_zero',
        'change_quantity' => 'required|integer',
        'reason'          => 'required|string',
    ];
}
