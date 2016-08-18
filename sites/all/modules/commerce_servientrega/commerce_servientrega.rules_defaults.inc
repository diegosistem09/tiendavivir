<?php

/**
 * @file
 * Default rules configurations for Commerce Urbano.
 */

/**
 * Implements hook_default_rules_configuration().
 */
function commerce_servientrega_default_rules_configuration() {
  $rules = array();

  // When an order is first paid in full we need to create the shipment 
  $rule = rules_reaction_rule();

  $rule->label = t('Servientrega: Create shipment');
  $rule->active = TRUE;

  $rule
    ->event('commerce_payment_order_paid_in_full')
    ->condition('commerce_shipping_compare_shipping_service', array(
      'commerce_order:select' => 'commerce_order',
      'service' => 'servientrega_shipping_service',
    ))
    ->action('commerce_servientrega_set_shipment', array(
      'commerce_order:select' => 'commerce_order',
    ));

  $rules['commerce_servientrega_create_shipment'] = $rule;

  return $rules;
}
