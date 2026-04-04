<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/mahasiswa', 'Mahasiswa::index');
$routes->get('mahasiswa/create', 'Mahasiswa::create');
$routes->post('mahasiswa/save', 'Mahasiswa::save');

$routes->get('mahasiswa/edit/(:num)', 'Mahasiswa::edit/$1');
$routes->post('mahasiswa/update/(:num)', 'Mahasiswa::update/$1');

$routes->get('mahasiswa/delete/(:num)', 'Mahasiswa::delete/$1');

$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::processLogin');

$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::processRegister');

$routes->get('/logout','Auth::logout');

$routes->get('mahasiswa', 'Mahasiswa::index', ['filter' => 'auth']);

$routes->get('mahasiswa/create', 'Mahasiswa::create', ['filter' => 'role:admin']);
$routes->post('mahasiswa/save', 'Mahasiswa::save', ['filter' => 'role:admin']);

$routes->get('mahasiswa/edit/(:num)', 'Mahasiswa::edit/$1', ['filter' => 'role:admin']);
$routes->post('mahasiswa/update/(:num)', 'Mahasiswa::update/$1', ['filter' => 'role:admin']);

$routes->get('mahasiswa/delete/(:num)', 'Mahasiswa::delete/$1', ['filter' => 'role:admin']);

$routes->get('/log', 'Log::index', ['filter' => 'auth']);
$routes->get('/log', 'Mahasiswa::log', ['filter' => 'role:admin']);

$routes->group('api', ['filter' => 'jwt'], function($routes) {

  // user biasa
  $routes->get('mahasiswa', 'Api\Mahasiswa::index');
  $routes->get('mahasiswa/(:num)', 'Api\Mahasiswa::show/$1');

  // admin
  $routes->post('mahasiswa', 'Api\Mahasiswa::create', ['filter' => 'jwt:admin']);
  $routes->put('mahasiswa/(:num)', 'Api\Mahasiswa::update/$1', ['filter' => 'jwt:admin']);
  $routes->delete('mahasiswa/(:num)', 'Api\Mahasiswa::delete/$1', ['filter' => 'jwt:admin']);
});


$routes->post('api/login', 'Api\Auth::login');

$routes->get('/profile', 'Profile::index', ['filter' => 'auth']);
$routes->get('/mahasiswa', 'Mahasiswa::index', ['filter' => 'role:admin']);
$routes->get('/mahasiswa-list', 'Mahasiswa::list', ['filter' => 'auth']);

$routes->group('mahasiswa', ['filter' => 'role:admin'], function($routes) {
    $routes->get('/', 'Mahasiswa::index');
    $routes->get('create', 'Mahasiswa::create');
    $routes->post('save', 'Mahasiswa::save');
    $routes->get('edit/(:num)', 'Mahasiswa::edit/$1');
    $routes->post('update/(:num)', 'Mahasiswa::update/$1');
    $routes->get('delete/(:num)', 'Mahasiswa::delete/$1');
});