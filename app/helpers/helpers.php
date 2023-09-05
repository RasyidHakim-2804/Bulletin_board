<?php

namespace App\Helpers;


//function untuk menampilkan page/halaman
function view(string $viewName, $data = []) {
  try {
    extract($data);
    include_once 'app/views/' . $viewName . '.php';
  } catch (\Exception $e) {
    set_session('error', $e->getMessage());
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

/**
 * function-function untuk session
 */

/**
 * mengirim pesan lewat $_SESSIONS
 */
function set_session(string $key, $value) {
  
  if(!session_id()) session_start();

  $_SESSION[$key] = $value;
}

function set_flash_message(string $key, $value){
  if(!session_id()) session_start();

  $_SESSION[$key] = ['flasher' => $value];
}

/**
 * function untuk memriksa apakah session memiliki key $name 
 */
function is_session_set(string $key) {

  if(!session_id()) session_start();

  return isset($_SESSION[$key]);

}
/**
 * function untuk mendapatkan variabel session[$name]
 */
function get_session(string $key) {
  if(!session_id()) session_start();

  $result = $_SESSION[$key];

  //jika tipe pesannya berupa flasher
  if(isset($_SESSION[$key]['flasher'])) {
    $result = $_SESSION[$key]['flasher'];

    unset($_SESSION[$key]);
  }

  //jika tipe pesannya error
  if($key === 'error') {
    $result = $_SESSION[$key];

    unset($_SESSION[$key]);
  }

  return $result;
}


//function untuk parsed uri
function my_parsed_uri(string $uri) {

  $clearedUri = preg_replace('/\/++/', '/', $uri);
  $clearedUri = str_replace($_ENV['DOMAIN'],'',$clearedUri);

  if($clearedUri !== '/') $clearedUri = rtrim($clearedUri, '/');

  $clearedUri = parse_url($clearedUri);
  
  return $clearedUri;
}