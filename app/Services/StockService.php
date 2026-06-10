<?php

namespace App\Services;

use App\Models\ProductModel;
use App\Models\StockTransactionModel;

class StockService
{
    protected $productModel;
    protected $stockModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->stockModel = new StockTransactionModel();
    }

    // STOCK IN
    public function stockIn($data)
    {
        $product = $this->productModel->find($data['product_id']);

        if (!$product) {
            return [
                'status' => false,
                'code' => 404,
                'message' => 'Product not found'
            ];
        }

        $newStock = $product['stock'] + $data['qty'];

        $this->productModel->update($product['id'], [
            'stock' => $newStock
        ]);

        $this->stockModel->insert([
            'product_id' => $product['id'],
            'type' => 'IN',
            'qty' => $data['qty'],
            'notes' => $data['notes'] ?? null
        ]);

        return [
            'status' => true,
            'message' => 'Stock added successfully',
            'new_stock' => $newStock
        ];
    }

    // STOCK OUT
    public function stockOut($data)
    {
        $product = $this->productModel->find($data['product_id']);

        if (!$product) {
            return [
                'status' => false,
                'code' => 404,
                'message' => 'Product not found'
            ];
        }

        if ($data['qty'] > $product['stock']) {
            return [
                'status' => false,
                'code' => 400,
                'message' => 'Insufficient stock'
            ];
        }

        $newStock = $product['stock'] - $data['qty'];

        $this->productModel->update($product['id'], [
            'stock' => $newStock
        ]);

        $this->stockModel->insert([
            'product_id' => $product['id'],
            'type' => 'OUT',
            'qty' => $data['qty'],
            'notes' => $data['notes'] ?? null
        ]);

        return [
            'status' => true,
            'message' => 'Stock reduced successfully',
            'new_stock' => $newStock
        ];
    }

    // HISTORY
    public function getHistory()
    {
        return $this->stockModel
            ->select('stock_transactions.*, products.name as product_name')
            ->join('products', 'products.id = stock_transactions.product_id')
            ->orderBy('stock_transactions.id', 'DESC')
            ->findAll();
    }
}