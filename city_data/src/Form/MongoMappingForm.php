<?php

/**
 * @file
 * Custom form to create mapping between drupal and mongdb.
 */

namespace Drupal\city_data\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * This form is mapping form to allow admin to change mapping for city data contents.
 */
class MongoMappingForm extends FormBase {

  /**
   * Provides Config of city's data.
   *
   * @var \\Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $config;

  /**
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config
   */
  public function __construct(ConfigFactoryInterface $config) {
    $this->config = $config->get('migrate_plus.migration.city_data');
  }

  /**
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *
   * @return static
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory')
    );
  }

  /**
   * {@inheritdoc}.
   */
  public function getFormId() {
    return 'mongo_mapping_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $show_popup = NULL) {

    $fields = ["drupalside", "mongoside"];
    $header = ["Content type fileds", "Mongo data field"];
    
    // Get process mapping from city data configuration.
    $process = $this->config->get('process');
    ksm($process);

    $non_field_key = ["type", "sticky", "uid","title", "field_city_latitude","field_city_longitude"];

    // Parent container.
    $form['mongo'] = array(
      '#type' => 'container',
      '#tree' => true,
      '#prefix' => '<div class="mongo-cntr row">',
      '#suffix' => '</div>',
    );

    // Header markup.
    foreach ($header as $heading) {
      $form['mongo']['headers'][$heading] = array(
        '#type' => 'markup',
        '#markup' => $this->t($heading),
        '#prefix' => '<div class="col-sm-6">',
        '#suffix' => '</div>',
      );
    }

    // Child container.
    foreach ($fields as $type) {
      $form['mongo'][$type] = array(
        '#type' => 'container',
        '#tree' => true,
        '#prefix' => '<div class="col-sm-6">',
        '#suffix' => '</div>',
      );

      // Textfields for drupal and mongodb fields.
      foreach ($process as $key => $value) {
        if (!in_array($key, $non_field_key)) {
          if ($type == "mongoside") {
            $key = $value;
          }
          
          $form['mongo'][$type][$key] = array(
            '#type' => 'textfield',
            '#required' => TRUE,
            '#default_value' => $key,
          );
        }
      }
    }

    // Submit Button.
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Update Mapping'),
      '#button_type' => 'primary',
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    // Get only process mapping fields from city data configuration.
    $process = $this->config->get('process');
     ksm($process,"111");
    $non_field_key = ["type", "sticky", "uid","title", "field_city_latitude","field_city_longitude"];
    foreach ($process as $key => $value) {
      if (!in_array($key, $non_field_key)) {
        unset($process[$key]);
      }
    }

    // Get form values from form.
    $form_values = $form_state->getValues();
    // Get drupal's city data content type field name.
    $drupal_side_fields = $form_values["mongo"]["drupalside"];
    // Get field name of mongodb side.
    $mongo_side_fields = $form_values["mongo"]["mongoside"];
    // Get updated mapping.
    $updated_arr = array_combine($drupal_side_fields, $mongo_side_fields);
    // Array merge for drupal and mongo side.
    ksm($process,"222");
    ksm($updated_arr,"333");
    $final_updated_arr = (array_merge($process, $updated_arr));
      ksm($final_updated_arr,"444");
    // Update configurations changed by admin.
    $config_factory = \Drupal::configFactory();
    $config_factory->getEditable('migrate_plus.migration.city_data')->set('process', $final_updated_arr)->save();
  }

}
