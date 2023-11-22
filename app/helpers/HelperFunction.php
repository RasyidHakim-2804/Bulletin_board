<?php

namespace App\Helpers;

class HelperFunction
{

  //function untuk menampilkan page/halaman
  static function view(string $viewName, $data = [])
  {
    $file = 'app/views/' . $viewName . '.php';
    if (file_exists($file)) {
      
      extract($data);
      include_once $file;
   
    } else {
      $message = 'tidak dapat menemukan file ' . $viewName . '.php pada app/views.';
      self::showError(500, $message);
    }
  }


  //function untuk mendirect ke router
  static function redirect(string $to)
  {

    $to = $_ENV['DOMAIN'] . $to;

    header("Location: {$to}");
    exit();
  }

  //function untuk mengambil variabel dari POST
  static function getPostVariable(string $name)
  {
    return $_POST[$name] ?? null;
  }


  static function showError(int $code = 404, ?string $message = null)
  {
    http_response_code($code);

    if (isset($message) && $code !== 404) {
      extract(['code' => $code, 'message' => $message]);
      include_once 'app/views/errors/errorMessage.php';
    } else {
      include_once 'app/views/errors/errorMessage.php';
    }

    die();
  }
}
