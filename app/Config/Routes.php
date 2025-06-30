<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Default landing page
$routes->setDefaultController('HomeController');
$routes->setDefaultMethod('index');
$routes->get('/', 'HomeController::index');
$routes->post('/toggle-saldo', 'HomeController::toggleSaldo');
// Auth
$routes->get('/login', 'AuthController::login');
$routes->post('/login', 'AuthController::login');
$routes->get('/register', 'AuthController::register');
$routes->post('/register', 'AuthController::register');
$routes->get('/logout', 'AuthController::logout');
// Profile
$routes->get('/profile', 'ProfileController::index');
$routes->post('/profile/update', 'ProfileController::update');
$routes->post('/profile/image', 'ProfileController::updateImage');
// Transaction
$routes->get('/balance', 'TransactionController::balance');
$routes->get('/topup', 'TransactionController::topup');
$routes->post('/topup', 'TransactionController::topup');
$routes->get('/pay', 'TransactionController::pay');
$routes->post('/pay', 'TransactionController::pay');
$routes->get('/transaction/history', 'TransactionController::history');

// 404
$routes->set404Override(function () {
    return view('errors/html/error_404');
});
