<?php
namespace App\Core;


class Router
{

  private static $error = array();
  private static $found = false;
  
  private static $method;
  private static $uri;
  private static $controller;
  private static $responseCode;
  

  //mendefinisikan route
  public static function init(string $method, string $uri)
  {
    self::$uri    = $uri;
    self::$method = $method;
  }


  //
  private static function setResponseCode(int $response_code)
  {
    self::$responseCode = $response_code;
    http_response_code(self::$responseCode);
  }


  //route for error
  public static function errorRoute(int $response_code, callable $callback){
    self::$error[$response_code] = $callback;
  }

  //error handling
  public static function errorHandling()
  {
    $code     = self::$responseCode;
    $callback = self::$error[$code];
    $callback();
  }


  //match route and url web
  public static function route(string $method, string|array $uri, $controller)
  {
    if(is_array($uri)) {
      foreach($uri as $path) {
        if (self::$uri === $path && self::$method === $method) {

          self::$controller = $controller;
          self::$found      = true;
    
        }
      }  
    }

    if (self::$uri === $uri && self::$method === $method) {

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
      return self::errorHandling();
    }
  }
}