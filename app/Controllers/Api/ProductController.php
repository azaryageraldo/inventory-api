<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\ProductModel;

class ProductController extends BaseController
{
    protected $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
    }

    // GET /products
    public function index()
    {
        $products = $this->productModel
            ->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id')
            ->findAll();

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Product list',
            'data' => $products
        ]);
    }

    // GET /products/{id}
    public function show($id)
    {
        $product = $this->productModel
            ->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id')
            ->find($id);

        if (!$product) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => false,
                'message' => 'Product not found'
            ]);
        }

        return $this->response->setJSON([
            'status' => true,
            'data' => $product
        ]);
    }

    // POST /products
    public function create()
    {
        $data = $this->request->getJSON(true);

        if (!$this->productModel->insert($data)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => false,
                'errors' => $this->productModel->errors()
            ]);
        }

        return $this->response->setStatusCode(201)->setJSON([
            'status' => true,
            'message' => 'Product created successfully'
        ]);
    }

    // PUT /products/{id}
    public function update($id)
    {
        $product = $this->productModel->find($id);

        if (!$product) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => false,
                'message' => 'Product not found'
            ]);
        }

        $data = $this->request->getJSON(true);

        if (!$this->productModel->update($id, $data)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => false,
                'errors' => $this->productModel->errors()
            ]);
        }

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Product updated successfully'
        ]);
    }

    // DELETE /products/{id}
    public function delete($id)
    {
        $product = $this->productModel->find($id);

        if (!$product) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => false,
                'message' => 'Product not found'
            ]);
        }

        $this->productModel->delete($id);

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Product deleted successfully'
        ]);
    }
}