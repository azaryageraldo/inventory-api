<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->group('api', function($routes) {
    $routes->get('categories', 'Api\CategoryController::index');
    $routes->get('categories/(:num)', 'Api\CategoryController::show/$1');
    $routes->post('categories', 'Api\CategoryController::create');
    $routes->put('categories/(:num)', 'Api\CategoryController::update/$1');
    $routes->delete('categories/(:num)', 'Api\CategoryController::delete/$1');
});
