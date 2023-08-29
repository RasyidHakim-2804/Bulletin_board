<?php

require_once "vendor/autoload.php";
require_once "app/core/helpers/helpers.php";

use App\Core\Router;
use App\Controllers\MessageController;

use function App\Core\Helpers\getQueryUri;
use function App\Core\Helpers\myParsedUri;
use function App\Core\Helpers\redirect;
use function App\Core\Helpers\view;


$uri         = myParsedUri($_SERVER['REQUEST_URI']);
$path        = $uri['path']?? $uri;
$method      = $_SERVER['REQUEST_METHOD'];

if(isset($_GET['response'])) {  
  $_GET['response'] = getQueryUri($_GET['response']);
} 

//bikin router
Router::init($method, $path);


//route
Router::route('GET', ['/', '/home'], function(){

  $data = MessageController::get();
  return view('home', ['row' => $data]);

});

Router::route('POST', '/post', [MessageController::class, 'store']);

Router::route('GET', '/test', function() {
  return view('test', ['nama' => 'rasyid']);
});

Router::route('GET', '/coba', function() {
  return redirect('/test');
});

Router::errorRoute( 404, function() {
  require_once 'app/views/notfound.php';
});

Router::run();