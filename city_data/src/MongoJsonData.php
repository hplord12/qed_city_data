<?php

/**
 * @file
 * Custom service to get details from mongodb.
 */

namespace Drupal\city_data;

class MongoJsonData implements MongoJsonDataInterface {

  /**
   * @see \Drupal\city_data\MongoJsonDataInterface::getJsonData()
   */
  public function getJsonData() {
    $json_data = [];

    // Get data from Blog collection's content document.
    $collection = (new \MongoDB\Client)->Blog->content;
    // Get all data from content document.
    $cursor = $collection->find(
      []
    );

    foreach ($cursor as $key=>$document) {
      $json_data[$key]['_id'] = (int)$document['_id'];
      $json_data[$key]['city'] = $document['city'];
      $json_data[$key]['pop'] = (int)$document['pop'];
      $json_data[$key]['state'] = $document['state'];
      $json_data[$key]['longitude'] = $document['loc'][0];
      $json_data[$key]['latitude'] = $document['loc'][1];
    }

    return $json_data;
  }

}
