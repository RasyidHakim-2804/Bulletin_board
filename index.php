<?php

require_once "vendor/autoload.php";

define('BASE_URL', '/Bulletin_board');

$path   = preg_replace('/\/+/', '/', $_SERVER['REQUEST_URI']);
$path   = str_replace(BASE_URL,'',$path);
$method = $_SERVER['REQUEST_METHOD'];

var_dump($method);
echo '<br>';
var_dump($path);
echo '<br>';


if ($path === '/' ) {
  require_once 'views/home.php';
}
