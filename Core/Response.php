<?php

  namespace Core;

  class Response {

    private $baseview = __DIR__."/../app/view/";

    public function __construct(  ) {

    }

    public function view( string $path, $data=[] ) {
      $this->htmlentities($data);
      extract($data);
      include $this->baseview.$path.".template.php";
      return $this;
    }

    public function json( $data ) {
      $this->htmlentities($data);
      echo json_encode($data);
      return $this;
    }

    private function htmlentities(&$data) {
      array_walk_recursive($data, function(&$item) {
        if (is_string($item)) {
          $item = htmlentities($item, ENT_QUOTES, "UTF-8");
        }
      });
    }

  }
