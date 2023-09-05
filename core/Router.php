<?php
namespace Core;

use App\Controllers\ErrorController;

use function App\Helpers\is_session_set;
use function App\Helpers\my_parsed_uri;
use function App\Helpers\view;

class Router
{
  private static $found = false;
  
  private static $method;
  private static $path;
  private static $controller;
  

  //mendefinisikan route
  public static function init()
  {      
    $uri          = my_parsed_uri($_SERVER['REQUEST_URI']);
    $path         = $uri['path']?? $uri;
    $method       = $_SERVER['REQUEST_METHOD'];

    self::$path   = $path;
    self::$method = $method;
  }


  //match route and url web
  public static function route(string $method, string|array $uri, callable|array $controller)
  {
    if(is_array($uri)) {
      foreach($uri as $path) {
        if ((self::$path === $path) && (self::$method === $method)) {

          self::$controller = $controller;
          self::$found      = true;    
        }
      }  
    }

    if ((self::$path === $uri) && (self::$method === $method)) {

      self::$controller = $controller;
      self::$found      = true;
    }
  }

  //run route
  public static function run()
  {
    if(is_session_set('error')) {
      return view('error');
    }

    if(self::$found === true){
      http_response_code(200);
      $controller = self::$controller;
      
      return call_user_func($controller);
    }

    if(self::$found === false) {
      return call_user_func([ErrorController::class, 'notfound']);
    }
  }
}