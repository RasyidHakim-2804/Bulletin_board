<?php

use Core\Router;
use App\Controllers\ErrorController;
use App\Controllers\MessageController;

use function App\Helpers\redirect;
use function App\Helpers\view;



/**
 * inisiasi rute dari url browser
 */
Router::init();


/**
 * membuat route
 * controller yang bisa dipanggil dari class hanya static function saja
 */
Router::route('GET', ['/', '/home', '/index.php'], [MessageController::class, 'get']);

Router::route('POST', '/message', [MessageController::class, 'store']);

Router::errorRoute( 404, [ErrorController::class, 'notFound']);


/**
 * ini route untuk testing
 * halamannya ada viwes
 */
Router::route('GET', '/test', function() {
  return view('test', ['nama' => 'rasyid']);
});

Router::route('GET', '/coba', function() {
  return redirect('/test');
});


//jalankan routes
Router::run();