<?php

  namespace Core;

  use Core\Error;

  abstract class Model {

    protected $connection;
    protected $query  = "";
    protected $select = "";
    protected $limit  = "";
    protected $order  = "";
    protected $binddata = [];
    private   $methods  = ["ASC", "DESC"];

    public function __construct() {
      $this->connection = new Database();
    }

    public function all() {
      $this->select = "SELECT * FROM {$this->getTableName()}";
      return $this;
    }

    public function limit($from, $to) {
      $from = max((int) $from, 0);
      $to = max((int) $to, 0);
      $this->limit = "LIMIT $from, $to";
      return $this;
    }

    public function order($field, $method) {
      if (in_array($field, $this->getFillableColumnsArray()) && in_array($method, $this->methods)) {
        $this->order = "ORDER BY $field $method";
      }
      return $this;
    }

    public function get() {
      $this->query = $this->generateQuery();
      if (!$this->query) {
        return false;
      }
      return $this->connection->query($this->query, $this->binddata);
    }

    public function count() {
      $this->query = "SELECT COUNT(*) FROM {$this->getTableName()}";
      if (!$this->query) {
        return false;
      }
      return $this->connection->query($this->query)[0]['COUNT(*)'];
    }

    public function store(array $data) {
      $bindkeys = array();
      $keys = array();
      $fillableData = array();

      foreach ($data as $key => $value) {
        if (in_array($key, $this->getFillableColumnsArray())) {
          $keys[] = $key;
          $bindkeys[] = ":$key";
          $fillableData[$key] = $value;
        }
      }
      $this->query = "INSERT INTO {$this->getTableName()}(".implode(',', $keys).") VALUES(".implode(',', $bindkeys).")";
      return $this->connection->set($this->query, $fillableData);
    }

    public function update(array $data, $id) {
      $bindkeys = array();
      $keys = array();
      $fillableData = array();

      foreach ($data as $key => $value) {
        if (in_array($key, $this->getFillableColumnsArray())) {
          $binds[] = "$key = :$key";
          $fillableData[$key] = $value;
        }
      }
      $fillableData['id'] = $id;
      $this->query = "UPDATE {$this->getTableName()} SET ".implode(',', $binds)." WHERE id = :id";
      return $this->connection->set($this->query, $fillableData);
    }

    public function delete($id) {

      $fillableData = array(
        'id' => $id
      );

      $this->query = "DELETE FROM {$this->getTableName()} WHERE id = :id";
      return $this->connection->set($this->query, $fillableData);
    }

    public function findOrFail($id) {
      $fillableData = array(
        'id' => $id
      );
      $this->query = "SELECT * FROM {$this->getTableName()} WHERE id=:id";
      $result = $this->connection->query($this->query, $fillableData);
      if (count($result) == 0) {
        Error::error_404();
      }
      return $result[0];
    }

    protected function generateQuery() {
      $query = array($this->select, $this->order, $this->limit);
      if (empty($this->select)) {
        return false;
      }
      return implode(' ', $query);
    }

    abstract protected function getTableName();
    abstract protected function getFillableColumnsArray();

  }
