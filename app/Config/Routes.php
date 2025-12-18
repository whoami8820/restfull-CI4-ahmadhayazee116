<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Route untuk halaman utama - Welcome message
$routes->get('/', static function () {
    return json_encode([
        'status' => 'success',
        'message' => 'Welcome to RESTful API CI4',
        'endpoints' => [
            'GET /api/produk' => 'Get all products',
            'GET /api/produk/{id}' => 'Get product by ID',
            'POST /api/produk' => 'Create new product',
            'PUT /api/produk/{id}' => 'Update product',
            'DELETE /api/produk/{id}' => 'Delete product'
        ]
    ]);
});

// Routes untuk API Produk
$routes->group('api', ['namespace' => 'App\Controllers\Api'], function($routes) {
    // Routes untuk produk
    $routes->get('produk', 'Produk::index');
    $routes->get('produk/(:num)', 'Produk::show/$1');
    $routes->post('produk', 'Produk::create');
    $routes->put('produk/(:num)', 'Produk::update/$1');
    $routes->delete('produk/(:num)', 'Produk::delete/$1');
});