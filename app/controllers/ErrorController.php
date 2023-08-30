<?php
namespace App\Controllers;

use function App\Helpers\view;

class ErrorController
{
  public function notFound()
  {
    return view('notfound');
  }
}