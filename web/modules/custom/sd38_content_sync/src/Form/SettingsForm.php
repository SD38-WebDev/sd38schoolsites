<?php

namespace Drupal\sd38_content_sync\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Defines a form that configures forms module settings.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'sd38_content_sync_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'sd38_content_sync.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, Request $request = NULL) {
    $config = $this->config('sd38_content_sync.settings');

    $form['d38_district_url'] = [
      '#title' => $this->t('D38 District URL'),
      '#type' => 'textfield',
      '#default_value' => $config->get('d38_district_url') ?? ''
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    $ignored_values = [
      'submit',
      'form_build_id',
      'form_token',
      'form_id',
      'op'
    ];
    foreach ($values as $name => $value) {
      if (!in_array($name, $ignored_values)) {
        if (isset($value['value'])) {
          $value = $value['value'];
        }
        $this->config('sd38_content_sync.settings')
          ->set($name, $value);
      }
    }
    $this->config('sd38_content_sync.settings')->save();
  }
}
