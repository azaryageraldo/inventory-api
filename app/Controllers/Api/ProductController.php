<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Services\ProductService;

class ProductController extends BaseController
{
    protected $productService;

    public function __construct()
    {
        $this->productService = new ProductService();
    }

    // GET PRODUCTS
    public function index()
    {
        $search = $this->request->getGet('search');
        $perPage = $this->request->getGet('per_page') ?? 10;

        $result = $this->productService->getProducts($search, $perPage);

        return $this->response->setJSON($result);
    }

    // GET PRODUCT DETAIL
    public function show($id)
    {
        $result = $this->productService->getProductById($id);

        if (!$result['status']) {
            return $this->response
                ->setStatusCode($result['code'])
                ->setJSON($result);
        }

        return $this->response->setJSON($result);
    }

    // CREATE PRODUCT
    public function create()
    {
        $data = $this->request->getJSON(true);

        $result = $this->productService->createProduct($data);

        if (!$result['status']) {
            return $this->response
                ->setStatusCode($result['code'])
                ->setJSON($result);
        }

        return $this->response
            ->setStatusCode(201)
            ->setJSON($result);
    }

    // UPDATE PRODUCT
    public function update($id)
    {
        $data = $this->request->getJSON(true);

        $result = $this->productService->updateProduct($id, $data);

        if (!$result['status']) {
            return $this->response
                ->setStatusCode($result['code'])
                ->setJSON($result);
        }

        return $this->response->setJSON($result);
    }

    // DELETE PRODUCT
    public function delete($id)
    {
        $result = $this->productService->deleteProduct($id);

        if (!$result['status']) {
            return $this->response
                ->setStatusCode($result['code'])
                ->setJSON($result);
        }

        return $this->response->setJSON($result);
    }
}