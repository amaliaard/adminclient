<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Admin'); // Set default controller ke Admin
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// Rute untuk menampilkan daftar admin
$routes->get('admin', 'Admin::index'); // Menampilkan daftar admin
$routes->get('admin/tambah', 'Admin::tambahadmin'); // Menampilkan form tambah admin
$routes->post('admin/tambah', 'Admin::sendData'); // Mengirim data tambah admin
$routes->get('admin/edit/(:num)', 'Admin::edit/$1'); // Menampilkan form edit admin
$routes->post('admin/edit', 'Admin::editadmin'); // Mengirim data edit admin
$routes->get('admin/hapus/(:num)', 'Admin::hapus/$1'); // Menghapus admin berdasarkan ID

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 */
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

  