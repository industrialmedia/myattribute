<?php

namespace Drupal\myattribute;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\EntityStorageInterface;


/**
 * Provides a list controller for myattribute_value entity.
 * @ingroup myattribute
 */
class MyattributeValueListBuilder extends EntityListBuilder {


  protected $attribute_id;


  public function __construct(EntityTypeInterface $entity_type, EntityStorageInterface $storage) {
    parent::__construct($entity_type, $storage);
    $this->attribute_id = \Drupal::request()->attributes->get('myattribute');
  }


  /**
   * Loads entity IDs using a pager sorted by the entity id.
   *
   * @return array
   *   An array of entity IDs.
   */
  protected function getEntityIds() {
    $query = $this->getStorage()->getQuery()
      ->condition('attribute_id', $this->attribute_id)
      ->sort('weight');
    // Only add the pager if a limit is specified.
    if ($this->limit) {
      $query->pager($this->limit);
    }
    return $query->execute();
  }


  /**
   * {@inheritdoc}
   */
  public function render() {
    $build = parent::render();
    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['name'] = $this->t('Name');
    $header['machine_name'] = $this->t('Machine name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $myattribute) {
    /* @var $myattribute \Drupal\myattribute\Entity\Myattribute */
    $row = [];
    $row['name'] = $myattribute->getName();
    $row['machine_name'] = $myattribute->getMachineName();
    return $row + parent::buildRow($myattribute);
  }

}
