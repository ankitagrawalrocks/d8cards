<?php

namespace Drupal\card9_attaching_assets\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provide custom static block.
 *
 * @Block(
 *   id = "card9_attaching_assets_static_block",
 *   admin_label = @Translation("Static Block for adding JS only for this block.")
 * )
 */
class AttachingAssetBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return ['label_display' => FALSE];
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#markup' => '<p>' . $this->t('Block created as per the exercise of Card 9 of D8 cards, and attaching a script only for this block.') . '</p>',
      '#attached' => [
        'library' => [
          'card9_attaching_assets/custom'
        ],
        'drupalSettings' => [
          'card9_attaching_assets' => [
            'custom' => [
              'bg_color' => '#FF0000'
            ]
          ]
        ]
      ],
    ];
  }
}