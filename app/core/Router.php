<?php
namespace App\Core;

class Router
{
  private $routes        = array();
  private $error         = array();
  private $responseCode;

  //mendefinisikan route
  public function route(string $method, string $path, callable $callback)
  {
    $route = [
      'method'   => $method,
      'path'     => $path,
      'callback' => $callback,
    ];

    array_push($this->routes,$route);
  }

  //
  public function setResponseCode(int $response_code)
  {
    $this->responseCode = $response_code;
    http_response_code($this->responseCode);
  }


  //error route
  public function errorRoute(int $response_code, callable $callback){
    $this->error[$response_code] = $callback;
  }

  //error handling
  public function errorHandling()
  {
    $code     = $this->responseCode;
    $callback = $this->error[$code];
    $callback();
  }


  //menjalankan class
  public function run(string $uri, string $method)
  {

    $found = false;

    foreach ($this->routes as $route) {

      if ($route['method'] === $method && $route['path'] === $uri) {

        $this->setResponseCode(200);
        $found    = true;
        $callback = $route['callback'];
        
        $callback();

        break;
      }
    }

    if (!$found) {

      $this->setResponseCode(404);
      $this->errorHandling();

    }
  }
}