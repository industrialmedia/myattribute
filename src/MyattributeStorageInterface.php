<?php

namespace Drupal\myattribute;

use Drupal\Core\Entity\ContentEntityStorageInterface;


interface MyattributeStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets myattribute_value IDs of myattribute IDs.
   *
   * @param array $ids
   *   Array of myattribute IDs.
   * @return array
   *   Array of myattribute_value IDs.
   */
  public function getMyattributeValueIdsByMyattributeIds($ids);


}
