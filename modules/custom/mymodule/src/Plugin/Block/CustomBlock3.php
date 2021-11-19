<?php

namespace Drupal\mymodule\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'CustomBlock3' block.
 *
 * @Block(
 *  id = "custom_block3",
 *  admin_label = @Translation("Custom block3"),
 * )
 */
class CustomBlock3 extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Drupal\Core\Database\Driver\mysql\Connection definition.
   *
   * @var \Drupal\Core\Database\Driver\mysql\Connection
   */
  protected $database;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    $instance = new static($configuration, $plugin_id, $plugin_definition);
    $instance->database = $container->get('database');
    return $instance;
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $build['#theme'] = 'custom_block3';
     $build['custom_block3']['#markup'] = 'Implement CustomBlock3.';

    return $build;
  }

}
