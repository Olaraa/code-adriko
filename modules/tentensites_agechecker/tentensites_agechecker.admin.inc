<?php

/**
 * verify age form
 */
function tenten_age_verification() {
	$form['tentensites_agechecker_verification_year'] = array (
		'#type'					=>	'textfield',
		'#title'				=>	t('Year'),
		'#title_display'=>	'after',
		'#description'	=>	'',
		'#required'			=>	TRUE,
		'#maxlength'		=>	4,
		'#size'					=>	4,
	);
	$form['tentensites_agechecker_verification_month'] = array (
		'#type'					=>	'textfield',
		'#title'				=>	t('Month'),
		'#title_display'=>	'after',
		'#description'	=>	'',
		'#required'			=>	TRUE,
		'#maxlength'		=>	2,
		'#size'					=>	2,
	);
	$form['tentensites_agechecker_verification_date'] = array (
		'#type'					=>	'textfield',
		'#title'				=>	t('Date'),
		'#title_display'=>	'after',
		'#description'	=>	'',
		'#required'			=>	TRUE,
		'#maxlength'		=>	2,
		'#size'					=>	2,
	);
	$form['tentensites_agechecker_verification_remember'] = array (
		'#type'					=>	'checkbox',
		'#title'				=>	t('Check this box to remember your age on this computer.'),
		'#description'	=>	t('Please do not check this box if this is a shared computer.'),

	);
	$form['submit'] = array (
		'#type'	=> 'submit',
		'#value'=> t('Submit to continue to page'),
	);
	$form['#validate'][] = 'tenten_age_verification_validate';
	$form['#submit'][] = 'tenten_age_verification_submit';
	
	//dsm($form);
	
	return $form;
}

/**
 * process age verification form
 */
function tenten_age_verification_validate(&$form, $form_state) {
	echo 'form being validated<br>';
	$year = intval($form_state['values']['tentensites_agechecker_verification_year']);
	$month = intval($form_state['values']['tentensites_agechecker_verification_month']);
	$date = intval($form_state['values']['tentensites_agechecker_verification_date']);
	
	//test year
	$valid_year = false;
	if ($year<=2013 && $year>=1900) $valid_year = true;
	
	//test month
	$valid_month = false;
	if ($month<=12 && $month>=1) $valid_month = true;
	
	//test date
	$valid_date = false;
	if ($date<=31 && $date>=1) $valid_date = true;
	
	if (!$valid_year || !$valid_month || !$valid_date) {
		if (!$valid_year)
			form_set_error('tentensites_agechecker_verification_year', t('Please enter a valid year.'));
		if (!$valid_month)
			form_set_error('tentensites_agechecker_verification_month', t('Please enter a valid month.'));
		if (!$valid_date)
			form_set_error('tentensites_agechecker_verification_date', t('Please enter a valid date.'));
	} else {
		//test date if valid
		if (!checkdate($month, $date, $year)) {
			form_set_error('tentensites_agechecker_verification_date', t('Please enter a valid date. This date does not exist!'));
		} else {
			$age = (date("md", date("U", mktime(0, 0, 0, $month, $date, $year))) > date("md") ? ((date("Y")-$year)-1):(date("Y")-$year));
			if ($age<18) {
				form_set_error('tentensites_agechecker_verification_year', t('Sorry. The requested page can only be viewed by adults who are 18 years old and over. Visit other sections of the website using the links above.'));
			}
		}
	}
}


/**
 * process age verification form
 */
function tenten_age_verification_submit($form, &$form_state) {
	$year = $form_state['values']['tentensites_agechecker_verification_year'];
	$month = $form_state['values']['tentensites_agechecker_verification_month'];
	$date = $form_state['values']['tentensites_agechecker_verification_date'];
	$remember_cookie = $form_state['values']['tentensites_agechecker_verification_remember'];
	
	echo ('cookie setter is:'.$remember_cookie.'<br>');
	
	if ($remember_cookie>0) {
		setcookie("tentensites_agechecker_validated_adriko", "1", time()+3600*24*14);
	}
	
	$_SESSION['tentensites_agechecker_validated'] = true;
	$form_state['redirect'] = $_SESSION['tentensites_agechecker_redirect']['destination']; //if verified, go here
}


/**
 * check admin settings
 */
function tentensites_agechecker_admin_settings() {
	$types = node_type_get_types();
	$options = array();
	
	//existing intro
	$existing_intro = variable_get('tentensites_agechecker_intro');
	
	//existing paths
	$existing_paths = variable_get('tentensites_agechecker_paths');
	
	//existing types
	$existing_types = variable_get('tentensites_agechecker_node_types', array('page'));
	
	foreach ($types as $node_type) {
		$options[$node_type->type] = $node_type->name;
	}
	$form['tentensites_agechecker_node_types'] = array (
		'#type'						=>	'checkboxes',
		'#title'					=>	t('Verify age for these content types'),
		'#options'				=>	$options,
		'#default_value'	=>	$existing_types,
		'#description'		=>	t('These node types will require age verification before they can be accessed.'),
	);
	$form['tentensites_agechecker_paths'] = array (
		'#type'						=>	'textarea',
		'#title'					=>	t('Verify age for these paths'),
		'#default_value'	=>	t($existing_paths),
		'#description'		=>	t('These paths will require age verification before they can be accessed. Please disable rich text and enter a path per line. Internal paths only of course!'),
	);
	$form['tentensites_agechecker_intro'] = array (
		'#type'						=>	'textarea',
		'#title'					=>	t('Type in an intro to your form'),
		'#default_value'	=>	t($existing_intro),
		'#description'		=>	t('This intro appears above your form. Also see the theme file for more adjustments that you may require.'),
	);
	$form['#submit'][] = 'tentensites_agechecker_admin_settings_submit';
	return system_settings_form($form);
}


/**
 * process agechecker settings submission
 */
function tentensites_agechecker_admin_settings_submit($form, $form_state) {
	//node types
	$node_types = array();
	foreach($form_state['values']['tentensites_agechecker_node_types'] as $key=>$value) {
		if ($value!==0) {
			array_push($node_types, $value);
		}
	}
	variable_set('tentensites_agechecker_node_types', $node_types);
	
	//paths
	$paths_str = $form_state['values']['tentensites_agechecker_paths'];
	$paths = array();
	if (!ctype_space($paths_str)) {
		$paths = explode("\n", $form_state['values']['tentensites_agechecker_paths']);
	}
	variable_set('tentensites_agechecker_paths', $paths);
	
	//intro
	variable_set('tentensites_agechecker_intro', $form_state['values']['tentensites_agechecker_intro']);
	
	/*
	dsm("After submission");
	dsm(variable_get('tentensites_agechecker_node_types'));
	dsm(variable_get('tentensites_agechecker_paths'));
	*/
}