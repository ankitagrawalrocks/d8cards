<?php

namespace Drupal\card7_cron_queuing\Plugin\QueueWorker;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Mail\MailManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Queue\QueueWorkerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Queue Worker for cron queuing that sends a welcome email to registered users.
 *
 * @QueueWorker(
 *   id = "card7_cron_queuing",
 *   title = @Translation("Cron queuing - Send welcome email to registered users"),
 *   cron = {"time" = 60}
 * )
 */
class CronQueuing extends QueueWorkerBase implements ContainerFactoryPluginInterface {

  /**
   * User storage.
   *
   * @var EntityStorageInterface
   */
  protected $userStorage;

  /**
   * Mail manager.
   *
   * @var MailManagerInterface
   */
  protected $mailManager;

  /**
   * CronQueuing constructor.
   *
   * @param EntityStorageInterface $user_storage
   *   The user storage.
   * @param MailManagerInterface $mail_manager
   *   Mail manager.
   */
  public function __construct(EntityStorageInterface $user_storage, MailManagerInterface $mail_manager) {
    $this->userStorage = $user_storage;
    $this->mailManager = $mail_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $container->get('entity.manager')->getStorage('user'),
      $container->get('plugin.manager.mail')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function processItem($data) {
    /** @var UserInterface $user */
    $user = $this->userStorage->load($data);

    if ($user) {
      $this->mailManager->mail('welcome_email', 'welcome', $user->getEmail(), $user->getPreferredLangcode(), ['account' => $user]);
    }
  }
}
