<?php

/**
 * Definition of Icon Shortcode
 */

/**
 * Implements hook_shortcode_info
 */
function _tooltip_shortcode_info(&$shortcodes) {
	$shortcodes['tooltip'] = array(
		'title' => t('Tooltip'),
		'description' => t('Create a Tooltip'),
		'process callback' => 'art_shortcode_tooltip',
		//'tips callback' => 'art_shortcode_icon_tip',
	);
	return $shortcodes;
}

/**
 * Icon Content
 */
function art_shortcode_tooltip($attrs, $text) {
	$attrs = shortcode_attrs(array(
			'tip' => '',
			'position' => 'top',
		),
		$attrs
	);
	return '<span data-toggle="tooltip" data-placement="'.$attrs['position'].'" class="art-tooltip" data-original-title="'.$attrs['tip'].'">'.$text.'</span>';
}