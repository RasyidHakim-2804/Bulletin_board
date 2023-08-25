<?php

require_once "vendor/autoload.php";
require_once "app/core/helpers/helpers.php";

use App\Core\Router;
use App\Controllers\MessageController;

use function App\Core\Helpers\myParseduri;
use function App\Core\Helpers\redirect;
use function App\Core\Helpers\view;


$uri         = myParseduri($_SERVER['REQUEST_URI']);
$path        = $uri['path']?? $uri;
$method      = $_SERVER['REQUEST_METHOD'];

// if(isset($_GET)) var_dump($_GET['response']);
// echo '<br>';
// var_dump($uri);
// echo '<br>';
//var_dump($query);

//var_dump($_SERVER['REQUEST_URI']);

// var_dump(__FILE__);
// echo '<br>';
// var_dump(__DIR__);

// var_dump($uri);
// echo '<br>';
// var_dump($method);


//bikin router
$router            = new Router($method, $path);
$messageController = new MessageController();


$router->route('GET','/', function(){

  $data = MessageController::get();
  
  return view('home', ['data' => $data]);
});

$router->route('POST', '/post', [MessageController::class, 'store']);

$router->route('GET', '/test', function() {
  return view('test', ['nama' => 'rasyid']);
});

$router->route('GET', '/coba', function() {
  return redirect('/test');
});

$router->errorRoute( 404, function() {
  require_once 'app/views/notfound.php';
});
