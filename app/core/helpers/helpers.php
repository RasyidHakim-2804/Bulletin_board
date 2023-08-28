<?php
namespace App\Core\Helpers;



const DIR_APP = __DIR__ . "\..\..\..\app";
const DOMAIN   ='/Bulletin_board';


//function untuk menampilkan page/halaman
function view(string $viewName, $data = []) {

  $viewPath = DIR_APP . "\\views\\" . $viewName . '.php';
  
  if (file_exists(dirname($viewPath))) {
      extract($data);
      ob_start();

      include $viewPath;
      
      echo ob_get_clean();
  } else {
      echo "View not found!: ";
  }
}


//function untuk mendirect ke router beserta mengirim response GET
function redirect(string $to, $query = null) {
  
  $to = DOMAIN . $to;

  if ($query === null) {
   
    header("Location: {$to}");
    exit();

  }

  if ($query !== null) {

    $jsonResponse = json_encode($query);
    $encodedJson  = urlencode($jsonResponse);
    header("Location: {$to}?response={$encodedJson}");
    exit();

  }
  
}

//function untuk parsed uri
function myParsedUri(string $uri) {

  $clearedUri = preg_replace('/\/++/', '/', $uri);
  $clearedUri = str_replace(DOMAIN,'',$clearedUri);
  $clearedUri = parse_url($clearedUri);
  
  return $clearedUri;

}

/**
 * karena response GET yang dikirim dari function redirect() diatas berupa json(string)
 * maka kita harus mengubahnya lagi menjadi array
 */
function getQueryUri($query) {

  $decodedString = urldecode($query);
  $data          = substr($decodedString, strpos($decodedString, "=") + 1);
  $array         = json_decode($data, true);

  return $array;

}