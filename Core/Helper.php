<?php

  namespace Core;

  class Helper {

    public static function getUserIP() {
      if( array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER) && !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ) {
        if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',')>0) {
          $addr = explode(",",$_SERVER['HTTP_X_FORWARDED_FOR']);
          return trim($addr[0]);
        } else {
          return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
      } else {
        return $_SERVER['REMOTE_ADDR'];
      }
    }

    public static function getUserBrowser() {
      $browser = get_browser(null, true);
      return isset($browser['comment']) ? $browser['comment'] : "";
    }

}
