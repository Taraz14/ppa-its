<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
//$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('/login', 'Login::index');
$routes->get('/test', 'Home::test');
$routes->get('/adm', 'Admin::index');
$routes->get('/logout', 'Admin::logout');
$routes->post('/adm', 'Admin::index');
$routes->get('/adm/administrator', 'Admin::administrator');
$routes->post('/adm/data_administrator', 'Admin::data_administrator');
$routes->post('/adm/reset_password', 'Admin::reset_password');
$routes->post('/adm/ubah_level_user', 'Admin::ubah_level_user');
$routes->post('/adm/ubah_status_user', 'Admin::ubah_status_user');
$routes->post('/adm/hapus_user', 'Admin::hapus_user');
$routes->post('/adm/tambah_admin', 'Admin::tambah_admin');
$routes->get('/adm/client', 'Admin::client');
$routes->get('/adm/get_name/(:any)', 'Admin::get_name/$1');
$routes->get('/article/(:any)', 'Home::post/$1');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
