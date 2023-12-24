<?php

use Core\Router;
use App\Http\Controllers\MessageController;

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
$router->get('/', [MessageController::class, 'index']);

$router->post('/message', [MessageController::class, 'store']);

$router->get('/message/edit/{id}',[MessageController::class, 'edit']);

$router->post('/message/update', [MessageController::class, 'update']);

$router->get('/message/delete/{id}', [MessageController::class, 'delete']);


/**
 * ini route untuk testing
 */
$router->get('/test/{nama}', function($nama) {
  return Helper::view('test', ['nama' => $nama]);
});

// $router->route('GET', '/helm',[MessageController::class, 'delete']);


//jalankan routes
$router->run();