<?php

/**
 * @file
 * Custom service interface for mongojson services.
 */

namespace Drupal\city_data;

/**
 * Mongo Json Data interface.
 */
interface MongoJsonDataInterface {

 
  /**
   * Get cities data.
   *
   * @return array
   *  An associative array of cities data.
   */
  public function getJsonData();

  
}