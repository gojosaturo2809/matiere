<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
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
