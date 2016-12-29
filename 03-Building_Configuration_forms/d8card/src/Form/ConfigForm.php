<?php
namespace Drupal\d8card\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class ConfigForm.
 *
 * @package Drupal\d8card\Form
 */
class ConfigForm extends ConfigFormBase {
  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'd8card.config',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'd8card_config_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('d8card.config');

    $form['text'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Text'),
      '#default_value' => $config->get('text'),
      '#required' => TRUE,
    );

    $form['select'] = array(
      '#type' => 'select',
      '#title' => $this->t('Select'),
      '#options' => range('A', 'K'),
      '#default_value' => $config->get('select'),
    );

    $form['radio'] = array(
      '#type' => 'radios',
      '#title' => $this->t('Radio'),
      '#options' => array('first' => $this->t('First'), 'second' => $this->t('Second'), 'third' => $this->t('Third')),
      '#default_value' => $config->get('radio'),
    );

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('d8card.config')
      ->set('text', $form_state->getValue('text'))
      ->set('select', $form_state->getValue('select'))
      ->set('radio', $form_state->getValue('radio'))
      ->save();
  }
}
