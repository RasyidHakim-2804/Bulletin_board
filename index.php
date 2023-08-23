<?php

require_once "vendor/autoload.php";

use App\Core\Router;

define('DOMAIN', '/Bulletin_board');

$uri   = preg_replace('/\/+/', '/', $_SERVER['REQUEST_URI']);
$uri   = str_replace(DOMAIN,'',$uri);
$method = $_SERVER['REQUEST_METHOD'];

// var_dump(__FILE__);
// var_dump(__DIR__);
// var_dump($uri);


//bikin router
$router = new Router;

$router->route('GET', '/', function() {
  require_once 'app/views/home.php';
});

$router->route('POST', '/', function() {
  require_once 'app/views/home.php';
});

$router->errorRoute( 404, function() {
  require_once 'app/views/notfound.php';
});

$router->run($uri, $method);

