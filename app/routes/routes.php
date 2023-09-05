<?php

use Core\Router;
use App\Controllers\MessageController;

use function App\Helpers\redirect;
use function App\Helpers\view;



/**
 * inisiasi rute dari url browser
 */
$router = new Router;

$router->init();


/**
 * membuat route
 * controller yang bisa dipanggil dari class hanya static function saja
 */
$router->route('GET', ['/', '/home', '/index.php'], [MessageController::class, 'get']);

$router->route('POST', '/message', [MessageController::class, 'store']);


/**
 * ini route untuk testing
 * halamannya ada viwes
 */
$router->route('GET', '/test', function() {
  return view('test', ['nama' => 'rasyid']);
});

$router->route('GET', '/coba', function() {
  return redirect('/test');
});


//jalankan routes
$router->run();