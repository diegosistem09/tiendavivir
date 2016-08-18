<?php

/**
 * @file
 * Admin functions for Commerce Servientrega.
 */

/**
 * Form builder function for module settings.
 */
function commerce_servientrega_settings_form() {
  $form = array();

  $form['credentials'] = array(
    '#type' => 'fieldset',
    '#title' => t('Credentials'),
    '#description' => t('Enter your Servientrega credentials.'),
  );
  $form['credentials']['commerce_servientrega_client'] = array(
    '#type' => 'textfield',
    '#title' => t('User Id'),
    '#default_value' => variable_get('commerce_servientrega_client', ''),
    '#required' => TRUE,
  );
  $form['credentials']['commerce_servientrega_key'] = array(
    '#type' => 'textfield',
    '#title' => t('Password'),
    '#default_value' => variable_get('commerce_servientrega_key', ''),
    '#required' => TRUE,
  );
  $form['credentials']['commerce_servientrega_invoice_code'] = array(
    '#type' => 'textfield',
    '#title' => t('Invoice Code'),
    '#default_value' => variable_get('commerce_servientrega_invoice_code', ''),
    '#required' => TRUE,
  );
  $form['credentials']['commerce_servientrega_name_code'] = array(
    '#type' => 'textfield',
    '#title' => t('Name Code'),
    '#default_value' => variable_get('commerce_servientrega_name_code', ''),
    '#required' => TRUE,
  );
  

  // $form['credentials']['commerce_urbano_server'] = array(
  //   '#type' => 'radios',
  //   '#title' => t("Urbano's server"),
  //   '#options' => array(
  //     'sandbox' => t('Sandbox'),
  //     'live' => t('Live'),
  //   ),
  //   '#default_value' => variable_get('commerce_urbano_server', 'sandbox'),
  //   'sandbox' => array('#description' => t('Use for testing.')),
  //   'live' => array('#description' => t('Use for real shipping.')),
  // );

  return system_settings_form($form);
}
