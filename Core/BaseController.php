<?php

  namespace Core;

  class BaseController {

    protected function view( string $path, $data=[] ) {
      $response = new Response();
      if (isset($_GET['type']) && $_GET['type'] == 'json') {
        return $this->json($data);
      }
      return $response->view($path, $data);
    }

    protected function json( $data ) {
      $response = new Response();
      return $response->json($data);
    }

    protected function redirect( $path ) {
      header('Location: '.$path);
      exit();
    }

  }
