<?php

namespace Drupal\card4_migration\Plugin\migrate\process;

use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Plugin\migrate\process\Get;
use Drupal\migrate\Row;

/**
 * Removes the "the" article from input string.
 *
 * @MigrateProcessPlugin(
 *   id = "remove_the"
 * )
 */
class RemoveThe extends Get {

  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    $value = parent::transform($value, $migrate_executable, $row, $destination_property);

    if (is_string($value)) {
      self::remove($value);
    }
    else {
      array_walk_recursive($value, 'self::remove');
    }

    return $value;
  }

  /**
   * Removes the "the" from string.
   *
   * @param string $string
   *   Input string.
   *
   * @return string
   *   Clean string w/o "the"s.
   */
  protected static function remove(&$string) {
    $string = ucfirst(trim(preg_replace('/\s*\bthe\b\s*/i', ' ', $string)));

    return $string;
  }

}
