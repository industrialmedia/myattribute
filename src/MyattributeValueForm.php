<?php

namespace Drupal\myattribute;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Entity\EntityTypeBundleInfoInterface;
use Drupal\Component\Datetime\TimeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityRepositoryInterface;
use Drupal\myattribute\Entity\MyattributeValue;



/**
 * Form controller for the myattribute entity edit forms.
 *
 * @ingroup myattribute
 */
class MyattributeValueForm extends ContentEntityForm {


  /**
   * The attribute_id.
   *
   * @var int
   */
  protected $attribute_id;


  /**
   * Constructs a ContentEntityForm object.
   *
   * @param \Drupal\Core\Entity\EntityRepositoryInterface $entity_repository
   *   The entity repository service.
   * @param \Drupal\Core\Entity\EntityTypeBundleInfoInterface $entity_type_bundle_info
   *   The entity type bundle service.
   * @param \Drupal\Component\Datetime\TimeInterface $time
   *   The time service.
   */
  public function __construct(EntityRepositoryInterface $entity_repository, EntityTypeBundleInfoInterface $entity_type_bundle_info = NULL, TimeInterface $time = NULL) {
    parent::__construct($entity_repository, $entity_type_bundle_info, $time);
    $this->attribute_id = \Drupal::request()->attributes->get('myattribute');
  }


  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {

    /* @var \Drupal\Core\Entity\EntityRepositoryInterface $entity_repository */
    $entity_repository = $container->get('entity.repository');
    
    return new static(
      $entity_repository,
      $container->get('entity_type.bundle.info'),
      $container->get('datetime.time')
    );
  }


  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $callback_object \Drupal\mynotify\MynotifyForm */
    $callback_object = $form_state->getBuildInfo()['callback_object'];
    $operation = $callback_object->getOperation();
    if ($operation == 'add') {
      /* @var $myattribute_value \Drupal\myattribute\Entity\MyattributeValue */
      $myattribute_value = $this->getEntity();
      if (empty($myattribute_value->getAttributeId())) {
        $myattribute_value->setAttributeId($this->attribute_id);
      }
    }
    $form = parent::buildForm($form, $form_state);

    /* @var  \Drupal\myattribute\Entity\MyattributeValue $myattribute_value */
    $myattribute_value = $this->entity;
    $form['machine_name'] = [
      '#type' => 'machine_name',
      '#default_value' => $myattribute_value->getMachineName(),
      // '#disabled' => !$myattribute_value->isNew(), // Позволяем его менять
      '#maxlength' => 64,
      '#description' => 'Уникальное имя, изменять это значение не рекомендуют, оно может использоваться в стилях, урле...',
      '#machine_name' => [
        'exists' => [$this, 'machineNameExists'],
        'source' => ['name', 'widget', 0, 'value'],
        'replace_pattern' => '[^a-z0-9-]+',
        'replace' => '-',
      ],
    ];
    
    
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $status = parent::save($form, $form_state);
    /* @var $myattribute_value \Drupal\myattribute\Entity\MyattributeValue */
    $myattribute_value = $this->getEntity();
    if ($status == SAVED_UPDATED) {
      $this->messenger()
        ->addMessage($this->t('The attribute value has been updated.'));
      $form_state->setRedirect('entity.myattribute.list_attribute_values', ['myattribute' => $myattribute_value->getAttributeId()]);
    }
    else {
      $this->messenger()
        ->addMessage($this->t('The attribute value has been add.'));
      $form_state->setRedirect('entity.myattribute.list_attribute_values', ['myattribute' => $myattribute_value->getAttributeId()]);
    }
    return $status;
  }


  /**
   * Determines if the myattribute already exists.
   *
   * @param string $machine_name
   *   The myattribute machine_name.
   *
   * @return bool
   *   TRUE if the myattribute exists, FALSE otherwise.
   */
  public function machineNameExists($machine_name) {
    /* @var  \Drupal\myattribute\Entity\MyattributeValue $myattribute_value */
    $myattribute_value = $this->entity;
    $myattribute_value_exists = MyattributeValue::loadByMachineNameAndAttributeId($machine_name, $myattribute_value->getAttributeId());
    return !empty($myattribute_value_exists);
  }



}

