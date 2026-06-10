<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\StockTransactionModel;

class StockController extends BaseController
{
    protected $productModel;
    protected $stockModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->stockModel = new StockTransactionModel();
    }

    // STOCK IN
    public function stockIn()
    {
        $data = $this->request->getJSON(true);

        $product = $this->productModel->find($data['product_id']);

        if (!$product) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => false,
                'message' => 'Product not found'
            ]);
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

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Stock added successfully',
            'new_stock' => $newStock
        ]);
    }

    // STOCK OUT
    public function stockOut()
    {
        $data = $this->request->getJSON(true);

        $product = $this->productModel->find($data['product_id']);

        if (!$product) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => false,
                'message' => 'Product not found'
            ]);
        }

        if ($data['qty'] > $product['stock']) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => false,
                'message' => 'Insufficient stock'
            ]);
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

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Stock reduced successfully',
            'new_stock' => $newStock
        ]);
    }

    // HISTORY
    public function history()
    {
        $history = $this->stockModel
            ->select('stock_transactions.*, products.name as product_name')
            ->join('products', 'products.id = stock_transactions.product_id')
            ->orderBy('stock_transactions.id', 'DESC')
            ->findAll();

        return $this->response->setJSON([
            'status' => true,
            'data' => $history
        ]);
    }
}