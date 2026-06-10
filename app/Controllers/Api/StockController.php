<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Services\StockService;

class StockController extends BaseController
{
    protected $stockService;

    public function __construct()
    {
        $this->stockService = new StockService();
    }

    // STOCK IN
    public function stockIn()
    {
        $data = $this->request->getJSON(true);

        $result = $this->stockService->stockIn($data);

        if (!$result['status']) {
            return $this->response
                ->setStatusCode($result['code'])
                ->setJSON($result);
        }

        return $this->response->setJSON($result);
    }

    // STOCK OUT
    public function stockOut()
    {
        $data = $this->request->getJSON(true);

        $result = $this->stockService->stockOut($data);

        if (!$result['status']) {
            return $this->response
                ->setStatusCode($result['code'])
                ->setJSON($result);
        }

        return $this->response->setJSON($result);
    }

    // HISTORY
    public function history()
    {
        $history = $this->stockService->getHistory();

        return $this->response->setJSON([
            'status' => true,
            'data' => $history
        ]);
    }
}