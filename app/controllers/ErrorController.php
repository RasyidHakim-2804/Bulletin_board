<?php
namespace App\Controllers;

use function App\Helpers\view;

class ErrorController
{
  public static function notFound()
  {
    return view('notfound');
  }
}