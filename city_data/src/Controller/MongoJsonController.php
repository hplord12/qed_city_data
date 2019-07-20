<?php

/**
 * @file
 * Contains \Drupal\city_data\Controller\MongoJsonController.
 * Custom controller call to get json from mongodb
 */

namespace Drupal\city_data\Controller;

use Drupal\city_data\MongoJsonData;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines a route controller to get json from mongodb.
 */
class MongoJsonController extends ControllerBase {

  /**
   * @var \Drupal\city_data\MongoJsonData
   */
  protected $mongo_data;


  public function __construct(MongoJsonData $mongo_data) {
    $this->mongo_data = $mongo_data;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
       $container->get('city_data.mongodb')
    );
  }
  
  public function getResults() {
    // Call mongodb service to get cities json data from mongodb.
    $result = $this->mongo_data->getJsonData();
    return new JsonResponse($result);
  }

}
