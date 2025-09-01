<?php
namespace Config;
$routes=Services::routes();
if(file_exists(SYSTEMPATH . 'Config/Routes.php')){
    require SYSTEMPATH .'Config/Routes.php';
}

use CodeIgniter\Router\RouteCollection;

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(true);
$routes->set404Override();
$routes->setAutoRoute(true);
/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('admin', function ($routes){
    $routes->add('login', 'Admin\Admin::login');
    $routes->add('sukses', 'Admin\Admin::sukses');
    $routes->add('logout','Admin\Admin::logout');
    $routes->add('lupapassword','Admin\Admin::lupapassword');
    $routes->add('resetpassword','Admin\Admin::resetpassword');
    $routes->add('inputkas','Admin\Admin::inputkas');
    $routes->add('pengeluaran','Admin\Admin::pengeluaran');
    $routes->add('datakasmasuk','Admin\Admin::datakasmasuk');
    $routes->add('datakaskeluar','Admin\Admin::datakaskeluar');
    $routes->add('rekapkas','Admin\Admin::rekapkas');
    $routes->add('laporankas','Admin\Admin::laporankas');
    $routes->add('index','Admin\Admin::index');
    $routes->get('admin/delete/(:num)', 'Admin\Admin::delete\$1');
    $routes->add('about','Admin\Admin::about');
    $routes->add('contact','Admin\Admin::contact');
    $routes->add('post','Admin\Admin::post');



});
