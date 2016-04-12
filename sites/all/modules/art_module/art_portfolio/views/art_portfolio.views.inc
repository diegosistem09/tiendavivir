<?php

/**
 * @file
 * Defines portfolio views styles
 */

/**
 * Implements hook_views_plugins
 */
function art_portfolio_views_plugins() {
	return array(
		'style' => array(
			'art_portfolio' => array(
				'title' => t('Art Portfolio'),
				'help' => t('Display the results as an Isotope Portfolio'),
				'handler' => 'art_portfolio_plugin_style_portfolio',
				'uses options' => TRUE,
				'uses row plugin' => TRUE,
				'uses row class' => TRUE,
				'type' => 'normal',
				'theme' => 'views_art_portfolio',
				'theme path' => drupal_get_path('module','art_portfolio') . '/theme',
				'theme file' => 'art_portfolio.theme.inc',
			),
		),
	);
}