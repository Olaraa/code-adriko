<?php

/**
 * check for form variables in $vars['tentensites_agechecker_verification']
 * check for full form in $vars['tentensites_agechecker_verification_full_form']
 */

 //echo '<pre>';print_r(get_defined_vars());echo '</pre>';
 //dsm(get_defined_vars());

?>
 <div id="tentensites-agechecker-form">
 
	<div class="intro">
		<?php print $tentensites_agechecker_intro ?>
	</div>
	
	<div class="clearfix date-wrapper">
		<?php print $tentensites_agechecker_verification['tentensites_agechecker_verification_year'] ?>
		<?php print $tentensites_agechecker_verification['tentensites_agechecker_verification_month'] ?>
		<?php print $tentensites_agechecker_verification['tentensites_agechecker_verification_date'] ?>
	</div>
	
	<div id="remember-checkbox">
		<?php print $tentensites_agechecker_verification['tentensites_agechecker_verification_remember'] ?>
	</div>
	
	<div class="submit-btn">
		<?php print $tentensites_agechecker_verification['submit'] ?>
	</div>
 
 </div>