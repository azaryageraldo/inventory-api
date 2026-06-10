<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->group('api', function($routes) {
    $routes->get('categories', 'Api\CategoryController::index');
    $routes->get('categories/(:num)', 'Api\CategoryController::show/$1');
    $routes->post('categories', 'Api\CategoryController::create');
    $routes->put('categories/(:num)', 'Api\CategoryController::update/$1');
    $routes->delete('categories/(:num)', 'Api\CategoryController::delete/$1');

    $routes->get('products', 'Api\ProductController::index');
    $routes->get('products/(:num)', 'Api\ProductController::show/$1');
    $routes->post('products', 'Api\ProductController::create');
    $routes->put('products/(:num)', 'Api\ProductController::update/$1');
    $routes->delete('products/(:num)', 'Api\ProductController::delete/$1');

    $routes->post('stock/in', 'Api\StockController::stockIn');
    $routes->post('stock/out', 'Api\StockController::stockOut');
    $routes->get('stock/history', 'Api\StockController::history');
});
