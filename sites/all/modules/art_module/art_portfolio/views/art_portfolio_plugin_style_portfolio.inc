<?php

/**
 * @file
 * Defines the style plugin for the Art Portfolio
 */

class art_portfolio_plugin_style_portfolio extends views_plugin_style_list {
	function option_definition() {
		$options = parent::option_definition();
		$options['block_portfolio'] = array('default' => 'block-portfolio-7');
        $options['columns'] = array('default' => 3);
		$options['use_filter'] = array('default' => 1);
		$options['use_pager'] = array('default' => 1);
		$options['filter_vocabulary'] = array('default' => 0);
		return $options;
	}
	
	function options_form(&$form,&$form_state) {
		parent::options_form($form,$form_state);
		
		$form['block_portfolio'] = array(
			'#type' => 'textfield',
			'#title' => t('Block Portfolio'),
			'#default_value' => $this->options['block_portfolio']
		);
		
		$form['columns'] = array(
			'#type' => 'select',
			'#title' => t('Number of Columns'),
			'#options' => array(
				1 => 1,
				2 => 2,
				3 => 3,
				4 => 4,
				5 => 5,
				6 => 6
			),
			'#default_value' => $this->options['columns']
		);
		
		$form['use_filter'] = array(
			'#type' => 'checkbox',
			'#title' => t('Use Filter'),
			'#description' => t('Determines whether the filter is used on the portfolio.'),
			'#default_value' => $this->options['use_filter']
		);
		
		$opts = array('- Select -');
		$tmp = array();
		foreach(taxonomy_vocabulary_get_names() as $vocab) {
			$tmp[$vocab->vid] = $vocab->name;
		}
		$opts += $tmp;	
		$form['filter_vocabulary'] = array(
			'#type' => 'select',
			'#title' => t('Filter Vocabulary'),
			'#options' => $opts,
			'#description' => t('Which taxonomy vocabulary do you want to use for the filter'),
			'#default_value' => $this->options['filter_vocabulary'],
		);
		
		$form['use_pager'] = array(
			'#type' => 'checkbox',
			'#title' => t('Use Pager'),
			'#description' => t('Determines whether the pager is used on the portfolio.'),
			'#default_value' => $this->options['use_pager']
		);
	}
	
}