<?php

  namespace Core;

  use PDO;

  class Database {

    private $link;
    private $host;
    private $dbname;
    private $charset;
    private $password;
    private $user;

    public function __construct() {
      $config = require __DIR__.'/../config.php';
      $this->host = $config['host'];
      $this->dbname = $config['DB_name'];
      $this->charset = $config['charset'];
      $this->password = $config['DB_password'];
      $this->user = $config['user'];

      $this->connect();

    }

    private function connect() {
      $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}";
      $this->link = new PDO($dsn, $this->user, $this->password);
      $this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $this;
    }

    public function execute(string $sql, $data=null) {
      $sth = $this->link->prepare($sql);
      $sth->execute($data);
      return $sth;
    }

    public function query(string $sql, $data=null) {
      $exe = $this->execute($sql, $data);
      $result = $exe->fetchAll(PDO::FETCH_ASSOC);
      if ($result === false) {
        return [];
      }
      return $result;
    }

    public function set(string $sql, array $data) {
      $sth = $this->link->prepare($sql);
      return $sth->execute($data);
    }

  }
