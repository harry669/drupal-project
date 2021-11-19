<?php

namespace Drupal\tl_session\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class AjaxForm1.
 */
class AjaxForm1 extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'ajax_form1';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['choice'] = [
      '#type' => 'select',
      '#title' => $this->t('Choice'),
      '#options' => ['One' => $this->t('One'), 'Two' => $this->t('Two'), 'Three' => $this->t('Three'), 'Four' => $this->t('Four')],
      '#size' => 4,
      '#weight' => '0',

      '#ajax' => [
    'callback' => '::myAjaxCallback', // don't forget :: when calling a class method.
    //'callback' => [$this, 'myAjaxCallback'], //alternative notation
    'disable-refocus' => FALSE, // Or TRUE to prevent re-focusing on the triggering element.
    'event' => 'change',
    'wrapper' => 'edit-output', // This element is updated with this AJAX callback.
    'progress' => [
      'type' => 'throbber',
      'message' => $this->t('Verifying entry...'),
               ],
             ]
    ];

    $form['output'] = [
      '#type' => 'textfield',
      '#size' => '60',
      '#disabled' => TRUE,
      '#value' => 'Hello, Drupal!!1',      
      '#prefix' => '<div id="edit-output">',
      '#suffix' => '</div>',
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

  // Get the value from example select field and fill
// the textbox with the selected text.
public function myAjaxCallback(array &$form, FormStateInterface $form_state) {
  // Prepare our textfield. check if the example select field has a selected option.
  if ($selectedValue = $form_state->getValue('choice')) {
      // Get the text of the selected option.
      $selectedText = $form['choice']['#options'][$selectedValue];
      // Place the text of the selected option in our textfield.
      $form['output']['#value'] = $selectedText;
  }
  // Return the prepared textfield.
  return $form['output']; 
}



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
    // Display result.
    foreach ($form_state->getValues() as $key => $value) {
      \Drupal::messenger()->addMessage($key . ': ' . ($key === 'text_format'?$value['value']:$value));
    }
  }

}
