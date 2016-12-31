<?php

namespace Drupal\dino_roar\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\dino_roar\Jurassic\RoarGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

class RoarController extends ControllerBase
{
    /**
     * @var RoarGenerator
     */
    private $roarGenerator;

    /**
     * @var LoggerChannelFactoryInterface
     *
     * Renamed from loggerFactory to loggerFactoryService to not
     * conflict with a new loggerFactory service on ControllerBase
     * in Drupal 8.1!
     */
    private $loggerFactoryService;

    public function __construct(RoarGenerator $roarGenerator, LoggerChannelFactoryInterface $loggerFactory)
    {
        $this->roarGenerator = $roarGenerator;
        $this->loggerFactoryService = $loggerFactory;
    }

    public static function create(ContainerInterface $container)
    {
        $roarGenerator = $container->get('dino_roar.roar_generator');
        $loggerFactory = $container->get('logger.factory');

        return new static($roarGenerator, $loggerFactory);
    }

    public function roar($count)
    {
        $roar = $this->roarGenerator->getRoar($count);
        $this->loggerFactoryService->get('default')
            ->debug($roar);

        return [
            '#title' => $roar
        ];
    }
}
