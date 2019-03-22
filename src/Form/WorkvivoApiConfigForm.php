<?php
 
/**
 * @file
 * Contains \Drupal\workvivo_api\Form\WorkvivoApiConfigForm.
 */
 
namespace Drupal\workvivo_api\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
 
class WorkvivoApiConfigForm extends ConfigFormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'workvivo_api_config_form';
  }
 
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
 
    $form = parent::buildForm($form, $form_state);
    $config = $this->config('workvivo_api.settings');
    $form['api_url'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('API URL'),
      '#default_value' => $config->get('workvivo_api.api_url'),
      '#required' => TRUE,
    );
    $form['api_key'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('API Key'),
      '#default_value' => $config->get('workvivo_api.api_key'),
      '#required' => TRUE,
    );
 
 
    return $form;
  }
 
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('workvivo_api.settings');
    $config->set('workvivo_api.api_url', $form_state->getValue('api_url'));
    $config->set('workvivo_api.api_key', $form_state->getValue('api_key'));
    $config->save();
 
    return parent::submitForm($form, $form_state);
  }
 
  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'workvivo_api.settings',
    ];
  }
 
}