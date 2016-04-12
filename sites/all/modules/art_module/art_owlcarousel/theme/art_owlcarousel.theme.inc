<?php

/**
 * Preprocess functions of Owl Carousel
 */

function _views_slideshow_preprocess_views_owl_carousel(&$vars) {
	$options = $vars['options'];
	$view = $vars['view'];
	
	$view_id = $view->name . '-' . $view->current_display;
	$vars['view_id'] = $view_id;
	$vars['wrapper_class'] = $options['wrapper_class'];
	$library = libraries_get_libraries();
	if (isset($library['owlcarousel'])) {
		// Include Owl Carousel
		$path = $library['owlcarousel'];
		drupal_add_css($path . '/jquery.owl.carousel.css');
		drupal_add_js($path . '/jquery.imagesloaded.min.js');
		drupal_add_js($path . '/jquery.owl.carousel.min.js');
	}
	//print_r($options);
	$js_settings = array(
		'owlCarousel' => array(
			$view_id => array(
				'items' => $options['items'],
				'itemsDesktop' => $options['itemsDesktop'],
				'itemsDesktopSmall' => $options['itemsDesktopSmall'],
				'itemsTablet' => $options['itemsTablet'],
				'itemsMobile' => $options['itemsMobile'],
				'transitionStyle' => $options['transitionStyle'],
				'autoHeight' => ($options['autoHeight']) ? true : false,
				'singleItem' => ($options['singleItem']) ? true : false,
				'pagination' => ($options['pagination']) ? true : false,
				'navigation' => ($options['navigation']) ? true : false,
			),
		),
	);
	//echo '<pre>'; print_r($js_settings); exit;
	drupal_add_js($js_settings,'setting');
	// Add main setting js
	$responsive_js_path = drupal_get_path('module','art_owlcarousel') . '/js/art_owlcarousel.js';
	drupal_add_js($responsive_js_path);

	template_preprocess_views_view_unformatted($vars);
}