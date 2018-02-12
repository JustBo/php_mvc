<?php
  namespace Core;

  class Error {
    public static function error_404() {
      header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
      echo '404 Not Found';
      exit();
    }
    public static function error_500() {
      header($_SERVER["SERVER_PROTOCOL"]." 500 Bad Request", true, 500);
      echo '500 Bad Request';
      exit();
    }
  }
