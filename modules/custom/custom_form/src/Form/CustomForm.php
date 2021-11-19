<?php

namespace Drupal\custom_form\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class CustomForm.
 */
class CustomForm extends FormBase {

  /**
   * Drupal\Core\Session\AccountProxyInterface definition.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $instance = parent::create($container);
    $instance->currentUser = $container->get('current_user');
    return $instance;
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'custom_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['enter_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Enter Name'),
      '#description' => $this->t('Enter User Name'),
      '#maxlength' => 64,
      '#size' => 64,
      '#weight' => '0',
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    foreach ($form_state->getValues() as $key => $value) {
      // @TODO: Validate fields.
    }
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {


      //Add all Form Data into the database tabal custom_form_data
         $database = \Drupal::database();
         $query = $database->insert('custom_form_data')->fields(['name','uid']);

      //get current user info
         $user_id=$this->currentUser->id();

      //make data array
         $value= [
            [
            'name' => trim($form_state->getValue('enter_name')),
            'uid' => $user_id,
            ]
         ];

      //add data into table
         foreach ($value as $user) {
             $query->values($user);
            }

         $query->execute();

    // Display result.
    foreach ($form_state->getValues() as $key => $value) {
      \Drupal::messenger()->addMessage($key . ': ' . ($key === 'text_format'?$value['value']:$value));
    }

    //try to send mail to user
    custom_form_send_mail();
  }

}
