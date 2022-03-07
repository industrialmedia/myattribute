<?php

namespace Drupal\myattribute;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\user\EntityOwnerInterface;
use Drupal\Core\Entity\EntityChangedInterface;

/**
 * Provides an interface defining a Myattribute entity.
 * @ingroup myattribute
 */
interface MyattributeValueInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

  /**
   * Gets the myattribute_value creation timestamp.
   *
   * @return int
   *   Creation timestamp of the myattribute_value.
   */
  public function getCreatedTime();



  /**
   * Gets the attribute_id.
   *
   * @return int
   *   attribute_id of the myattribute_value.
   */
  public function getAttributeId();

  /**
   * Sets the myattribute_value attribute_id.
   *
   * @param int $attribute_id
   *   The myattribute_value attribute_id.
   *
   * @return \Drupal\myattribute\MyattributeValueInterface
   *   The called myattribute_value entity.
   */
  public function setAttributeId($attribute_id);



  /**
   * Gets the myattribute.
   *
   * @return \Drupal\myattribute\MyattributeInterface
   *   myattribute of the myattribute_value.
   */
  public function getMyattribute();

  /**
   * Sets the myattribute_value myattribute.
   *
   * @param \Drupal\myattribute\MyattributeInterface $myattribute
   *   The myattribute_value myattribute.
   *
   * @return \Drupal\myattribute\MyattributeValueInterface
   *   The called myattribute_value entity.
   */
  public function setMyattribute($myattribute);


  /**
   * Gets the name.
   *
   * @return string
   *   name of the myattribute_value.
   */
  public function getName();

  /**
   * Sets the myattribute_value name.
   *
   * @param string $name
   *   The myattribute_value name.
   *
   * @return \Drupal\myattribute\MyattributeValueInterface
   *   The called myattribute_value entity.
   */
  public function setName($name);


  /**
   * Gets the machine_name.
   *
   * @return string
   *   machine_name of the myattribute_value.
   */
  public function getMachineName();

  /**
   * Sets the myattribute_value machine_name.
   *
   * @param string $machine_name
   *   The myattribute_value machine_name.
   *
   * @return \Drupal\myattribute\MyattributeValueInterface
   *   The called myattribute_value entity.
   */
  public function setMachineName($machine_name);



  /**
   * Load the myattribute_value by machine_name.
   *
   * @param string $machine_name
   *   The myattribute_value machine_name.
   *
   * @return \Drupal\myattribute\MyattributeValueInterface
   *   The called myattribute_value entity.
   */
  public static function loadByMachineName($machine_name);



  /**
   * Load the myattribute_value by machine_name and attribute_id.
   *
   * @param string $machine_name
   *   The myattribute_value machine_name.
   * @param int $attribute_id
   *   The myattribute_value attribute_id.
   *
   * @return \Drupal\myattribute\MyattributeValueInterface
   *   The called myattribute_value entity.
   */
  public static function loadByMachineNameAndAttributeId($machine_name, $attribute_id);

}



