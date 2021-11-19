<?php

namespace Drupal\mymodule\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'CustomBlock1' block.
 *
 * @Block(
 *  id = "custom_block1",
 *  admin_label = @Translation("Custom block1"),
 * )
 */
class CustomBlock1 extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    
      $renderable = [
      '#theme' => 'custom_block1',
      '#test_var' => 'test variable',
      '#attached' => array(
      'library' => array('mymodule/cuddly-slider'),
      ),
    ];

    return $renderable;
  }

}
