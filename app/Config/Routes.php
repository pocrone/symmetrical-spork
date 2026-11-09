<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Sample Login UI Routes (standalone, no database interaction)
$routes->get('login', 'Login::index');
$routes->post('login', 'Login::auth');
$routes->post('login/auth', 'Login::auth');
$routes->get('logout', 'Login::logout');

// Sample Dashboard UI Route (standalone, mock data, no database required)
$routes->get('dashboard', 'Dashboard::index');
