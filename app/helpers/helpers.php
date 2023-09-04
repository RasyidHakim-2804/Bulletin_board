<?php

namespace App\Helpers;


const DIR_APP = __DIR__ . "\..\..\app";

//function untuk menampilkan page/halaman
function view(string $viewName, $data = []) {
  try {
    extract($data);
    include_once 'app/views/' . $viewName . '.php';
  } catch (\Exception $e) {
    echo $e->getMessage();
  }
}


//function untuk mendirect ke router beserta mengirim response GET
function redirect(string $to) {
  
  $to = $_ENV['DOMAIN'] . $to;

  header("Location: {$to}");
  exit();
}
/**
 * function-function untuk session
 */

/**
 * mengirim pesan lewat $_SESSIONS
 */
function setSession(string $key, $value) {
  
  if(!session_id()) session_start();

  $_SESSION[$key] = $value;
}

function setFlashMessgae(string $key, $value){
  if(!session_id()) session_start();

  $_SESSION[$key] = ['flasher' => $value];
}

/**
 * function untuk memriksa apakah session memiliki key $name 
 */
function isSessionSet(string $key) {

  if(!session_id()) session_start();

  return isset($_SESSION[$key]);

}
/**
 * function untuk mendapatkan variabel session[$name]
 */
function sessionGet(string $key) {
  if(!session_id()) session_start();

  $result = $_SESSION[$key];

  if(isset($_SESSION[$key]['flasher'])) {
    $result = $_SESSION[$key]['flasher'];

    unset($_SESSION[$key]);
  }

  return $result;
}


/**
 * 
 */


//function untuk parsed uri
function myParsedUri(string $uri) {

  $clearedUri = preg_replace('/\/++/', '/', $uri);
  $clearedUri = str_replace($_ENV['DOMAIN'],'',$clearedUri);
  $clearedUri = parse_url($clearedUri);
  
  return $clearedUri;

}