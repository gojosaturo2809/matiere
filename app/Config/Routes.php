<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Routes pour l'Admin
$routes->get('/login', 'AdminController::login');
$routes->post('/admin/authenticate', 'AdminController::authenticate');
$routes->get('/logout', 'AdminController::logout');
// $routes->get('/dashboard', 'AdminController::dashboard'); // Assurez-vous de créer cette méthode s'il y a une redirection vers le dashboard
