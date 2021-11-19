<?php

namespace Drupal\mymodule\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'CustomBlock2' block.
 *
 * @Block(
 *  id = "custom_block2",
 *  admin_label = @Translation("Custom block2"),
 * )
 */
class CustomBlock2 extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
    ] + parent::defaultConfiguration();
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['enter_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Enter Name'),
      '#default_value' => $this->configuration['enter_name'],
      '#maxlength' => 64,
      '#size' => 64,
      '#weight' => '0',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockValidate($form, FormStateInterface $form_state) {
    if ($form_state->getValue('enter_name') === 'test user') {
      $form_state->setErrorByName('hello_block_name', $this->t('You can not say hello to John.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['enter_name'] = $form_state->getValue('enter_name');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $build['#theme'] = 'custom_block2';
    $build['#content'][] = $this->configuration['enter_name'];

    return $build;
  }

}
