<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/', 'Home::index');
$routes->get('/produtos', 'Produtos::list');
$routes->post('/produtos/create', 'Produtos::create');