<?php

namespace Drupal\myattribute;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\user\EntityOwnerInterface;
use Drupal\Core\Entity\EntityChangedInterface;

/**
 * Provides an interface defining a Myattribute entity.
 * @ingroup myattribute
 */
interface MyattributeInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {



  /**
   * Gets the myattribute creation timestamp.
   *
   * @return int
   *   Creation timestamp of the myattribute.
   */
  public function getCreatedTime();


  /**
   * Gets the weight.
   *
   * @return int
   *   weight of the myattribute.
   */
  public function getWeight();


  /**
   * Sets the myattribute weight.
   *
   * @param int $weight
   *   The myattribute weight.
   *
   * @return \Drupal\myattribute\MyattributeInterface
   *   The called myattribute entity.
   */
  public function setWeight($weight);

  /**
   * Gets the name.
   *
   * @return string
   *   name of the myattribute.
   */
  public function getName();

  /**
   * Sets the myattribute name.
   *
   * @param string $name
   *   The myattribute name.
   *
   * @return \Drupal\myattribute\MyattributeInterface
   *   The called myattribute entity.
   */
  public function setName($name);



  /**
   * Gets the machine_name.
   *
   * @return string
   *   machine_name of the myattribute.
   */
  public function getMachineName();

  /**
   * Sets the myattribute machine_name.
   *
   * @param string $machine_name
   *   The myattribute machine_name.
   *
   * @return \Drupal\myattribute\MyattributeInterface
   *   The called myattribute entity.
   */
  public function setMachineName($machine_name);



  /**
   * Load the myattribute by machine_name.
   *
   * @param string $machine_name
   *   The myattribute machine_name.
   *
   * @return \Drupal\myattribute\MyattributeInterface
   *   The called myattribute entity.
   */
  public static function loadByMachineName($machine_name);
  
}



