<?php

namespace App\Services;

use App\Models\ProductModel;

class ProductService
{
    protected $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
    }

    public function getProducts($search = null, $perPage = 10)
    {
        $builder = $this->productModel
            ->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id');

        // SEARCH
        if ($search) {
            $builder->like('products.name', $search);
        }

        return [
            'products' => $builder->paginate($perPage),
            'pager' => $this->productModel->pager
        ];
    }
}