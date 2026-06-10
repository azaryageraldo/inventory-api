<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'category_id',
        'name',
        'price',
        'stock'
    ];

    protected $useTimestamps = true;

    protected $validationRules = [
        'category_id' => 'required|integer',
        'name'        => 'required|min_length[3]',
        'price' => 'required|numeric',
        'stock'       => 'required|integer'
    ];
}