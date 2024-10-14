<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->group('/dashboard', ['namespace' => 'App\Controllers\Dashboard'], function ($routes) {
    $routes->get('product/trace/(:num)', 'Product::trace/$1');
    $routes->resource('category');
    $routes->resource('tag');
    $routes->resource('product');
    $routes->get('demo-pdf', 'Product::demoPdf');
    $routes->post('product/add-stock/(:num)/(:num)', 'Product::addStock/$1/$2');
    $routes->post('product/exit-stock/(:num)/(:num)', 'Product::exitStock/$1/$2');
    $routes->get('user/get-by-type/(:alpha)', 'User::getUsers/$1');
});
