<?php
//echo '<pre>';
require_once 'vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv      = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// echo 'Usage: ' . memory_get_usage() / 1024 / 1024 . ' MBs' . '<br>';
// echo 'Peak usage: ' . memory_get_peak_usage() / 1024 / 1024 . ' MBs ' . '<br>';

require_once 'app/routes/routes.php';

// echo 'Usage: ' . memory_get_usage() / 1024 / 1024 . ' MBs' . '<br>';
// echo 'Peak usage: ' . memory_get_peak_usage() / 1024 / 1024 . ' MBs';
//echo '</pre>';