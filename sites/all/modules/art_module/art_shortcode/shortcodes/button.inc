<?php

/**
 * Definition of Button Shortcode
 */

/**
 * Implements hook_shortcode_info
 */
function _button_shortcode_info(&$shortcodes) {
	$shortcodes['button'] = array(
		'title' => t('button'),
		'description' => t('Create Button'),
		'process callback' => 'art_shortcode_button',
		'tips callback' => 'art_shortcode_button_tip',
	);
	return $shortcodes;
}

/**
 * Button Content
 */
function art_shortcode_button($attrs, $text) {
	$attrs = shortcode_attrs(array(
			'type' => 'button_type_14',		
                        'background' => '',
                        'hover' => '',
                        'color' => 'color_light',
                        'size' => '',
                        'icon' => '',
		),
		$attrs
	);
        $icon='';
            switch ($attrs['icon']) {
                case 'default':
                    $icon = '<i class="fa fa-pencil m_right_6"></i>';
                    break;
                case 'primary':
                    $icon = '<i class="fa fa-shopping-cart m_right_6"></i>';
                    break;
                case 'info':
                    $icon = '<i class="fa fa-info-circle m_right_6"></i>';
                    break;
                case 'success':
                    $icon = '<i class="fa fa-check m_right_6"></i>';
                    break;
                case 'warning':
                    $icon = '<i class="fa fa-warning m_right_6"></i>';
                    break;
                case 'danger':
                    $icon = '<i class="fa fa-flash m_right_6"></i>';
                    break;
                case 'inverse':
                    $icon = '<i class="fa fa-refresh m_right_6"></i>';
                    break;
                default:
                    break;
            }
	
        
	//return theme('button',array('type' => $attrs['type'],'size'=>$attrs['size'],'content' => $text));
	return '<button class="tr_delay_hover r_corners m_bottom_10 '.$attrs['type'].' '.$attrs['background'].' '.$attrs['hover'].' '.$attrs['color'].' '.$attrs['size'].'">'.$icon.$text.'</button>';
}