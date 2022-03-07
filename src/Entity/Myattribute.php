<?php

namespace Drupal\myattribute\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\myattribute\MyattributeInterface;
use Drupal\user\UserInterface;


/**
 * Defines the Myattribute entity.
 *
 * @ingroup myattribute
 *
 * @ContentEntityType(
 *   id = "myattribute",
 *   label = @Translation("Myattribute entity"),
 *   handlers = {
 *     "storage" = "Drupal\myattribute\MyattributeStorage",
 *     "storage_schema" = "Drupal\myattribute\MyattributeStorageSchema",
 *     "list_builder" = "Drupal\myattribute\MyattributeListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "form" = {
 *       "add" = "Drupal\myattribute\MyattributeForm",
 *       "edit" = "Drupal\myattribute\MyattributeForm",
 *       "delete" = "Drupal\myattribute\Form\MyattributeDeleteForm",
 *     },
 *     "access" = "Drupal\myattribute\MyattributeAccessControlHandler",
 *   },
 *   fieldable = FALSE,
 *   translatable = TRUE,
 *   base_table = "myattribute",
 *   data_table = "myattribute_field_data",
 *   admin_permission = "administer myattribute entity",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "langcode" = "langcode",
 *     "weight" = "weight",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/commerce/myattribute/{myattribute}/edit",
 *     "edit-form" = "/admin/commerce/myattribute/{myattribute}/edit",
 *     "add-form" = "/admin/commerce/myattribute/add",
 *     "delete-form" = "/admin/commerce/myattribute/{myattribute}/delete",
 *     "collection" = "/admin/commerce/myattribute",
 *     "list-attribute-values" = "/admin/commerce/myattribute/{myattribute}"
 *   },
 *   field_ui_base_route = "entity.myattribute.collection",
 * )
 *
 * The 'links':
 * entity.<entity-name>.<link-name>
 * Example: 'entity.myattribute.canonical'
 *
 *  *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 */
class Myattribute extends ContentEntityBase implements MyattributeInterface {


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
    $myattributes = \Drupal::entityTypeManager()
      ->getStorage('myattribute')
      ->loadByAttributes(['machine_name' => $machine_name]);
    if (empty($myattributes)) {
      return NULL;
    }
    return reset($myattributes);
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
  public static function preDelete(EntityStorageInterface $storage, array $entities) {
    parent::preDelete($storage, $entities);

    /* @var \Drupal\myattribute\MyattributeStorage $storage */
    $myattribute_value_ids = $storage->getMyattributeValueIdsByMyattributeIds(array_keys($entities));

    /* @var \Drupal\myattribute\MyattributeValueStorage $myattribute_value_storage */
    $myattribute_value_storage = \Drupal::entityTypeManager()->getStorage('myattribute_value');
    $myattribute_values = $myattribute_value_storage->loadMultiple($myattribute_value_ids);
    $myattribute_value_storage->delete($myattribute_values);
    
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
      while ($myattribute = Myattribute::loadByMachineName($machine_name)) {
        $machine_name = $name_translit . '-' . $i;
        $i++;
      }
      $this->setMachineName($machine_name);
    }
  }

}