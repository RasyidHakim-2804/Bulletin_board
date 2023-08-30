<?php

namespace App\Helpers;


const DIR_APP = __DIR__ . "\..\..\app";

//function untuk menampilkan page/halaman
function view(string $viewName, $data = []) {

  $viewPath = DIR_APP . "\\views\\" . $viewName . '.php';
  
  if (file_exists(dirname($viewPath))) {
      extract($data);
      ob_start();

      include $viewPath;
      
      echo ob_get_clean();
  } else {
      echo "View not found!: {$viewPath}";
  }
}


//function untuk mendirect ke router beserta mengirim response GET
function redirect(string $to, $query = null) {
  
  $to = $_ENV['DOMAIN'] . $to;

  if ($query === null) {
   
    header("Location: {$to}");
    exit();

  }

  if ($query !== null) {

    $jsonResponse = json_encode($query);
    $encodedJson  = urlencode($jsonResponse);
    $response     = base64_encode($encodedJson);

    header("Location: {$to}?response={$response}");
    exit();

  }
  
}

//function untuk parsed uri
function myParsedUri(string $uri) {

  $clearedUri = preg_replace('/\/++/', '/', $uri);
  $clearedUri = str_replace($_ENV['DOMAIN'],'',$clearedUri);
  $clearedUri = parse_url($clearedUri);
  
  return $clearedUri;

}

/**
 * karena response GET yang dikirim dari function redirect() diatas berupa json(string)
 * maka kita harus mengubahnya lagi menjadi array
 */
function getQueryUri($query) {

  $response      = base64_decode($query);
  $urlDecoded    = urldecode($response);
  $array         = json_decode($urlDecoded, true);

  if (!is_array($array)) return null;

  if (is_array($array)) return $array;

}