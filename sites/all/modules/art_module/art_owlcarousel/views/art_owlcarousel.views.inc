<?php

/**
 * @file
 * Defines the views style plugin for the owl carousel
 */

/**
 * Implements hook_views_plugins()
 */
function art_owlcarousel_views_plugins() {
	return array(
		'style' => array(
			'owl_carousel' => array(
				'title' => t('Owl Carousel'),
				'help' => t('Display the results as a owl carousel slideshow'),
				'handler' => 'art_owlcarousel_plugin_style_owl_carousel',
				'uses options' => TRUE,
				'uses row plugin' => TRUE,
				'uses row class' => TRUE,
				'type' => 'normal',
				'theme' => 'views_owl_carousel',
				'theme path' => drupal_get_path('module','art_owlcarousel') . '/theme',
				'theme file' => 'art_owlcarousel.theme.inc',
			),
		),
	);
}

// !TODO: Preprocess function