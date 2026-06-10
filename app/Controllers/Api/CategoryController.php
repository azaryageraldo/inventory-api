<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Services\CategoryService;

class CategoryController extends BaseController
{
    protected $categoryService;

    public function __construct()
    {
        $this->categoryService = new CategoryService();
    }

    // GET CATEGORIES
    public function index()
    {
        $result = $this->categoryService->getCategories();

        return $this->response->setJSON($result);
    }

    // GET CATEGORY DETAIL
    public function show($id)
    {
        $result = $this->categoryService->getCategoryById($id);

        if (!$result['status']) {
            return $this->response
                ->setStatusCode($result['code'])
                ->setJSON($result);
        }

        return $this->response->setJSON($result);
    }

    // CREATE CATEGORY
    public function create()
    {
        $data = $this->request->getJSON(true);

        $result = $this->categoryService->createCategory($data);

        if (!$result['status']) {
            return $this->response
                ->setStatusCode($result['code'])
                ->setJSON($result);
        }

        return $this->response
            ->setStatusCode(201)
            ->setJSON($result);
    }

    // UPDATE CATEGORY
    public function update($id)
    {
        $data = $this->request->getJSON(true);

        $result = $this->categoryService->updateCategory($id, $data);

        if (!$result['status']) {
            return $this->response
                ->setStatusCode($result['code'])
                ->setJSON($result);
        }

        return $this->response->setJSON($result);
    }

    // DELETE CATEGORY
    public function delete($id)
    {
        $result = $this->categoryService->deleteCategory($id);

        if (!$result['status']) {
            return $this->response
                ->setStatusCode($result['code'])
                ->setJSON($result);
        }

        return $this->response->setJSON($result);
    }
}