<?php

  namespace App\Model;

  use Core\Model;

  class Book extends Model {

    private $table = "books";
    private $fillableColumns = array(
      'name',
      'email',
      'website',
      'IP',
      'browser',
      'created'
    );

    protected function getTableName() {
      return $this->table;
    }

    protected function getFillableColumnsArray() {
      return $this->fillableColumns;
    }
  }
