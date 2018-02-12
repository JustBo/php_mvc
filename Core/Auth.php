<?php
  namespace Core;

  class Auth {

    public static function login($user, $password) {
      $config = self::getConfig();
      if ($config['moderator'] == $user && password_verify($password, $config['moderator_password']) ) {
        $_SESSION['moderator'] = $config['moderator_password'];
        return true;
      }
      return false;
    }

    public static function logout() {
      if (isset($_SESSION['moderator'])) {
        unset($_SESSION['moderator']);
      }
    }

    public static function is_logged_in() {
      $config = self::getConfig();
      return isset($_SESSION['moderator']) && isset($config['moderator_password']) ?
        $_SESSION['moderator'] == $config['moderator_password'] : false;
    }

    private function getConfig() {
      $config = require __DIR__.'/../config.php';
      return $config;
    }
  }
