<?php

session_start();

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/database.php';

use Buki\Router\Router;

$router = new Router([
    'base_folder' => str_replace('\\', '/', __DIR__),
    'paths' => [
        'controllers' => __DIR__ . '/../app/Controllers',
    ],
    'namespaces' => [
        'controllers' => 'App\Controllers',
    ],
]);

// Accueil - liste des trajets
$router->get('/', 'TrajetController@index');

// Authentification
$router->get('/login',  'AuthController@showLogin');
$router->post('/login', 'AuthController@login');
$router->get('/logout', 'AuthController@logout');

// Trajets
$router->get('/trajet/create',        'TrajetController@create');
$router->post('/trajet/create',       'TrajetController@store');
$router->get('/trajet/edit/:id',      'TrajetController@edit');
$router->post('/trajet/edit/:id',     'TrajetController@update');
$router->post('/trajet/delete/:id',   'TrajetController@delete');

// Admin
$router->get('/admin/users',                'AdminController@users');
$router->get('/admin/agences',              'AdminController@agences');
$router->get('/admin/agences/create',       'AdminController@createAgence');
$router->post('/admin/agences/create',      'AdminController@storeAgence');
$router->get('/admin/agences/edit/:id',     'AdminController@editAgence');
$router->post('/admin/agences/edit/:id',    'AdminController@updateAgence');
$router->post('/admin/agences/delete/:id',  'AdminController@deleteAgence');

$router->run();
