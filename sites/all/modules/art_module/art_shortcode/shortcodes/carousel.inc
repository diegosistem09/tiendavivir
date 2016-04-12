<?php

/**
 * Definition of Carousel Shortcode
 */

/**
 * Implements hook_shortcode_info
 */
function _carousel_shortcode_info(&$shortcodes) {
	$shortcodes['carousel'] = array(
		'title' => t('Carousel'),
		'description' => t('Create a Carousel of items with captions'),
		'process callback' => 'art_shortcode_carousel',
		'tips callback' => 'art_shortcode_carousel_tip',
	);
	
	$shortcodes['carousel_item'] = array(
		'title' => t('Carousel Item'),
		'description' => t('Create a carousel item to go inside a carousel'),
		'process callback' => 'art_shortcode_carousel_item',
		'tips callback' => 'art_shortcode_carousel_item_tip',
	);
	
	
	return $shortcodes;
}

/**
 * Carousel Content
 */
function art_shortcode_carousel($attrs, $text) {
	$attrs = shortcode_attrs(array(
			'id' => '',
			'class' => '',
			'title' => '',
		),
		$attrs
	);
	
	$class = shortcode_add_class($attrs['class'],'testiomials_carousel m_bottom_35');
	return theme('carousel',array('id' => $attrs['id'],'class' => $class,'content' => $text,'title'=>$attrs['title']));
}

/**
 * Carousel Item
 */
function art_shortcode_carousel_item($attrs, $text) {
	$attrs = shortcode_attrs(array(
			'class' => '',
		),
		$attrs
	);
	
	$class = shortcode_add_class($attrs['class'],'item');
	return theme('carousel_item',array('class' => $class,'content' => $text));
}


/**
 * Carousel theme
 */
function _carousel_theme(&$themes) {
	$themes['carousel'] = array(
		'variables' => array(
			'id' => '',
			'class' => '',
			'content' => ''
		)
	);
	
	$themes['carousel_item'] = array(
		'variables' => array(
			'class' => '',
			'content' => ''
		)
	);

	return $themes;
}

/**
 * Theme Carousel
 */
function theme_carousel($vars) {
	$id = $vars['id'];
	$class = $vars['class'];
	$title = $vars['title'];
	$content = $vars['content'];
        
        $output = '<div class="clearfix m_bottom_25">
								<h2 class="tt_uppercase color_dark f_left f_sm_none m_sm_bottom_15">'.$title.'</h2>
								<div class="f_right clearfix nav_buttons_wrap f_mxs_none f_sm_none">
									<button class="button_type_7 bg_cs_hover box_s_none f_size_ex_large bg_light_color_1 f_left tr_delay_hover r_corners ti_prev"><i class="fa fa-angle-left"></i></button><button class="button_type_7 bg_cs_hover box_s_none f_size_ex_large bg_light_color_1 f_left m_left_5 tr_delay_hover r_corners ti_next"><i class="fa fa-angle-right"></i></button>
								</div>
							</div>';
	$output .= '<div id="'.$id.'" class="'.$class.'">';
	//$output .= '<div>';
	$output .= $content;
	//$output .= '</div>';
	//$output .= '<a class="carousel-control left" href="#'.$id.'" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>';
	//$output .= '<a class="carousel-control right" href="#'.$id.'" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>';
	$output .= '</div>';
	
	return $output;
}

/**
 * Theme Carousel Item
 */
function theme_carousel_item($vars) {
	$class = $vars['class'];
	$content = $vars['content'];
	
	$output = '<div class="'.$class.'">';
	$output .= $content;
	$output .= '</div>';

	return $output;
}
