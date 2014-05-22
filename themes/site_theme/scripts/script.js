
WebFontConfig = {
  google: { families: [ 'Lobster:400:latin', 'Oswald:400,700:latin', 'Open+Sans:400italic,400,700:latin' ] }
};
(function() {
  var wf = document.createElement('script');
  wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
    '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
  wf.type = 'text/javascript';
  wf.async = 'true';
  var s = document.getElementsByTagName('script')[0];
  s.parentNode.insertBefore(wf, s);
})();



jQuery(document).ready(function() {
	jQuery('body').addClass('js-enabled');
	jQuery('body').removeClass('no-js');
	makeFormLabelsInfield(jQuery('div#footer div#node-1 form'));
	initiate_footer();
	if (jQuery('body').hasClass('page-node-17')) {
		initiate_buy_locations_map();
	}
	if (jQuery('body').hasClass('page-age-verification')) {
		initiate_age_verification_form();
	}
	if (jQuery('body').hasClass('front')) {
		is_front_page = true;
	}
});



jQuery(window).load(function() {
	jQuery('body').removeClass('page-loading');
	jQuery('body').addClass('page-loaded');
	if (is_front_page) {
		initiate_home_page_banner();
	}
	
	//adjust footer
	/*
	var $footer_wrapper = jQuery('div#footer-wrapper');
	var current_footer_posn = $footer_wrapper.offset().top;
	var window_height = jQuery(window).height();
	var new_displacement = 
	original_footer_posn = jQuery('div#footer-wrapper').offset().top;
	jQuery(window).resize();
	*/
});


var original_footer_posn;
var is_front_page = false;
function initiate_footer() {
	var $window = jQuery(window);
	var $footer_wrapper = jQuery('div#footer-wrapper');
	var $footer = jQuery('#footer', $footer_wrapper);
	var $show_footer_btn = jQuery('#show-contacts a', $footer_wrapper);
	var $body = jQuery('body');
	original_footer_posn = $footer_wrapper.offset().top;
	$footer.hide();
	
	//resize
	$window.resize( function() {
		var window_height = $window.height();
		var body_height = $body.height();
		var newMarginTop = window_height - original_footer_posn - 20; //displacement of 20, perhaps fonts
		if (is_front_page) newMarginTop += 70;
		if (newMarginTop>0) {
			$footer_wrapper.css('margin-top', newMarginTop+'px');
		}
		
		//home page
		if ($body.hasClass('front')) {
			var $supersized_ul = jQuery('ul#supersized');
			$supersized_ul.css('height', ($footer_wrapper.offset().top-55)+'px');
		}
	}).resize();
	
	//click
	$show_footer_btn.click( function() {
		$footer.slideDown(500);
		jQuery('html, body').animate({
			scrollTop: $footer_wrapper.offset().top+"px"
		}, {
			duration: 500,
			easing: 'easeOutQuad',
			complete: function() {
				if (!map)
					initiate_map();
			}
		});
		return false;
	});
}

var map = false;
function initiate_map() {
	var latLngPosn = new google.maps.LatLng(0.317615, 32.539830);
	map = new google.maps.Map(document.getElementById("adriko-map"), {
		center: latLngPosn,
		zoom: 14,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	});
	var mapMarker = new google.maps.MarkerImage(
		'/sites/adriko/themes/site_theme/images/mapmarker.png',
		new google.maps.Size(70, 85),
		new google.maps.Point(0, 0),
		new google.maps.Point(35, 85)
	);
	var marker = new google.maps.Marker({
		position: latLngPosn,
		map: map,
		icon: mapMarker
	});
}

function initiate_age_verification_form() {
	var $form = jQuery('form#tenten-age-verification');
	var $date_wrapper = jQuery('div.date-wrapper', $form);
	
	//checkbox
	var $checkbox_wrapper = jQuery('div.form-item-tentensites-agechecker-verification-remember', $form);
	var $cool_checkbox = jQuery('<div class="cooler-checkbox"><div></div></div>');
	var $label = jQuery('label', $checkbox_wrapper);
	var $checkbox = jQuery('input.form-checkbox', $checkbox_wrapper);
	$checkbox_wrapper.addClass('cool-checkbox');
	$cool_checkbox.prependTo($checkbox_wrapper);
	$label.click( function() {
		return false;
	});
	
	//check current status of checkbox
	if ($checkbox.is(":checked")) {
		jQuery('div', $cool_checkbox).fadeIn(300);
	}
	
	//handle click event
	$cool_checkbox.click( function() {
		if ($checkbox.is(":checked")) {
			$checkbox.attr('checked', false);
			jQuery('div', $cool_checkbox).fadeOut(300);
		} else {
			$checkbox.attr('checked', true);
			jQuery('div', $cool_checkbox).fadeIn(300);
		}
		//alert($checkbox.attr('checked')+" and "+$checkbox.val());
	});
	
	//date wrapper
	jQuery('div.form-item', $date_wrapper).each( function() {
		var $$ = jQuery(this);
		var $textfield = jQuery('input.form-text', $$);
		var placeholderValue = '';
		if ($$.hasClass('form-item-tentensites-agechecker-verification-year')) placeholderValue = 'YYYY';
		else if($$.hasClass('form-item-tentensites-agechecker-verification-month')) placeholderValue = 'MM';
		else if($$.hasClass('form-item-tentensites-agechecker-verification-date')) placeholderValue = 'DD';
		$$.append('<span class="placeholder">'+placeholderValue+'</span>');
		
		//handle focus and blur
		jQuery('span.placeholder', $$).click( function() {
			jQuery('input.form-text', jQuery(this).closest('div.form-item')).focus();
		});
		$textfield.focus( function() {
			var $placeholder = jQuery('span.placeholder', jQuery(this).closest('div.form-item'));
			$placeholder.fadeOut(500);
		});
		$textfield.blur( function() {
			var $placeholder = jQuery('span.placeholder', jQuery(this).closest('div.form-item'));
			if (jQuery(this).val()=='') {
				$placeholder.fadeIn(500);
			}
		});
	});
}

function makeFormLabelsInfield($form) {
	jQuery("label", $form).inFieldLabels();
	jQuery("input", $form).attr("autocomplete","off");
	$form.addClass('infield-labels');
}

var bannerCaptionHolder;
var bannerCaptions = [];
var bannersNo = 0;
function setup_homepage_banner() {
	//initialise vars
	bannerCaptionHolder = jQuery('div#banner-caption-holder');
	jQuery(".banner-caption .desc-holder").each( function() {
		var $$ = jQuery(this);
		bannersNo++;
		bannerCaptions[$$.attr('id')] = jQuery(this);
	});
	
	//initialise theme
	theme = {
		beforeAnimation : function(direction){
			var $showingDiv = jQuery('div#showing', bannerCaptionHolder);
			var $utilityDiv = jQuery('div#utility', bannerCaptionHolder);
			var comingBannerNo = vars.current_slide;
			var comingCaptionHTML = bannerCaptions['desc-'+comingBannerNo].html();
			var goingCaptionHTML = $showingDiv.html();
			$utilityDiv.html(goingCaptionHTML);
			$utilityDiv.css('opacity', '1.0');
			$showingDiv.css('opacity', '0');
			$showingDiv.html(comingCaptionHTML);
			$utilityDiv.animate({
				opacity: 0
			}, {
				duration: 500,
				easing: 'easeOutQuad'
			});
			$showingDiv.animate({
				opacity: 1
			}, {
				duration: 500,
				easing: 'easeOutQuad'
			});
		}
	};
	
	//supersized theme variables
	jQuery.supersized.themeVars = {
		slide_list			:	'#home-banner-links'		// Slide jump list							
	};		

}

function initiate_home_page_banner() {
	setup_homepage_banner();
	var slideImages = [];
	jQuery('div#block-views-banners-block div#slider div').each( function() {
		var $div = jQuery(this);
		var imgHREF = jQuery('a', $div).attr('href');
		var imgURL = jQuery('img', $div).attr('src');
		var imgTitle = jQuery('img', $div).attr('title');
		slideImages.push({image:imgURL, title:imgTitle, url:imgHREF});
	});
	jQuery.supersized ({
		slide_interval		:	6000,
		transition				:	1,
		transition_speed	:	900,
		slide_links				:	'blank',
		horizontal_center	:	true,
		vertical_center		:	false,
		slides						:	slideImages,
		pause_hover				:	1,
		autoplay					:	1
	});
		
	//resizing
	jQuery(window).resize();
	
}
