<?php

use Core\Router;
use App\Controllers\MessageController;

use App\Helpers\HelperFunction as Helper;



/**
 * inisiasi rute dari url browser
 */
$router = new Router;

$router->init();


/**
 * membuat route
 * controller yang bisa dipanggil dari class hanya static function saja
 */
$router->route('GET', ['/', '/home', '/index.php'], [MessageController::class, 'index']);

$router->route('POST', '/message', [MessageController::class, 'store']);


/**
 * ini route untuk testing
 */
$router->route('GET', '/test', function() {
  return Helper::view('test', ['nama' => 'rasyid']);
});

$router->route('GET', '/coba', function() {
  return Helper::redirect('/test');
});

// $router->route('GET', '/helm',[MessageController::class, 'delete']);


//jalankan routes
$router->run();