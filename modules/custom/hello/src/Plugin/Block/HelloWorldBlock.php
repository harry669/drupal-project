<?php

namespace Drupal\hello\Plugin\Block;

use Drupal\Core\Block\BlockBase;


/**
 * Provides a 'Hello' Block.
 *
 * @Block(
 *   id = "hello_block",
 *   admin_label = @Translation("Hello block"),
 *   category = @Translation("Hello World"),
 * )
 */
class HelloWorldBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {

         //get current user id 

         $user_id= \Drupal::currentUser()->id();

      $renderable = [
      '#theme' => 'hello_block',
      '#test_var' => $user_id,
       '#attached' => array(
          'library' => array(
            'bartik/block-styling',
        ),
        ),
    ];

    return $renderable;
  }

}
