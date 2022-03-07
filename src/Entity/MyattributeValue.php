<?php

namespace Drupal\myattribute\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\myattribute\MyattributeValueInterface;
use Drupal\user\UserInterface;



/**
 * Defines the MyattributeValue entity.
 *
 * @ingroup myattribute
 *
 * @ContentEntityType(
 *   id = "myattribute_value",
 *   label = @Translation("MyattributeValue entity"),
 *   handlers = {
 *     "storage" = "Drupal\myattribute\MyattributeValueStorage",
 *     "storage_schema" = "Drupal\myattribute\MyattributeValueStorageSchema",
 *     "list_builder" = "Drupal\myattribute\MyattributeValueListBuilder",
 *     "views_data" = "Drupal\myattribute\MyattributeValueViewsData",
 *     "form" = {
 *       "add" = "Drupal\myattribute\MyattributeValueForm",
 *       "edit" = "Drupal\myattribute\MyattributeValueForm",
 *       "delete" = "Drupal\myattribute\Form\MyattributeValueDeleteForm",
 *     },
 *     "access" = "Drupal\myattribute\MyattributeValueAccessControlHandler",
 *   },
 *   fieldable = FALSE,
 *   translatable = TRUE,
 *   base_table = "myattribute_value",
 *   data_table = "myattribute_value_field_data",
 *   admin_permission = "administer myattribute_value entity",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "langcode" = "langcode",
 *     "weight" = "weight",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/commerce/myattribute_value/{myattribute_value}/edit",
 *     "edit-form" = "/admin/commerce/myattribute_value/{myattribute_value}/edit",
 *     "add-form" = "/admin/commerce/myattribute/{myattribute}/add",
 *     "delete-form" = "/admin/commerce/myattribute/{myattribute_value}/delete",
 *     "collection" = "/admin/commerce/myattribute/{myattribute}"
 *   },
 *   field_ui_base_route = "entity.myattribute.list_attribute_values",
 * )
 *
 * The 'links':
 * entity.<entity-name>.<link-name>
 * Example: 'entity.myattribute_value.canonical'
 *
 *  *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 */
class MyattributeValue extends ContentEntityBase implements MyattributeValueInterface {




  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function getChangedTime() {
    return $this->get('changed')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setChangedTime($timestamp) {
    $this->set('changed', $timestamp);
    return $this;
  }


  /**
   * {@inheritdoc}
   */
  public function getWeight() {
    return $this->get('weight')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setWeight($weight) {
    $this->set('weight', $weight);
    return $this;
  }


  /**
   * {@inheritdoc}
   */
  public function getChangedTimeAcrossTranslations() {
    $changed = $this->getUntranslated()->getChangedTime();
    /* @var \Drupal\Core\Language\Language $language */
    foreach ($this->getTranslationLanguages(FALSE) as $language) {
      $translation_changed = $this->getTranslation($language->getId())
        ->getChangedTime();
      $changed = max($translation_changed, $changed);
    }
    return $changed;
  }


  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('uid')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('uid', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('uid')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('uid', $account->id());
    return $this;
  }


  /**
   * {@inheritdoc}
   */
  public function getAttributeId() {
    return $this->get('attribute_id')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setAttributeId($attribute_id) {
    $this->set('attribute_id', $attribute_id);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getMyattribute() {
    return $this->get('attribute_id')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function setMyattribute($myattribute) {
    $this->set('attribute_id', $myattribute->id());
    return $this;
  }


  /**
   * {@inheritdoc}
   */
  public function getName() {
    return $this->get('name')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setName($name) {
    $this->set('name', $name);
    return $this;
  }


  /**
   * {@inheritdoc}
   */
  public function getMachineName() {
    return $this->get('machine_name')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setMachineName($machine_name) {
    $this->set('machine_name', $machine_name);
    return $this;
  }


  /**
   * {@inheritdoc}
   */
  public static function loadByMachineName($machine_name) {
    $myattribute_values = \Drupal::entityTypeManager()
      ->getStorage('myattribute_value')
      ->loadByAttributes(['machine_name' => $machine_name]);
    if (empty($myattribute_values)) {
      return NULL;
    }
    return reset($myattribute_values);
  }


  /**
   * {@inheritdoc}
   */
  public static function loadByMachineNameAndAttributeId($machine_name, $attribute_id) {
    $myattribute_values = \Drupal::entityTypeManager()
      ->getStorage('myattribute_value')
      ->loadByAttributes(['machine_name' => $machine_name, 'attribute_id' => $attribute_id]);
    if (empty($myattribute_values)) {
      return NULL;
    }
    return reset($myattribute_values);
  }



  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    /** @var \Drupal\Core\Field\BaseFieldDefinition[] $fields */
    $fields = parent::baseFieldDefinitions($entity_type);
    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Attribute name'))
      ->setRequired(TRUE)
      ->setTranslatable(TRUE)
      ->setSetting('max_length', 255)
      ->setDisplayOptions('form', array(
        'type' => 'string_textfield',
        'weight' => 0,
      ))
      ->setDisplayConfigurable('form', TRUE);
    $fields['machine_name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Machine name'))
      ->setRequired(TRUE)
      ->setSetting('max_length', 255);
    $fields['uid'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('User Name'))
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default');
    $fields['langcode'] = BaseFieldDefinition::create('language')
      ->setLabel(t('Language code'));
    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'));
    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'));
    $fields['weight'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Weight'))
      ->setRequired(TRUE)
      ->setDefaultValue(0)
      ->setDisplayOptions('form', array(
        'type' => 'integer',
        'weight' => 10,
      ))
      ->setDisplayConfigurable('form', TRUE);
    $fields['attribute_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Attribute'))
      ->setRequired(TRUE)
      ->setSetting('target_type', 'myattribute')
      ->setSetting('handler', 'default')
      ->setDisplayOptions('form', array(
        'type' => 'options_select',
        'weight' => 0,
      ))
      ->setDisplayConfigurable('form', TRUE);
    return $fields;
  }


  /**
   * {@inheritdoc}
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += array(
      'uid' => \Drupal::currentUser()->id(),
    );
  }


  /**
   * {@inheritdoc}
   */
  public function preSave(EntityStorageInterface $storage) {
    parent::preSave($storage);
    $machine_name = $this->getMachineName();
    if (empty($machine_name)) {
      $name = $this->getName();
      $name_translit = _myattribute_transliterate($name);
      $machine_name = $name_translit;
      $i = 2;
      while ($myattribute_value = MyattributeValue::loadByMachineNameAndAttributeId($machine_name, $this->getAttributeId())) {
        $machine_name = $name_translit . '-' . $i;
        $i++;
      }
      $this->setMachineName($machine_name);
    }
  }







}