<?php

namespace Drupal\myattribute\Form;

use Drupal\Core\Entity\ContentEntityDeleteForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a form for deleting a myattribute entity.
 *
 * @ingroup myattribute
 */
class MyattributeValueDeleteForm extends ContentEntityDeleteForm {


  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);
    /* @var \Drupal\myattribute\Entity\MyattributeValue $myattribute_value */
    $myattribute_value = $this->getEntity();
    $form_state->setRedirect('entity.myattribute.list_attribute_values', ['myattribute' => $myattribute_value->getAttributeId()]);
  }

}


