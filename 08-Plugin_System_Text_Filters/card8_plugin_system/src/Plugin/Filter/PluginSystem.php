<?php

namespace Drupal\card8_plugin_system\Plugin\Filter;

use Drupal\Component\Utility\Unicode;
use Drupal\Core\Form\FormStateInterface;
use Drupal\filter\FilterProcessResult;
use Drupal\filter\Plugin\FilterBase;

/**
 * Provides a filter to auto-capitalize pre configured words.
 *
 * @Filter(
 *   id = "card8_plugin_system",
 *   title = @Translation("Card 8 - Auto capitalize pre configured words"),
 *   type = Drupal\filter\Plugin\FilterInterface::TYPE_TRANSFORM_IRREVERSIBLE,
 *   settings = {
 *     "card8_plugin_system_words" = ""
 *   }
 * )
 */
class PluginSystem extends FilterBase {

  /**
   * {@inheritdoc}
   */
  public function process($text, $langcode) {
    $patterns = $replacements = [];
    $words = explode(',', $this->settings['card8_plugin_system_words']);

    foreach ($words as $word) {
      $word = trim($word);

      if ($word !== '') {
        $patterns[] = '/\b' . preg_quote($word, '/') . '\b/i';
        $replacements[] = Unicode::strtoupper($word);
      }
    }

    if ($patterns) {
      $text = preg_replace($patterns, $replacements, $text);
    }

    return new FilterProcessResult($text);
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $form['card8_plugin_system_words'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Words to Capitalize'),
      '#description' => $this->t('Enter list of words in small case, which should be capitalized.<br />Separate multiple words with comma (,)<br /><br />Example: drupal, wordpress, joomla'),
      '#default_value' => $this->settings['card8_plugin_system_words'],
    ];

    return $form;
  }
}
