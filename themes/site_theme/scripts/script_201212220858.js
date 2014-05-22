
WebFontConfig = {
  google: { families: [ 'Lobster::latin', 'Oswald::latin', 'Open+Sans:300italic,400italic,400,600,700,300:latin' ] }
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
});



jQuery(window).load(function() {
	if (jQuery('body').hasClass('front')) {
		jQuery('body').addClass('page-loaded');
		initiate_home_page_banner();
	}
});

function initiate_home_page_banner() {
	var $bannerBlock = jQuery('#block-views-banners-block');
	var $bannerSlider = jQuery('#slider', $bannerBlock);
	var $footer = jQuery('div#footer');
	var $header = jQuery('div#header');
	var $bannerContentHolder = jQuery('div.banner-caption-0', $bannerBlock);
	var windowHeight;
	var bannerContent = {
		'height' : 483,
		'offset' : 255,
		'minimumPaddingTop' : 65,
		'maximumPaddingTop' : 100
	};
	var bannerPic = {
		'minHeight' : bannerContent.height+(bannerContent.minimumPaddingTop*2)+$header.height()
	};
	var noBanners = jQuery('a', $bannerSlider).length;
	var useBannerHeight;
	var betweenFooterAndHeader;
	
	//set footer to smaller height
	//$footer.css('height', '45px');
	//jQuery('.footer-wrapper', $footer).height(45);
	
	//store banner content
	var bannerContentHTML = {};
	jQuery('div.banner-caption', $bannerBlock).each( function (index, elem) {
		var $$ = jQuery(this);
		bannerContentHTML[$$.attr('id')] = jQuery('div#caption-content', $$).html();
	});
	
	$bannerSlider.carouFredSel({
		width: jQuery(window).width(),
		height: jQuery(window).height(),
		align: false,
		fit_portrait: false,
		horizontal_center: true,
		vertical_center: true,
		items: {
			visible: 1,
			minimum: 1,
			width: "variable",
			height: "variable"
		},
		scroll: {
			items: 1,
			fx: "crossfade",
			duration: 2100,
			onAfter: function( oldItems, newItems, newSizes ) {
				var newID = jQuery('a', newItems[0]).attr('id');
				var newHTML = bannerContentHTML[newID];
				//var newHTML = jQuery('div#'+newID+' div#caption-content', $bannerBlock).html();
				jQuery('div#caption-content', $bannerContentHolder).html(newHTML);
			}
		},
		auto: 7500,
		//auto: false,
		prev: {
			button: "div#carousel-btns #prev-btn",
			key: "left"
		},
		next: {
			button: "div#carousel-btns #next-btn",
			key: "right"
		},
		pagination: "div#carousel-pagination"
	});
	
	jQuery(window).resize( function() {
		//var headerHeight = $header.outerHeight();
		//var footerHeight = $footer.outerHeight();
		windowHeight = useBannerHeight = jQuery(window).height();
		//useBannerHeight = ((windowHeight-footerHeight)>bannerPic.minHeight) ? windowHeight-footerHeight : bannerPic.minHeight;
		//betweenFooterAndHeader = useBannerHeight-headerHeight;
		$bannerBlock.height(useBannerHeight);
		$bannerSlider.height(useBannerHeight);
		jQuery('.view-content', $bannerBlock).height(useBannerHeight);
		
		//$bannerContentHolder.css('margin-top', '-'+useBannerHeight+'px');
		/*
		if (betweenFooterAndHeader>=bannerContent.height+(bannerContent.maximumPaddingTop*2)) {
			$bannerContentHolder.css('padding-top', headerHeight+bannerContent.maximumPaddingTop+'px');
		} else if (betweenFooterAndHeader<=bannerContent.height+(bannerContent.minimumPaddingTop*2)) {
			$bannerContentHolder.css('padding-top', headerHeight+bannerContent.minimumPaddingTop+'px');
		} else {
			$bannerContentHolder.css('padding-top', headerHeight+((betweenFooterAndHeader-bannerContent.height)/2)+'px');
		}
		*/
		
		//adjust carousel
		/*
		var newCarouselCss = {
			width: jQuery(window).width(),
			height: useBannerHeight
		};
		$bannerSlider.css( 'width', newCarouselCss.width*noBanners );
		$bannerSlider.parent().css( newCarouselCss );
		jQuery('a', $bannerSlider).css( newCarouselCss );
		*/
			
	}).resize();
	
	
	//resize window
	//banner html dom modifications
	//run transitions
}
