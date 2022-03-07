<?php

namespace Drupal\myattribute;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;


class MyattributeStorage extends SqlContentEntityStorage implements MyattributeStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function getMyattributeValueIdsByMyattributeIds($ids) {
    /* @var \Drupal\Core\Database\Query\Select $query */
    $query = $this->database->select('myattribute_value_field_data', 'pv');
    $query->addField('pv', 'id', 'id');
    $query->condition('pv.attribute_id', $ids, 'IN');
    $result = $query->execute();
    return $result->fetchCol();
  }

}
