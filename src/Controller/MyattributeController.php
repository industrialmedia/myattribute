<?php

namespace Drupal\myattribute\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\myattribute\Entity\Myattribute;


class MyattributeController extends ControllerBase {

  public function listAttributeValuesTitle($myattribute) {
    $myattribute = Myattribute::load($myattribute);
    return $myattribute->getName() . ': ' . t('List attribute values');
  }

}