<?php
namespace App\Core;

use function App\Core\Helpers\myParseduri;

class Router
{

  private $error = array();
  private $found = false;
  
  private $method;
  private $uri;
  private $controller;
  private $responseCode;
  

  //mendefinisikan route
  public function __construct(string $method, string $uri)
  {
    $this->uri    = $uri;
    $this->method = $method;
  }


  //
  private function setResponseCode(int $response_code)
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
  public function route(string $method, string $uri, $controller)
  {
    
    if ($this->uri === $uri && $this->method === $method) {

      $this->controller = $controller;
      $this->found      = true;

    }
  }

  public function __destruct()
  {
    if($this->found === true){
      $this->setResponseCode(200);
      $controller = $this->controller;
      
      call_user_func($controller);

    }

    if($this->found === false) {
      $this->setResponseCode(404);
      return $this->errorHandling();
    }
  }
}