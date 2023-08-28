<?php
namespace App\Core\Helpers;



const DIR_APP = __DIR__ . "\..\..\..\app";
const DOMAIN   ='/Bulletin_board';



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

function redirect(string $to, $query = null) {
  $to = DOMAIN . $to;

  if ($query === null) {
   
    header("Location: {$to}");
    exit();

  }

  if ($query !== null) {

    $jsonResponse = json_encode($query);
    $encodedJson = urlencode($jsonResponse);
    header("Location: {$to}?response={$encodedJson}");
    exit();

  }
  
}

function myParsedUri(string $uri) {

  $clearedUri = preg_replace('/\/++/', '/', $uri);
  $clearedUri = str_replace(DOMAIN,'',$clearedUri);
  $clearedUri = parse_url($clearedUri);
  
  return $clearedUri;

}


function getQueryUri() {

  //if(is)

  $encodedJson   = $_GET['response'] ?? '';
  $jsonResponse  = urldecode($encodedJson);
  $responseArray = json_decode($jsonResponse, true);

  return $responseArray;
}