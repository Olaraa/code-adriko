<?php

/**
 * Return a themed breadcrumb trail.
 *
 * @param $breadcrumb
 *   An array containing the breadcrumb links.
 * @return a string containing the breadcrumb output.
 */
function site_theme_breadcrumb($vars) {
  $breadcrumb = $vars['breadcrumb'];

  if (!empty($breadcrumb)) {
    // Provide a navigational heading to give context for breadcrumb links to
    // screen-reader users. Make the heading invisible with .element-invisible.
    $output = '<h2 class="element-invisible">You are here:</h2><div class="breadcrumb">'.implode('<span class="sep">›››</span>', $breadcrumb) . '</div>';
    return $output;
  }
}


/**
 * Add body classes if certain regions have content.
 */
function site_theme_preprocess_html(&$vars) {
	//print dsm($vars);
	//drupal_add_css('http://fonts.googleapis.com/css?family=Armata|Wellfleet', array( 'type'=>'external', 'group'=>CSS_DEFAULT, 'preprocess'=>FALSE ));
	drupal_add_js('http://maps.google.com/maps/api/js?key=AIzaSyDb8EugeTlz2xRgHt4aAu4tSW6mzDvpsZc&sensor=true', array( 'group' => JS_DEFAULT, 'preprocess' => FALSE ));
	if ($vars['is_front']) {
	  drupal_add_js (path_to_theme().'/scripts/supersized.3.2.7.min.js', array( 'group' => JS_DEFAULT, 'preprocess' => TRUE ));
    $vars['classes_array'][] = 'no-h1';
	}
	if (!empty($vars['page']['featured'])) {
    $vars['classes_array'][] = 'featured';
  }
	
	//add more path specific classes
	if (!$vars['is_front']) {
		$path = drupal_get_path_alias($_GET['q']);
		$path_parts = explode('/', $path);
		$vars['classes_array'][] = drupal_html_class('section-'.$path_parts[0]);
		if (isset($path_parts[1])) $vars['classes_array'][] = drupal_html_class('section-2-'.$path_parts[1]);
		if (arg(0)=='node' && is_numeric($nid=arg(1))) {
			$no_h1_nids = array('21'=>1,'22'=>1,'23'=>1,'24'=>1,'25'=>1,);
			//$no_breadcrumb_nids = array('10'=>1);
			$no_slideshow_block_nids = array();
			if (isset($no_h1_nids[$nid]))
				$vars['classes_array'][] = 'no-h1';
			if (isset($no_breadcrumb_nids[$nid]))
				$vars['classes_array'][] = 'no-breadcrumb';
			if (!isset($no_slideshow_block_nids[$nid]))
				$vars['classes_array'][] = 'slideshow-block';
			
			//add infobox.js to node 17
			if ($nid==17) {
				drupal_add_js (path_to_theme().'/scripts/infobox.js', array( 'group' => JS_DEFAULT, 'preprocess' => TRUE ));
				drupal_add_js (path_to_theme().'/scripts/buy_location_points.js', array( 'group' => JS_DEFAULT, 'preprocess' => TRUE ));
			}
		}
		
		//check paths
		$no_h1_paths = array('products'=>1, 'age-verification'=>1, );
		if (isset($no_h1_paths[$path]))
			$vars['classes_array'][] = 'no-h1';
		
		//page callbacks
		$vars['menu_item'] = menu_get_item();
		switch ($vars['menu_item']['page_callback']) {
			case 'views_page':
				// Is this a Views page?
				$vars['classes_array'][] = 'page-views';
				$class_str = '';
				$path_parts_no = count($path_parts);
				for ($i=0; $i<$path_parts_no; $i++) {
					$class_str .= $path_parts[$i];
					if ($i<$path_parts_no-1) $class_str .= '-';
				}
				$vars['classes_array'][] = 'page-views-'.$class_str;
				break;
			case 'page_manager_page_execute':
			case 'page_manager_node_view':
			case 'page_manager_contact_site':
				// Is this a Panels page?
				$vars['classes_array'][] = 'page-panels';
				break;
		}
	}
	
	/*
  // Add conditional stylesheets for IE
  drupal_add_css(path_to_theme() . '/css/ie.css', array('group' => CSS_THEME, 'browsers' => array('IE' => 'lte IE 7', '!IE' => FALSE), 'preprocess' => FALSE));
  drupal_add_css(path_to_theme() . '/css/ie6.css', array('group' => CSS_THEME, 'browsers' => array('IE' => 'IE 6', '!IE' => FALSE), 'preprocess' => FALSE));
	*/
}


/**
 * Override or insert vars into the page template.
 */
function site_theme_preprocess_page(&$vars) {
	//for styling menu
	$vars['main_menu_reversed'] = array_reverse($vars['main_menu']);
	if (isset($vars['main_menu'])) {
    $vars['primary_nav'] = theme('links__system_main_menu', array(
      'links' => $vars['main_menu_reversed'],
      'attributes' => array(
        'class' => array('links', 'inline', 'main-menu'),
      ),
      'heading' => array(
        'text' => t('Main menu'),
        'level' => 'h2',
        'class' => array('element-invisible'),
      )
    ));
    $vars['primary_nav_footer'] = theme('links__system_main_menu', array(
      'links' => $vars['main_menu'],
      'attributes' => array(
        'class' => array('links', 'inline', 'main-menu'),
      ),
      'heading' => array(
        'text' => t('Main menu'),
        'level' => 'h2',
        'class' => array('element-invisible'),
      )
    ));
    $vars['home_link_logo'] = l('', '<front>', array(
    	'attributes' => array (
    		'title'	=>	'Back to home page',
    	),
    	'html'	=> false,
    ));
    $vars['social_media_links'] = '<div class="social-media-links"><ul><li class="twitter first"><a href="http://www.twitter.com" title="Visit us on Twitter"></a></li><li class="fb last"><a href="http://www.facebook.com" title="Visit us on Facebook"></a></li></ul></div>';
    
    //format titles
    $shadow_h1_nids = array('nid-8'=>1, 'nid-16'=>1, 'nid-17'=>1, );
    $vars['shadowed_h1'] = false;
    if (isset($vars['node']) && isset($shadow_h1_nids['nid-'.$vars['node']->nid])) {
    	$vars['shadowed_h1'] = true;
    }
			
		//shadowed paths
		$shadowed_h1_paths = array('adrikos-mix'=>1, );
		if (isset($shadowed_h1_paths[$_GET['q']]))
    	$vars['shadowed_h1'] = true;
  }
  else {
    $vars['primary_nav'] = FALSE;
  }
}


/**
 * overriding search form
 */
function site_theme_form_alter(&$form, &$form_state, $form_id) {
  switch ($form_id) {
		case 'search_block_form':
			$value = 'Search ...';
			$form['search_block_form']['#default_value'] = t($value);
			$form['search_block_form']['#title'] = $value;
			$form['search_block_form']['#value'] = $value;
			$form['search_block_form']['#attributes']['onblur'] = "if (this.value == '') {this.value = '".$value."';}";
			$form['search_block_form']['#attributes']['onfocus'] = "if (this.value == '".$value."') {this.value = '';}";
			break;
  }
}


/**
 * Implements hook_preprocess_maintenance_page().
 */
function site_theme_preprocess_maintenance_page(&$vars) {
  //drupal_add_css(drupal_get_path('theme', 'site_theme') . '/css/maintenance-page.css');
}

/**
 * Override or insert vars into the maintenance page template.
 */
function site_theme_process_maintenance_page(&$vars) {
  // Always print the site name and slogan, but if they are toggled off, we'll
  // just hide them visually.
}

/**
 * Override or insert vars into the node template.
 */
function site_theme_preprocess_node(&$vars) {
  if ($vars['view_mode'] == 'full' && node_is_page($vars['node'])) {
    $vars['classes_array'][] = 'node-full';
    $vars['classes_array'][] = 'node-nid-'.$vars['nid'];
  }
	if ($vars['type']=='video') {
	  drupal_add_js (path_to_theme().'/jwplayer/jwplayer.js', array( 'group' => JS_DEFAULT, 'preprocess' => TRUE ));
	}
}

/**
 * Override or insert vars into the block template.
 */
function site_theme_preprocess_block(&$vars) {
  // In the header region visually hide block titles.
	if ($vars['block']->delta=='page_slideshow-block') {
	  drupal_add_js (path_to_theme().'/scripts/jquery.nivo.slider.pack.js', array( 'group' => JS_DEFAULT, 'preprocess' => TRUE ));
	  drupal_add_css (path_to_theme().'/css/nivo-slider.css', array( 'group' => JS_DEFAULT, 'preprocess' => TRUE ));
	}
  if ($vars['block']->region == 'header') {
    $vars['title_attributes_array']['class'][] = 'element-invisible';
  }
  
  //add first and last classes for region
  $block_count = count(site_theme_block_list($vars['block']->region));
  if ($vars['block_id'] == 1 || $block_count == 1) {
    $vars['classes_array'][] = 'block-first';
  }
  if ($vars['block_id'] == $block_count) {
    $vars['classes_array'][] = 'block-last';
  }
}

/**
 * Implements theme_menu_tree().
 */
function site_theme_menu_tree($vars) {
  return '<ul class="menu clearfix">' . $vars['tree'] . '</ul>';
}

/**
 * get list of blocks in region
 */
function site_theme_block_list($region) {
  // Code referenced from Fusion Core theme.
  $drupal_list = block_list($region);
  if (module_exists('context') && $context = context_get_plugin('reaction', 'block')) {
    $context_list = $context->block_list($region);
    $drupal_list = array_merge($context_list, $drupal_list);
  }
  return $drupal_list;
}
