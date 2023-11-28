<?php

namespace Core;

use App\Helpers\HelperFunction as Helper;

class Router
{
   /**
    * ex: GEt, POST
    */
   private $method;
   /**
    * ex : /home, /about, /contact, etc
    */
   private $path;
   /**
    *  function yang akan dipanggil saat $method dan $path terdaftar di route
    */
   private $controller;

   /**
    * variabel yang akan digunakan pada controller jika menggunakan parameter url
    */
   private ?array $argsController = null;

   private function parsedUri(string $uri)
   {

      // membersihkan URI dari (/) yang berlebihan
      $clearedUri = preg_replace('/\/++/', '/', $uri);

      //membersihkan url dari nama domain
      $clearedUri = str_replace($_ENV['DOMAIN'], '', $clearedUri);

      /**
       * Memeriksa apakah URI setelah dibersihkan bukan merupakan tanda garis miring tunggal (/). 
       * Jika itu (/), maka fungsi rtrim digunakan untuk menghapus tanda garis miring di ujung 
       * kanan URI.
       */
      if ($clearedUri !== '/') $clearedUri = rtrim($clearedUri, '/');

      /**
       * Menggunakan fungsi parse_url untuk mem-parsing URI yang telah dibersihkan menjadi
       * komponen-komponen seperti skema, host, path, dan sebagainya.
       */
      $clearedUri = parse_url($clearedUri);

      return $clearedUri;
   }

   /**
    * mendefinisikan route
    * menangkap url dan method pada browser klien
    * lalu memasukkan nya menjadi properti objek ini
    */
   public function init(): void
   {
      $uri          = $this->parsedUri($_SERVER['REQUEST_URI']);
      // var_dump($uri);
      $path         = $uri['path'] ?? $uri;
      // var_dump($uri);
      $method       = $_SERVER['REQUEST_METHOD'];

      $this->path   = $path;
      // var_dump($path);
      $this->method = $method;
   }

   private function generateParameterPath(string $uri)
   {
      $segments = explode('/', $uri);
      $path = [];
      $pattern = "/\{[^\{\}]+\}/";

      foreach($segments as $segment){
         $path[] = preg_match($pattern, $segment)? true : $segment; 
      }

      return $path;
   }
   
   /**
    * fungsi yang akan menjalankan rute parameter jika ada
    */
   private function parameterRoute(array $uri, callable|array $controller)
   {
      /**
       * memecah url dari web dengan delimiter (/) 
       */
      $paths = explode('/',$this->path);

      if(count($paths) !== count($uri)) return;

      $argsController = [];

      /**
       * untuk mencocokkan antara url dari web dengan rute yang didaftarkan
       * ex ['user', true, 'edit', true] === ['user', user_id, 'edit', post_id] 
       */
      for ($i=0; $i < count($paths); $i++) { 

         //jika 'user' === 'user' lanjut
         if($paths[$i] === $uri[$i]) continue;

         /**
          * memasukkan parameter dari url web ke dalam $argsController
          * $uri[i] === true artinya merupakan posisi prameter url
          */
         if($uri[$i] === true){
            $argsController[] = $paths[$i];
            continue;
         }

         return;
      }

      $this->argsController = $argsController;
      $this->controller = $controller;

   }

   /**
    * fungsi ini akan mencocokan antara url, method yang diaskes client pada browser dengan
    * url, method yang disediakan
    * jika ada kesesuaian, 
    * maka @param $this->controller akan diisi  oleh @param callable|array $controller  
    */
   private function route(string $method, string $uri, callable|array $controller)
   {
      if ($this->path === $uri && $this->method === $method) {

         $this->controller = $controller;
         return;
      }

      $parameterPath = $this->generateParameterPath($uri);

      if(in_array(true, $parameterPath) && $method === $this->method) {
         $this->parameterRoute($parameterPath, $controller);
      } 

   }

   /**
    * route untuk GET
    */
   public function get( string|array $uri, callable|array $controller)
   {
      $this->route('GET', $uri, $controller);
   }

   /**
    * route untuk POST
    */
   public function post( string|array $uri, callable|array $controller)
   {
      $this->route('POST', $uri, $controller);
   }

   /**
    * merupakan fungsi yang paling akhir dipanggil pada 
    * akan memanggil controller jika ada
    * akan menampilkan halaman error jika controller null
    */
   public function run()
   {
      if (isset($this->controller)) {

         return Helper::call($this->controller, $this->argsController);
      }

      return Helper::showError();
   }
}
