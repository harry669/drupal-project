<?php

namespace Drupal\mymodule;
use Drupal\Core\Database\Driver\mysql\Connection;

/**
 * Class DefaultService.
 */
class DefaultService {

  /**
   * Drupal\Core\Database\Driver\mysql\Connection definition.
   *
   * @var \Drupal\Core\Database\Driver\mysql\Connection
   */
  protected $database;

  /**
   * Constructs a new DefaultService object.
   */
  public function __construct(Connection $database) {
    $this->database = $database;
  }


  public function Fetch()
  {
      //get  data from it
      $query= $this->database->select('node','n');
      $query->fields('n');
      $result= $query->execute();

      return $result;

  }

}
