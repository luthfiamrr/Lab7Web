<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->setAutoRoute(false);

$routes->get('/page', 'Home::index');
$routes->get('page/home', 'Home::index');
$routes->get('page/artikel/(:any)', 'Page::artikel/$1');
$routes->get('page/about', 'Page::about',);
$routes->get('page/contact', 'Page::contact');


$routes->get('admin', 'Artikel::admin_index');
$routes->add('admin/add', 'Artikel::add');
$routes->add('admin/edit/(:num)', 'Artikel::edit/$1');
$routes->get('admin/delete/(:any)', 'Artikel::delete/$1');
