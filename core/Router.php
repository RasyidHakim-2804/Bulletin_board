<?php

namespace Core;

use App\Controllers\ErrorController;

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
    * lalu memasukkan 
    */
   public function init(): void
   {
      $uri          = $this->parsedUri($_SERVER['REQUEST_URI']);
      $path         = $uri['path'] ?? $uri;
      $method       = $_SERVER['REQUEST_METHOD'];

      $this->path   = $path;
      $this->method = $method;
   }

   /**
    * fungsi ini akan mencocokan antara url, method yang diaskes client pada browser dengan
    * url, method yang disediakan
    * jika ada kesesuaian, 
    * maka @param $this->controller akan diisi  oleh @param callable|array $controller  
    */
   public function route(string $method, string|array $uri, callable|array $controller)
   {
      if (!in_array(strtolower($method), ['get', 'post'])) {
         return Helper::showError(500, 'method ' . $method . ' tidak bisa di route');
      }

      if (is_array($uri)) {
         foreach ($uri as $path) {
            if ($this->path === $path && $this->method === $method) {

               $this->controller = $controller;
               break;
            }
         }
      } else if ($this->path === $uri && $this->method === $method) {

         $this->controller = $controller;
      }
   }

   /**
    * merupakan fungsi yang paling akhir dipanggil pada 
    * akan memanggil controller jika ada
    * akan menampilkan halaman error jika controller null
    */
   public function run()
   {
      if (isset($this->controller)) {
         $callback = $this->controller;
         // var_dump($controller);
         // var_dump(is_callable([new $controller[0], $controller[1]]));

         if(is_array($this->controller)){
            $method = $this->controller[1];
            $class  = new $this->controller[0];
            
            $callback = [$class, $method];
         }

         if (!is_callable($callback)) {
            $message = 'method ' . $method . '() tidak ditemukan pada class ' . $class;
            return Helper::showError(500, $message);
         }

         return call_user_func($callback);
      }

      if (!isset($this->controller)) {
         return Helper::showError();
      }
   }
}
