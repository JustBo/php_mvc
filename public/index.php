<?php

  require_once __DIR__.'/../vendor/autoload.php';
  require_once __DIR__.'/../app/bootstrap.php';

  use Core\Request;

  $kernel = require_once __DIR__.'/../app/Kernel.php';

  $response = $kernel->connect(new Request(), $routes);
