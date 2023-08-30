<?php

require_once "vendor/autoload.php";

use Dotenv\Dotenv;

$dotenv      = Dotenv::createImmutable(__DIR__);
$dotenv->load();


require_once "app/helpers/helpers.php";
require_once 'app/routes/routes.php';

// //echo '<pre>';
// try {
  
// } catch (\Exception $e) {
//   $e->getMessage();
// }
// //echo '</pre>';