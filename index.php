<?php

require_once "vendor/autoload.php";


use Dotenv\Dotenv;

$dotenv      = Dotenv::createImmutable(__DIR__);
$dotenv->load();


require_once "app/helpers/helpers.php";



echo '<pre>';
// $test = getenv();
// var_dump($test);

var_dump($_ENV);

var_dump(PDO::getAvailableDrivers());

echo '</pre>';

echo '<pre>';
try {
  require_once 'app/routes/routes.php';
} catch (\Exception $e) {
  $e->getMessage();
}
echo '</pre>';