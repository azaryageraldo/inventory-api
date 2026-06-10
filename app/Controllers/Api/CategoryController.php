<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use CodeIgniter\HTTP\ResponseInterface;

class CategoryController extends BaseController
{
    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    // GET /categories
    public function index()
    {
        $categories = $this->categoryModel->findAll();

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Category list',
            'data' => $categories
        ]);
    }

    // GET /categories/{id}
    public function show($id)
    {
        $category = $this->categoryModel->find($id);

        if (!$category) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => false,
                'message' => 'Category not found'
            ]);
        }

        return $this->response->setJSON([
            'status' => true,
            'data' => $category
        ]);
    }

    // POST /categories
    public function create()
    {
        $data = $this->request->getJSON(true);

        if (!$this->categoryModel->insert($data)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $this->categoryModel->errors()
            ]);
        }

        return $this->response->setStatusCode(201)->setJSON([
            'status' => true,
            'message' => 'Category created successfully'
        ]);
    }

    // PUT /categories/{id}
    public function update($id = null)
    {
        $category = $this->categoryModel->find($id);

        if (!$category) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => false,
                'message' => 'Category not found'
            ]);
        }

        $data = $this->request->getJSON(true);

        if (!$this->categoryModel->update($id, $data)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $this->categoryModel->errors()
            ]);
        }

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Category updated successfully'
        ]);
    }

    // DELETE /categories/{id}
    public function delete($id = null)
    {
        $category = $this->categoryModel->find($id);

        if (!$category) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => false,
                'message' => 'Category not found'
            ]);
        }

        $this->categoryModel->delete($id);

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Category deleted successfully'
        ]);
    }
}