<?php
namespace Core;

use App\Controllers\ErrorController;

use function App\Helpers\my_parsed_uri;
use function App\Helpers\my_call_user_func;

class Router
{  
  private $method;
  private $path;
  private $controller;
  

  //mendefinisikan route
  public function init()
  {      
    $uri          = my_parsed_uri($_SERVER['REQUEST_URI']);
    $path         = $uri['path']?? $uri;
    $method       = $_SERVER['REQUEST_METHOD'];

    $this->path   = $path;
    $this->method = $method;
  }


  //match route and url web
  public function route(string $method, string|array $uri, callable|array $controller)
  {
    if(is_array($uri)) {
      foreach($uri as $path) {
        if ($this->path === $path && $this->method === $method) {

          $this->controller = $controller;
        }
      }  
    }

    if ($this->path === $uri && $this->method === $method) {

      $this->controller = $controller;
    }
  }

  //run route
  public function run()
  {
    if(isset($this->controller)){
      $controller = $this->controller;
      
      // var_dump($controller);
      // var_dump(is_callable([new $controller[0], $controller[1]]));

      return my_call_user_func($controller);
    }

    if(!isset($this->controller)) {
      return my_call_user_func([ErrorController::class, 'notfound']);
    }
  }
}