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

  static function showError(int $code, string $message)
  {
    http_response_code($code);

    extract(['code' => $code, 'message' => $message]);

    include_once 'app/views/errors/errorMessage.php';

    die();
  }

  static function call(callable|array $callback, ?array $args = null)
  {
    $function = null;

    if (is_array($callback)) {
      $method = $callback[1];
      $objek  = new $callback[0];

      $function = [$objek, $method];
    }

    if (isset($args)) return call_user_func_array($function, $args);

    return call_user_func($function);
  }

  static function redirect(string $to)
  {
    $to = $_ENV['DOMAIN'] . $to;
    header("Location: {$to}");
  }
}
