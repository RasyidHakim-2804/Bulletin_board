<?php
namespace Core;

use function App\Helpers\myParsedUri;

class Router
{

  private static $error = array();
  private static $found = false;
  
  private static $method;
  private static $path;
  private static $controller;
  private static $responseCode;
  

  //mendefinisikan route
  public static function init()
  {      
    $uri          = myParsedUri($_SERVER['REQUEST_URI']);
    $path         = $uri['path']?? $uri;
    $method       = $_SERVER['REQUEST_METHOD'];

    self::$path   = $path;
    self::$method = $method;
  }


  //
  private static function setResponseCode(int $response_code)
  {
    self::$responseCode = $response_code;
    http_response_code(self::$responseCode);
  }


  //route for error
  public static function errorRoute(int $response_code, callable|array $controller){
    self::$error[$response_code] = $controller;
  }


  //match route and url web
  public static function route(string $method, string|array $uri, callable|array $controller)
  {
    if(is_array($uri)) {
      foreach($uri as $path) {
        if (self::$path === $path && self::$method === $method) {

          self::$controller = $controller;
          self::$found      = true;
    
        }
      }  
    }

    if (self::$path === $uri && self::$method === $method) {

      self::$controller = $controller;
      self::$found      = true;

    }
  }

  //run route
  public static function run()
  {
    if(self::$found === true){
      self::setResponseCode(200);
      $controller = self::$controller;
      
      call_user_func($controller);

    }

    if(self::$found === false) {
      self::setResponseCode(404);
      
      $errorController = self::$error[404];
      //echo $errorController;
      call_user_func($errorController);
    }
  }
}