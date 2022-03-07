<?php

namespace Drupal\myattribute;

use Drupal\views\EntityViewsData;

/**
 * Provides the views data for the MyattributeValue entity type.
 */
class MyattributeValueViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();


    $data['myattribute_value_field_data']['table']['base']['help'] = $this->t('MyattributeValue entity.');
    $data['myattribute_value_field_data']['table']['wizard_id'] = 'myattribute_value';



    $data['myattribute_value_field_data']['id']['help'] = $this->t('The id of a MyattributeValue.');

    $data['myattribute_value_field_data']['id']['filter']['id'] = 'myattribute_value_id';
    $data['myattribute_value_field_data']['id']['filter']['title'] = $this->t('MyattributeValue');
    $data['myattribute_value_field_data']['id']['filter']['help'] = $this->t('MyattributeValue chosen from autocomplete or select widget.');
    $data['myattribute_value_field_data']['id']['filter']['numeric'] = TRUE;

    $data['myattribute_value_field_data']['id_raw'] = [
      'title' => $this->t('MyattributeValue ID'),
      'help' => $this->t('The id of a MyattributeValue.'),
      'real field' => 'id',
      'filter' => [
        'id' => 'numeric',
        'allow empty' => TRUE,
      ],
    ];
  





    return $data;
  }

}
