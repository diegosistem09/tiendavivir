<?php

function art_revolution_form($slideid = 0) {
    $slideid = arg(2);
    if (is_numeric($slideid)) {
        $slide = db_select('{art_revolution}', 'd')->fields('d')->condition('id', $slideid, '=')->execute()->fetchAssoc();
    } else {
        $slide = array('id' => 0, 'name' => '');
    }
    $form = array();
    $form['id'] = array(
        '#type' => 'hidden',
        '#default_value' => $slide['id']
    );
    $form['name'] = array(
        '#type' => 'textfield',
        '#title' => 'Name',
        '#default_value' => $slide['name']
    );
    $form['submit'] = array(
        '#type' => 'submit',
        '#value' => 'Save'
    );
    return $form;
}

function art_revolution_form_submit($form, $form_state) {
    if ($form['id']['#value']) {
        $sid = db_update("art_revolution")
                ->fields(array(
                    'name' => $form['name']['#value'],
                ))
                ->condition('id', $form['id']['#value'])
                ->execute();
        drupal_set_message("Slide '{$form['name']['#value']}' has been updated");
    } else {
        $sid = db_insert("art_revolution")
                ->fields(array(
                    'name' => $form['name']['#value'],
                    'settings' => '',
                    'data' => ''
                ))
                ->execute();
        drupal_set_message("Slide '{$form['name']['#value']}' has been created");
    }
    drupal_goto('admin/art_revolution');
}