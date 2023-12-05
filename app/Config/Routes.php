<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'IncidentsController::index');

service('auth')->routes($routes);



$routes->group('incidents', static function ($routes) {
    $routes->get('', 'IncidentsController::index', ['as' => 'incidents.index']);
    $routes->get('detail/(:num)', 'IncidentsController::detail/$1', ['as' => 'incidents.detail']);
    $routes->match(['get', 'post'], 'create', 'IncidentsController::create', ['as' => 'incidents.create']);
    $routes->match(['get', 'post'], 'edit/(:num)', 'IncidentsController::edit/$1', ['as' => 'incidents.edit']);
    $routes->post('delete/(:num)', 'IncidentsController::delete/$1', ['as' => 'incidents.delete']);
});
