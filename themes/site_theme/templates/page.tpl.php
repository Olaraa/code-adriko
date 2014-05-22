
<?php
	$show_message_paths = array('age-verification'=>1, 'node/1'=>1,);
	$hide_inner_page_strip_paths = array('welcome'=>1, 'age-verification'=>1);
	$show_messages = isset($show_message_paths[$_GET['q']]);
	$show_inner_page_pic_strip = !isset($hide_inner_page_strip_paths[$_GET['q']]);
?>

<div class="full-page-wrapper" id="full-page-wrapper">

	<div class="nav-wrapper"><div class="nav centred-strip">
		<div class="nav-logo-wrapper clearfix">
			<div class="logo">
				<?php print $home_link_logo ?>
			</div>
		  <div class="menu-social-media">
		  	<?php print $social_media_links ?>
		    <?php print $primary_nav ?>
		  </div>
		</div>
	</div></div>
   
  <?php if ($page['home_page_banner']): ?>
	<ul id="supersized"></ul>
  <div class="home-page-banner" id="home-page-banner">
    <?php print render($page['home_page_banner']) ?>
		<div class="centred-strip">
			<div id="banner-caption-holder">
				<div id="showing"></div>
				<div id="utility"></div>
			</div>
			<ul class="clearfix" id="home-banner-links"></ul>
		</div>
  </div>
  <?php endif; ?>
  
  <?php if (!$is_front && $show_inner_page_pic_strip): ?>
  <div class="inner-page-pic-strip"><div></div></div>
  <?php endif; ?>

	<div class="page-wrapper"><div id="page-wrapper" class="page-inner-wrapper">
  	<div class="centred-strip">

      <div class="page-cols-holder"><div class="page-cols<?=($page['sidebar_second'])?' clearfix':''?>">
      
        <div class="page-col-1">
					
					<?php
						if ($page['before_drupal_messages'])
							print render($page['before_drupal_messages']);
					?>
					
          <?php if ($show_messages && $messages): ?>
          <div class="messages-wrapper">
            <?php print $messages; ?>
          </div>
          <?php endif; ?>
          
          <?php if (false && !$is_front && $breadcrumb): ?>
          <div class="breadcrumb-wrapper"><?php print $breadcrumb; ?></div>
          <?php endif; ?>
          
          <?php if (false && $tabs): ?>
            <div class="tabs">
              <?php print render($tabs); ?>
            </div>
          <?php endif; ?>
          
          <div id="main-content" class="main-content">
          	<div class="h1-content-holder">
          		<div class="h1-wrapper">
	              <h1>
	              	<?php print ($shadowed_h1) ? '<span class="text">'.$title.'</span><span class="shadow">'.$title.'</span>' : $title; ?>
	              </h1>
	            </div>
              <div class="content-strip-1">
                <?php print render($page['content']); ?>
              </div>
              <?php if ($page['content_2']): ?>
              <div class="content-strip-2">
                <?php print render($page['content_2']); ?>
              </div>
		          <?php endif; ?>
            </div>
          </div>
          
        </div>
        
        <?php if ($page['sidebar_second']): ?>
        <div class="page-col-2">
          <?php print render($page['sidebar_second']); ?>
        </div>
        <?php endif; ?>
        
      </div></div>
    
      <?php if ($page['after_cols']): ?>
      <div class="after-cols">
        <?php print render($page['after_cols']); ?>
      </div>
      <?php endif; ?>
      
    </div>
  </div></div>
  
  <div class="footer-wrapper" id="footer-wrapper">
  	<div id="show-contacts"><div class="wrapper"><a href="javascript:;">Contact Us</a></div></div>
    <div id="footer" class="footer"><div class="centred-strip">
    	<div class="intro">
    		<div class="intro-1">We would love to hear from you or even better, see you in person</div>
    		<div class="intro-2">Please look up our location using this map or contact us using the details below.</div>
    	</div>
    	<div class="map-holder" id="map-holder">
    		<div class="map-wrapper"><div id="adriko-map"></div></div>
    		<div class="map-link">
    			<a href="" target="_blank">View the Adriko Office location in a bigger map</a>
    		</div>
    	</div>
    	<div class="contact-details-form-wrapper">
    		<div class="contact-details">
    			<h2>Contact Details</h2>
    			<div class="contact-details-wrapper">
	    			<p>
	    				<label>Phone:</label>
	    				<span>+256 414 251658 / +256 701 221223</span>
	    			</p>
	    			<p>
	    				<labeL>Email:</label>
	    				<span>info@adriko.com</span>
	    			</p>
	    			<p>
	    				<label>Address:</label>
	    				<span>Plot 6-12 Makamba Road, Lungujja, Kosovo.</span>
	    			</p>
	    		</div>
    		</div>
    		<div class="contact-form">
    			<h2>Contact Form</h2>
		    	<?php print render($page['footer']); ?>
    		</div>
    	</div>
    	<div class="links-copyright-wrapper"><div class="links-copyright">
    		<div class="footer-primary-links"><?php print $primary_nav_footer ?></div>
    		<div class="copyright">&copy; www.adriko.com <?php print date('Y') ?></div>
    	</div></div>
    	<div class="credits-wrapper"><div class="credits"><a href="http://1010avenue.com" title="10/10 Digital Avenue" target="_blank">Design &amp; Development by <span>10/10 Digital</span></a></div></div>
    </div></div>
  </div>
  
</div>
