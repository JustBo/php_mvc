<?php

  namespace Core;

  class Request {

    private $get  = [];
    private $post = [];

    public function __construct() {
      if( isset($_GET['url']) ) {
        $this->setGET($_GET['url']);
      }

      if( count($_POST) > 0 ) {
        $this->setPOST($_POST);
      }

    }

    public function get() {
      return $this->get;
    }
    public function post() {
      return $this->post;
    }
    public function input() {
      return $this->post;
    }

    public function is_post() {
      return count($this->post) > 0 ? true : false;
    }

    public function parseUrl(string $url) : array {
      $url = trim($url);
      return explode('/', $url);
    }

    private function setPOST($post) {
      $this->post = $post;
    }
    private function setGET($get) {
      $this->get = $this->parseUrl($get);
    }

  }
