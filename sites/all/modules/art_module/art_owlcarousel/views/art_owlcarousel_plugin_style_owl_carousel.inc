<?php

class art_owlcarousel_plugin_style_owl_carousel extends views_plugin_style_list {
	
	function option_definition() {
		$options = parent::option_definition();
		$options['items'] = array('default' => 5);
		$options['itemsDesktop'] = array('default' => '[1199,4]');
		$options['itemsDesktopSmall'] = array('default' => '[979,3]');
		$options['itemsTablet'] = array('default' => '[768,2]');
		$options['itemsMobile'] = array('default' => '[479,1]');
		$options['transitionStyle'] = array('default' => '');		
		$options['autoHeight'] = array('default' => 0);
		$options['singleItem'] = array('default' => 0);		
		$options['pagination'] = array('default' => 1);
		$options['navigation'] = array('default' => 0);
		
		return $options;
	}
	
	function options_form(&$form,&$form_state) {
		parent::options_form($form,$form_state);
		
		$form['transitionStyle'] = array(
			'#prefix' => '<h4>Owl Carousel Settings</h4>',
			'#type' => 'select',
			'#title' => t('Transition Style'),
			'#options' => array(
				'' => t('Select'),
				'fadeUp' => t('fadeUp'),
			),
			'#default_value' => $this->options['transitionStyle'],
		);
		
		$form['items'] = array(
			'#type' => 'textfield',
			'#title' => t('Items'),
			'#default_value' => $this->options['items'],
		);
		$form['itemsDesktop'] = array(
			'#type' => 'textfield',
			'#title' => t('Items Desktop'),
			'#default_value' => $this->options['itemsDesktop'],
		);
		$form['itemsDesktopSmall'] = array(
			'#type' => 'textfield',
			'#title' => t('Items Desktop Small'),
			'#default_value' => $this->options['itemsDesktopSmall'],
		);
		$form['itemsTablet'] = array(
			'#type' => 'textfield',
			'#title' => t('Items Tablet'),
			'#default_value' => $this->options['itemsTablet'],
		);
		$form['itemsMobile'] = array(
			'#type' => 'textfield',
			'#title' => t('Items Mobile'),
			'#default_value' => $this->options['itemsMobile'],
		);
		
		$form['autoHeight'] = array(
			'#type' => 'select',
			'#title' => t('Auto Height'),
			'#options' => array(
				0 => 'False',
				1 => 'True',
			),
			'#default_value' => $this->options['autoHeight'],
		);
		$form['singleItem'] = array(
			'#type' => 'select',
			'#title' => t('Single Item'),
			'#options' => array(
				0 => 'False',
				1 => 'True',
			),
			'#default_value' => $this->options['singleItem'],
		);
		$form['pagination'] = array(
			'#type' => 'select',
			'#title' => t('Pagination'),
			'#options' => array(
				0 => 'False',
				1 => 'True',
			),
			'#default_value' => $this->options['pagination'],
		);
		$form['navigation'] = array(
			'#type' => 'select',
			'#title' => t('Navigation'),
			'#options' => array(
				0 => 'False',
				1 => 'True',
			),
			'#default_value' => $this->options['navigation'],
		);
		
	}
}