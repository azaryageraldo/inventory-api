<?php

namespace App\Services;

use App\Models\CategoryModel;

class CategoryService
{
    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    // GET ALL CATEGORIES
    public function getCategories()
    {
        return [
            'status' => true,
            'message' => 'Category list',
            'data' => $this->categoryModel->findAll()
        ];
    }

    // GET CATEGORY BY ID
    public function getCategoryById($id)
    {
        $category = $this->categoryModel->find($id);

        if (!$category) {
            return [
                'status' => false,
                'code' => 404,
                'message' => 'Category not found'
            ];
        }

        return [
            'status' => true,
            'data' => $category
        ];
    }

    // CREATE CATEGORY
    public function createCategory($data)
    {
        if (!$this->categoryModel->insert($data)) {
            return [
                'status' => false,
                'code' => 400,
                'message' => 'Validation failed',
                'errors' => $this->categoryModel->errors()
            ];
        }

        return [
            'status' => true,
            'message' => 'Category created successfully'
        ];
    }

    // UPDATE CATEGORY
    public function updateCategory($id, $data)
    {
        $category = $this->categoryModel->find($id);

        if (!$category) {
            return [
                'status' => false,
                'code' => 404,
                'message' => 'Category not found'
            ];
        }

        if (!$this->categoryModel->update($id, $data)) {
            return [
                'status' => false,
                'code' => 400,
                'message' => 'Validation failed',
                'errors' => $this->categoryModel->errors()
            ];
        }

        return [
            'status' => true,
            'message' => 'Category updated successfully'
        ];
    }

    // DELETE CATEGORY
    public function deleteCategory($id)
    {
        $category = $this->categoryModel->find($id);

        if (!$category) {
            return [
                'status' => false,
                'code' => 404,
                'message' => 'Category not found'
            ];
        }

        $this->categoryModel->delete($id);

        return [
            'status' => true,
            'message' => 'Category deleted successfully'
        ];
    }
}