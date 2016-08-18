<?php

/**
 * @file
 * Rules integration for Urbano shipping.
 *
 * @addtogroup rules
 *
 * @{
 */

/**
 * Implements hook_rules_action_info().
 */
function commerce_servientrega_rules_action_info() {
  $actions = array();

  $actions['commerce_servientrega_set_shipment'] = array(
    'label' => t('Set shipment in Servientrega'),
    'description' => t('Sets the shipment in Servientrega, so it will be picked up at the store after confirmation in the website.'),
    'parameter' => array(
      'commerce_order' => array(
        'type' => 'commerce_order',
        'label' => t('Order'),
      ),
    ),
    'group' => t('Commerce Shipping (Servientrega)'),
  );

  return $actions;
}

/**
 * Action: Set shipment in Urbano.
 */
function commerce_servientrega_set_shipment($order) {
  try {
    module_load_include('inc', 'commerce_servientrega', 'includes/commerce_servientrega.service');

    $servientrega = new CommerceServientregaConnector();
    $servientrega->setPickup($order);

    if (module_exists('commerce_shipment_message')) {
      commerce_shipment_message_log_message($order, 'servientrega_shipping_service');
    }
  }
  catch (Exception $e) {
    watchdog_exception('commerce_servientrega', $e);

    return FALSE;
  }
}

/**
 * @}
 */
