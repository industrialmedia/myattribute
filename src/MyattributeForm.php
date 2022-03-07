<?php

namespace Drupal\myattribute;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\myattribute\Entity\Myattribute;

/**
 * Form controller for the myattribute entity edit forms.
 *
 * @ingroup myattribute
 */
class MyattributeForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildForm($form, $form_state);
    /* @var  \Drupal\myattribute\Entity\Myattribute $myattribute */
    $myattribute = $this->entity;
    $form['machine_name'] = [
      '#type' => 'machine_name',
      '#default_value' => $myattribute->getMachineName(),
      // '#disabled' => !$myattribute->isNew(), // Позволяем его менять
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
    if ($status == SAVED_UPDATED) {
      $this->messenger()->addStatus($this->t('The attribute has been updated.'));
      $form_state->setRedirect('entity.myattribute.collection');
    }
    else {
      $this->messenger()->addStatus($this->t('The attribute has been add.'));
      $form_state->setRedirect('entity.myattribute.collection');
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
    $myattribute = Myattribute::loadByMachineName($machine_name);
    return !empty($myattribute);
  }
  
}

