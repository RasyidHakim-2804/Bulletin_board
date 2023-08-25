<?php
namespace App\Core\Helpers;

const DIR_APP = __DIR__ . '\\..\\..\\..\\app';
const DOMAIN   ='/Bulletin_board';



function view(string $viewName, $data = []) {

  $viewPath = DIR_APP . "\\views\\" . $viewName . '.php';
  
  if (file_exists($viewPath)) {
      extract($data);
      ob_start();
      include $viewPath;
      echo ob_get_clean();
  } else {
      echo "View not found!: ";
  }
}

function redirect(string $to, $response = null) {
  $to = DOMAIN . $to;

  $response =http_build_query(['response' => $response]);
  header("Location: {$to}");
  exit();
}

function myParseduri(string $uri) {
  $clearedUri = preg_replace('/\/++/', '/', $uri);
  $clearedUri = str_replace(DOMAIN,'',$clearedUri);
  return $clearedUri;
}
