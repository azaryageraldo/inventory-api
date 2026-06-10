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

    // GET PRODUCTS
    public function getProducts($search = null, $perPage = 10)
    {
        $builder = $this->productModel
            ->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id');

        if ($search) {
            $builder->like('products.name', $search);
        }

        return [
            'status' => true,
            'message' => 'Product list',
            'data' => $builder->paginate($perPage),
            'pagination' => [
                'current_page' => $this->productModel->pager->getCurrentPage(),
                'per_page' => $this->productModel->pager->getPerPage(),
                'total' => $this->productModel->pager->getTotal(),
                'last_page' => $this->productModel->pager->getPageCount(),
            ]
        ];
    }

    // GET PRODUCT DETAIL
    public function getProductById($id)
    {
        $product = $this->productModel
            ->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id')
            ->find($id);

        if (!$product) {
            return [
                'status' => false,
                'code' => 404,
                'message' => 'Product not found'
            ];
        }

        return [
            'status' => true,
            'data' => $product
        ];
    }

    // CREATE PRODUCT
    public function createProduct($data)
    {
        if (!$this->productModel->insert($data)) {
            return [
                'status' => false,
                'code' => 400,
                'errors' => $this->productModel->errors()
            ];
        }

        return [
            'status' => true,
            'message' => 'Product created successfully'
        ];
    }

    // UPDATE PRODUCT
    public function updateProduct($id, $data)
    {
        $product = $this->productModel->find($id);

        if (!$product) {
            return [
                'status' => false,
                'code' => 404,
                'message' => 'Product not found'
            ];
        }

        if (!$this->productModel->update($id, $data)) {
            return [
                'status' => false,
                'code' => 400,
                'errors' => $this->productModel->errors()
            ];
        }

        return [
            'status' => true,
            'message' => 'Product updated successfully'
        ];
    }

    // DELETE PRODUCT
    public function deleteProduct($id)
    {
        $product = $this->productModel->find($id);

        if (!$product) {
            return [
                'status' => false,
                'code' => 404,
                'message' => 'Product not found'
            ];
        }

        $this->productModel->delete($id);

        return [
            'status' => true,
            'message' => 'Product deleted successfully'
        ];
    }
}