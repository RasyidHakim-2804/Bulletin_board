<?php
namespace App\Controllers;

use function App\Helpers\view;

class ErrorController
{
  public static function notFound()
  {
    http_response_code(404);
    return view('notfound');
  }
}