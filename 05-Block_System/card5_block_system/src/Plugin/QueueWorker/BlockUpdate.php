<?php

namespace Drupal\card5_block_system\Plugin\QueueWorker;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Queue\QueueWorkerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use GuzzleHttp\Client;

/**
 * Queue Worker that updates block with data from Stock Exchange Rate Cards.
 *
 * @QueueWorker(
 *   id = "card5_block_system",
 *   title = @Translation("Card 5 - Block system"),
 *   cron = {"time" = 60}
 * )
 */
class BlockUpdate extends QueueWorkerBase implements ContainerFactoryPluginInterface {

  /**
   * Blocks entity storage.
   *
   * @var EntityStorageInterface
   */
  protected $blockStorage;

  /**
   * HTTP client.
   *
   * @var Client
   */
  protected $httpClient;

  /**
   * BlockUpdate constructor.
   *
   * @param EntityStorageInterface $block_storage
   *   The block entity storage.
   * @param Client $http_client
   *   HTTP client.
   */
  public function __construct(EntityStorageInterface $block_storage, Client $http_client) {
    $this->blockStorage = $block_storage;
    $this->httpClient = $http_client;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $container->get('entity.manager')->getStorage('block_content'),
      $container->get('http_client')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function processItem($data) {
    /** @var BlockContentInterface $block */
    $block = $this->blockStorage->load($data);

    $symbol = $block->get('field_symbol')->value;
    $data = $this->getSercData($symbol);

    $block->set('field_last_price', $data['LastPrice']);
    $block->set('field_change', $data['Change']);

    return $block->save();
  }

  /**
   * Gets stock exchange rate data.
   *
   * @param string $symbol
   *   Company symbol.
   *
   * @return array
   *   Associative array with data.
   *
   * @throws \Exception
   *   If response from API is broken.
   */
  protected function getSercData($symbol) {
    $url = 'http://dev.markitondemand.com/MODApis/Api/v2/Quote/jsonp?symbol=' . $symbol . '&callback=myFunction';
    $response = $this->httpClient->request('GET', $url);

    if ($response->getStatusCode() == 200) {
      $response = (string) $response->getBody();

      if (strpos($response, 'myFunction({') === 0) {
        $response = substr($response, 11, -1);
        $response = @json_decode($response, TRUE);

        if (isset($response['Status']) && $response['Status'] == 'SUCCESS') {
          return $response;
        }
      }
    }

    throw new \Exception('Oops! Something went wrong in getting response from dev.markitondemand.com.');
  }
}
