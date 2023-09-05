<?php

namespace App\Helpers;


//function untuk menampilkan page/halaman
function view(string $viewName, $data = []) {
  try {
    extract($data);
    include_once 'app/views/' . $viewName . '.php';
  } catch (\Exception $e) {
    echo $e->getMessage();
  }
}


//function untuk mendirect ke router
function redirect(string $to) {
  
  $to = $_ENV['DOMAIN'] . $to;

  header("Location: {$to}");
  exit();
}

//function untuk mengambil variabel dari POST
function get_post_variable(string $name) {
  return $_POST[$name]?? null;
}


//function untuk parsed uri
function my_parsed_uri(string $uri) {

  $clearedUri = preg_replace('/\/++/', '/', $uri);
  $clearedUri = str_replace($_ENV['DOMAIN'],'',$clearedUri);

  if($clearedUri !== '/') $clearedUri = rtrim($clearedUri, '/');

  $clearedUri = parse_url($clearedUri);
  
  return $clearedUri;
}

function my_call_user_func(array $array){

  if(!is_callable($array)) {
    $obj    = new $array[0];
    $method = $array[1];

    return call_user_func([$obj, $method]);
  }

  return call_user_func($array);
}