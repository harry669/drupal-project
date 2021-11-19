<?php
 
namespace Drupal\tl_session\Form;
 
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\OpenModalDialogCommand;
use Drupal\Core\Ajax\ReplaceCommand;
 
/**
 * TeacherForm class.
 */
class TeacherForm extends FormBase {
 
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'tl_teacher_modal_form';
  }
 
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $options = NULL) {
    $teacher_id = \Drupal::request()->get('teacher');
    $teacher_details = \Drupal\user\Entity\User::load($teacher_id);
    $teacher_name= "harry";
    $teacher_details= "harry details";
    $teacher_mail= "manasdhumal159@gmail.com";
    //$teacher_name = alex_tweaks_get_real_name($teacher_details);
    //$teacher_details = alex_tweaks_get_extra_info($teacher_details);
    //$teacher_mail = $teacher_details['mail'];
 
    //$account_details = tl_session_get_user_details();
    $account_details= "account details";
 
    $form['#prefix'] = '<div id="tl_teacher_form">';
    $form['#suffix'] = '</div>';
 
    // The status messages that will contain any form errors.
    $form['status_messages'] = [
      '#type' => 'status_messages',
      '#weight' => -10,
    ];
 
    $form['contact_name'] = [
      '#type' => 'hidden',
      '#value' => $teacher_name,
    ];
    $form['contact_mail'] = [
      '#type' => 'hidden',
      '#value' => $teacher_mail,
    ];
    $form['email_type'] = [
      '#type' => 'hidden',
      '#value' => 'send_message',
    ];
    $form['name'] = [
      '#type' => 'textfield',
      '#title' => t('Your name'),
      '#default_value' => $account_details,
      '#required' => TRUE,
    ];
    $form['email'] = [
      '#type' => 'email',
      '#title' => t('Your email'),
      '#default_value' => $account_details,
      '#required' => TRUE,
    ];
    $form['phone'] = [
      '#type' => 'tel',
      '#title' => t('Your telephone'),
      '#default_value' => $account_details,
      '#required' => FALSE,
    ];
    $form['message'] = [
      '#type' => 'textarea',
      '#default_value' => 'Dear ' . $teacher_name . ',',
      '#rows' => 8,
      '#resizable' => FALSE,
      '#title' => t('Message'),
      '#required' => TRUE,
    ];
 
    $form['actions'] = ['#type' => 'actions'];
    $form['actions']['send'] = [
      '#type' => 'submit',
      '#value' => $this->t('Send message'),
      '#attributes' => [
        'class' => [
          'use-ajax',
        ],
      ],
      '#ajax' => [
        'callback' => [
          $this,
          'submitModalFormAjax'
        ],
        'event' => 'click',
      ],
    ];
    $form['#attached']['library'][] = 'core/drupal.dialog.ajax';
 
    return $form;
  }
 
  /**
   * AJAX callback handler that displays any errors or a success message.
   */
  public function submitModalFormAjax(array $form, FormStateInterface $form_state) {
    $response = new AjaxResponse();
 
    // If there are any form errors, re-display the form.
    if ($form_state->hasAnyErrors()) {
      $response->addCommand(new ReplaceCommand('#tl_teacher_form', $form));
    }
    else {
      $message = $this->t('The email has been sent.');
      drupal_set_message($message);
      \Drupal::logger('tl_session')->notice($message);
      $response->addCommand(new OpenModalDialogCommand("Success!", $message, ['width' => 555]));
    }
    return $response;
  }
 
  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // TODO: Check if it looks like we are going to exceed the flood limit.
    // Not ported to Drupal 8.0.3 yet.
  }
 
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $data['contact_name'] = trim($form_state->getValue('contact_name'));
    $data['mail_to'] = trim($form_state->getValue('contact_mail'));
    $data['mail_type'] = trim($form_state->getValue('email_type'));
    $data['sender_name'] = trim($form_state->getValue('name'));
    $data['sender_email'] = trim($form_state->getValue('email'));
    $data['sender_phone'] = trim($form_state->getValue('phone'));
    $data['sender_message'] = trim($form_state->getValue('message'));
    tl_session_send_mail($data);
  }
 
  /**
   * Gets the configuration names that will be editable.
   *
   * @return array
   * An array of configuration object names that are editable if called in
   * conjunction with the trait's config() method.
   */
  protected function getEditableConfigNames() {
    //return ['config.tl_session_modal_form'];
  }
}