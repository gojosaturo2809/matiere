<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/dashboard', 'Dashboard::index');
$routes->get('dashboard', 'Dashboard::index');
$routes->get('notes', 'Note::index');
$routes->get('notes/create', 'Note::create');
$routes->post('notes', 'Note::store');
$routes->get('/', 'Home::index');

// Routes pour la Liste des Étudiants
$routes->get('/etudiants', 'Etudiant::index');  // Liste des étudiants

// Les routes suivantes seront implémentées par les autres membres du groupe:
// $routes->get('/etudiants/create', 'Etudiant::create');
// $routes->post('/etudiants', 'Etudiant::store');
// $routes->get('/etudiants/(:num)', 'Etudiant::show/$1');
// $routes->get('/etudiants/(:num)/edit', 'Etudiant::edit/$1');
// $routes->put('/etudiants/(:num)', 'Etudiant::update/$1');
// $routes->delete('/etudiants/(:num)', 'Etudiant::delete/$1');

// Routes pour l'Admin
$routes->get('/login', 'AdminController::login');
$routes->post('/admin/authenticate', 'AdminController::authenticate');
$routes->get('/logout', 'AdminController::logout');
// $routes->get('/dashboard', 'AdminController::dashboard'); // Assurez-vous de créer cette méthode s'il y a une redirection vers le dashboard
