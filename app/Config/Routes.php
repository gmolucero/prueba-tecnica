<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'IncidentsController::index');

service('auth')->routes($routes);
$routes->group('incidents', static function ($routes) {
    $routes->get('', 'IncidentsController::index');
    $routes->get('new', 'IncidentsController::new');
});
