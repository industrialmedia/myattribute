<?php


namespace Drupal\myattribute\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Field\FieldDefinitionInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\myattribute\MyattributeStorageInterface;
use Drupal\myattribute\MyattributeValueStorageInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;


/**
 * @FieldWidget(
 *   id = "myattribute_value_entity_reference_widget",
 *   module = "myattribute",
 *   label = @Translation("Myattribute value entity reference widget"),
 *   field_types = {
 *     "entity_reference"
 *   },
 *   multiple_values = TRUE
 * )
 */
class MyattributeValueEntityReferenceWidget extends WidgetBase implements ContainerFactoryPluginInterface {


  /**
   * The myattribute storage.
   *
   * @var \Drupal\myattribute\MyattributeStorageInterface.
   */
  protected $myattributeStorage;


  /**
   * The myattribute_value storage.
   *
   * @var \Drupal\myattribute\MyattributeValueStorageInterface.
   */
  protected $myattributeValueStorage;


  /**
   * Constructs a new ModerationStateWidget object.
   *
   * @param string $plugin_id
   *   Plugin id.
   * @param mixed $plugin_definition
   *   Plugin definition.
   * @param \Drupal\Core\Field\FieldDefinitionInterface $field_definition
   *   Field definition.
   * @param array $settings
   *   Field settings.
   * @param array $third_party_settings
   *   Third party settings.
   * @param \Drupal\myattribute\MyattributeStorageInterface $myattribute_storage
   *   The myattribute storage.
   * @param \Drupal\myattribute\MyattributeValueStorageInterface $myattribute_value_storage
   *   The myattribute_value storage.
   */
  public function __construct($plugin_id, $plugin_definition, FieldDefinitionInterface $field_definition, array $settings, array $third_party_settings, MyattributeStorageInterface $myattribute_storage, MyattributeValueStorageInterface $myattribute_value_storage) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $third_party_settings);
    $this->myattributeStorage = $myattribute_storage;
    $this->myattributeValueStorage = $myattribute_value_storage;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $plugin_id,
      $plugin_definition,
      $configuration['field_definition'],
      $configuration['settings'],
      $configuration['third_party_settings'],
      $container->get('entity_type.manager')->getStorage('myattribute'),
      $container->get('entity_type.manager')->getStorage('myattribute_value')
    );
  }


  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    /** @var \Drupal\link\LinkItemInterface $item */
    /** @var \Drupal\Field\Entity\FieldConfig $field */
    /** @var \Drupal\myattribute\Entity\Myattribute $myattribute */
    /** @var \Drupal\myattribute\Entity\MyattributeValue $myattribute_value */

    $default_value = [];
    $items_values = $items->getValue();
    if (!empty($items_values)) {
      foreach ($items_values as $items_value) {
        if (!empty($items_value['target_id'])) {
          $default_value[] = $items_value['target_id'];
        }
      }
    }

    $myattribute_values = $this->myattributeValueStorage->loadMultiple();
    $options = [];
    foreach ($myattribute_values as $myattribute_value) {
      $myattribute = $myattribute_value->getMyattribute();
      if ($myattribute) {
        $options[$myattribute->id()]['name'] = $myattribute->label();
        $options[$myattribute->id()]['values'][$myattribute_value->id()] = $myattribute_value->label();
      }

    }

    $element['target_id'] = [];
    if ($options) {
      foreach ($options as $attribute_id => $value) {
        $element['target_id'][$attribute_id] = [
          '#type' => 'select',
          '#title' => $value['name'],
          '#options' => $value['values'],
          '#empty_option' => '- Select -',
          '#default_value' => $default_value,
          '#required' => $element['#required'],
        ];
      }
    }

    return $element;
  }


  /**
   * {@inheritdoc}
   */
  public function massageFormValues(array $values, array $form, FormStateInterface $form_state) {
    $values = array_diff($values['target_id'], array(''));
    return $values;
  }


  /**
   * {@inheritdoc}
   */
  public static function isApplicable(FieldDefinitionInterface $field_definition) {
    return $field_definition->getFieldStorageDefinition()
      ->getSetting('target_type') == 'myattribute_value';
  }


}
