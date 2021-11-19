<?php
namespace Drupal\hello\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Provides route responses for the Example module.
 */
class HelloController extends ControllerBase {

  /**
   * Returns a simple page.
   *
   * @return array
   *   A simple renderable array.
   */
  public function print() {
   
     $service = \Drupal::service('hello_services.say_hello');
     dsm($service);
    
     
  }

}