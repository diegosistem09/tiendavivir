<?php

/**
 * Definition of Accordion Shortcode
 */

/**
 * Implements hook_shortcode_info
 */

global $accordion_item;
function _accordion_shortcode_info(&$shortcodes) {
	$shortcodes['accordion'] = array(
		'title' => t('Accordion'),
		'description' => t('Create an Accordion'),
		'process callback' => 'art_shortcode_accordion',
		'tips callback' => 'art_shortcode_accordion_tip',
	);
	
	$shortcodes['accordion_item'] = array(
		'title' => t('Accordion Item'),
		'description' => t('Create an Accordion Item'),
		'process callback' => 'art_shortcode_accordion_item',
		'tips callback' => 'art_shortcode_accordion_item_tip',
	);
	
	return $shortcodes;
}

/**
 * Accordion Content
 */
function art_shortcode_accordion($attrs, $text) {
	$attrs = shortcode_attrs(array(
			'id' => 'sup-accordion',
			'class' => '',
		),
		$attrs
	);
	
	$class = shortcode_add_class($attrs['class'],'clearfix');
	return theme('accordion',array('id' => $attrs['id'],'class' => $class,'content' => $text));
}

/**
 * Accordion Item Content
 */
function art_shortcode_accordion_item($attrs,$text) {
	$attrs = shortcode_attrs(array(
			'title' => '',
			'class' => '',
			'icon' => '',
		),
		$attrs
	);
	
	$class = shortcode_add_class($attrs['class'],'accordion-toggle');
	return theme('accordion_item',array('title' => $attrs['title'],'class' => $class,'content' => $text,'icon'=>$attrs['icon']));
}

/**
 * Accordion theme
 */
function _accordion_theme(&$themes) {
	$themes['accordion'] = array(
		'variables' => array(
			'id' => '',
			'class' => '',
			'content' => ''
		)
	);
	
	$themes['accordion_item'] = array(
		'variables' => array(
			'title' => '',
			'class' => '',
			'content' => '',
			'icon' =>'',
		)
	);
	
	return $themes;
}

/**
 * Theme accordion
 */
function theme_accordion($vars) {
	global $accordion_item;
	$accordion_item = 0;
	$id = drupal_html_id('spaccordion');//$vars['id'];
	$class = $vars['class'];
	$content = $vars['content'];
	return '<div class="accordion">'.str_replace('@accordion_id',$id,$content).'</div>';
}

/**
 * Theme Accordion Item
 */
function theme_accordion_item($vars) {
	global $accordion_item;
	$id = drupal_html_id('spcollapse');
	$title = $vars['title'];
	$class = $vars['class'];
	$content = $vars['content'];
	$icon = $vars['icon'];
	$icon_html = "";
	if($icon){
		$icon_html = "<i class=\"fa fa-{$icon}\"></i> ";
	}
	
	$output = '';
        $output .= '<div class="accordion_item r_corners shadow wrapper m_bottom_5">';
	//$output .= '<dt class="accordion_link relative color_dark tr_all">'.$icon_html.$title.'<span class="icon_wrap_size_1 circle d_block hide"><i class="icon-minus"></i></span><span class="icon_wrap_size_1 circle d_block show"><i class="icon-plus"></i></span></dt>';
	if($accordion_item == 0){
            $output .= '<h3 class="color_light active a_title relative tr_all_hover">'.$title.'<span class="minus_icon tr_all_hover">-</span><span class="plus_icon tr_all_hover">+</span></h3>';
            $accordion_item ++;
        } else {
            $output .= '<h3 class="bg_light_color_1 color_dark a_title relative tr_all_hover">'.$title.'<span class="minus_icon tr_all_hover">-</span><span class="plus_icon tr_all_hover">+</span></h3>';
        }
	$output .= '<div class="bg_light_color_3 a_content">'.$content.'</div>';
	$output .= '</div>';
	
	return $output;
}