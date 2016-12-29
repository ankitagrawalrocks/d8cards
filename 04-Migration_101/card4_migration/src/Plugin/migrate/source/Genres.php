<?php

namespace Drupal\card4_migration\Plugin\migrate\source;

use Drupal\migrate_source_csv\Plugin\migrate\source\CSV;

/**
 * Source plugin for the genres.
 *
 * @MigrateSource(
 *   id = "genres"
 * )
 */
class Genres extends CSV {

  /**
   * {@inheritdoc}
   */
  public function fields() {
    return ['genre' => $this->t('Genre')];
  }

  /**
   * {@inheritdoc}
   */
  public function initializeIterator() {
    $file = parent::initializeIterator();
    $genres = [];

    foreach ($file as $row) {
      foreach ($row as $cell) {
        foreach (explode('|', $cell) as $genre) {
          $genre = trim($genre);
          $genres[$genre] = ['genre' => $genre];
        }
      }
    }

    return new \IteratorIterator(new \ArrayIterator($genres));
  }

}
