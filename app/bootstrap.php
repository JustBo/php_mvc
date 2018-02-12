<?php

  use Core\Route;

  session_start();

  $routes = new Route();

  require_once __DIR__.'/../routes/routesRegister.php';
