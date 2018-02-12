<?php

  use Core\Request;
  use Core\Route;

  class Kernel {

    public function connect(Request $request, Route $routes) {
      $action = $routes->getAction($request->get());
      $response = $this->doAction($action, $request);
      return $response;
    }

    private function doAction($action, $request) {
      $action['action'] = explode('@', $action['action']['action']);
      $controller = $action['action'][0];
      $function = $action['action'][1];
      $controller = "App\Controller\\$controller";
      $controller = new $controller;
      $parameters = $action['parameters'];
      if ($request->is_post()) {
        return $controller->$function($request, implode(', ', $parameters));
      }
      return $controller->$function(implode(', ', $parameters));
    }

  }

  return new Kernel();
