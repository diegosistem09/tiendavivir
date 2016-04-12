<?php

/**
 * Definition of Tab Shortcodes
 */

/**
 * Implements hook_shortcode_info
 */
global $art_shortcode_gallery;
global $art_shortcode_galleries_categories;
$art_shortcode_galleries_categories = array();
function _gallery_shortcode_info(&$shortcodes) {
	$shortcodes['gallery'] = array(
		'title' => t('Gallery'),
		'description' => t('Create Isotope gallery'),
		'process callback' => 'art_shortcode_gallery',
		'cache' => TRUE,
	);
	
	$shortcodes['gallery_item'] = array(
		'title' => t('Gallery Item'),
		'process callback' => 'art_shortcode_gallery_item',
		'cache' => TRUE,
	);
	
	return $shortcodes;
}


/**
 * Isotope Gallery Container
 */
function art_shortcode_gallery($attrs, $text) {
	global $art_shortcode_gallery;
	if(empty($art_shortcode_gallery)){
		$art_shortcode_gallery = 1;
	}
	global $art_shortcode_galleries_categories;
	$attrs = shortcode_attrs(array(
			'cols' => '4',
			'filter' => 'no'
		),
		$attrs
	);
	return theme('art_shortcode_gallery', array(
		'cols' => $attrs['cols'],
		'categories' => $art_shortcode_galleries_categories,
		'filter' => $attrs['filter'],
		'content' => $text
	));
}

/**
 * Gallery Item
 */
function art_shortcode_gallery_item($attrs, $text) {		
	global $art_shortcode_galleries_categories;
	$attrs = shortcode_attrs(array(
			'tag' => '',
			'image' => '',
		),
		$attrs
	);
	$art_shortcode_galleries_categories[$attrs['tag']] = $attrs['tag'];
	return theme('art_shortcode_gallery_item',array(
		'tag' => $attrs['tag'],
		'image' => $attrs['image'],
		'content' => $text,
	));
}

/**
 * Icon theme
 */
function _gallery_theme(&$themes) {
	$path = drupal_get_path('module','art_shortcode');
	$themes['art_shortcode_gallery'] = array(
		'template' => 'gallery',
		'path' => $path . '/theme',
		'variables' => array(
			'cols' => '',
			'filter' => '',
		)
	);
	$themes['art_shortcode_gallery_item'] = array(
		'template' => 'galleryitem',
		'path' => $path . '/theme',
		'variables' => array(
			'tag' => '',
			'image' => '',
			'content' => '',
		)
	);
	
	return $themes;
}