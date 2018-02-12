<?php

  namespace Core;

  use Core\Request;
  use Core\Error;

  class Route {
    /**
     * defined routes
     * @var array
     */
    private $routes = [];

    public function get( $uri, $action ) {
      $this->routes[] = array(
        'action' => $action,
        'method' => 'get',
        'url' => $uri
      );
    }

    public function post( $uri, $action ) {
      $this->routes[] = array(
        'action' => $action,
        'method' => 'post',
        'url' => $uri
      );
    }

    public function getRoutes() {
      return $this->routes;
    }

    public function getAction($get) {

      $request = new Request();

      $parameters = array();
      $url = array();
      foreach ($this->routes as $key => $value) {
        if ($value['url'] == implode('/', $get)) {
          $url = $get;
          break;
        }
        $route_url = explode('/', $value['url']);

        foreach ($route_url as $k => $v) {
          if (isset($get[$k]) && $get[$k] == $v) {
            $url[$v] = $v;
          }
          if (isset($get[$k]) && preg_match("/\{[a-zA-Z]{1,}\}/", $v)) {
            $parameters[$v] = $get[$k];
            $url[$v] = $v;
          }
        }
      }
      $url1 = implode('/', $url);

      if ( $request->is_post() ) {
        $url_index = $this->getRouteIndex($url1, 'post');
      }else{
        $url_index = $this->getRouteIndex($url1, 'get');
      }

      $result = $url_index >= 0 && count($url) == count($get) ?
        array(
          'action' => $this->routes[$url_index],
          'parameters' => $parameters
        ) :
        '404' ;
      if ($result == '404') {
        Error::error_404();
      }
      return $result;
    }

    public function getRouteIndex( $url, $method ) {
      $method_list = array();
      foreach ($this->routes as $key => $value) {
        if ( $value['method'] == $method ) {
          $method_list[$key] = $value['url'];
        }
      }
      $index = array_search($url, $method_list);
      return $index;
    }

  }
