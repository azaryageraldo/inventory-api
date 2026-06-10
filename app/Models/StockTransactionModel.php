<?php

namespace App\Models;

use CodeIgniter\Model;

class StockTransactionModel extends Model
{
    protected $table = 'stock_transactions';

    protected $allowedFields = [
        'product_id',
        'type',
        'qty',
        'notes'
    ];
}