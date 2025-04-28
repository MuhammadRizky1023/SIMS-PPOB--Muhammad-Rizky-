<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Default route
$routes->get('/', 'Auth::login');

// Auth Routes
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::login');
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::register');
$routes->get('/logout', 'Auth::logout');

// Dashboard Route
$routes->get('/dashboard', 'Dashboard::index');

// Profile Routes
$routes->get('/profile', 'Profile::index');
$routes->post('/profile/update', 'Profile::update');
$routes->post('/profile/upload-image', 'Profile::updateImage');

// Transaction Routes
$routes->get('/transaction/topup', 'Transaction::topup');
$routes->post('/transaction/topup', 'Transaction::topup');

$routes->post('/transaction/pay', 'Transaction::payTransaction');

$routes->get('/transaction/history', 'Transaction::history');
// OPSIONAL: 404 Override (jika URL tidak ditemukan)
$routes->set404Override(function() {
    return view('errors/html/error_404');
});