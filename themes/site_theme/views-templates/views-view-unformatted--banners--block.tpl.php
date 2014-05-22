<?php
$results = $view->style_plugin->rendered_fields;
$raw_results = $view->result;
$no_results = count($results);
$cnter = 0;
//print dsm($view->result);
$banner_links_list = '<ul class="clearfix" id="home-banner-links">';
?>


<div id="slider">
	<?php 
		$cnter = 0;
		foreach ($results as $id => $result) {
			//echo '<pre>';print_r($result);echo '</pre>';
			//print 'testing 3: '.theme_image($result['field_image_fid'], '', '#banner-caption-'.$id).'<br>';
			//put a NIVO rel in the array for a thumbnail per banner e.g. 'rel'=>$result['field_image_fid_2'],
			
			$banner_link_classes = 'banner-link-'.$cnter;
			if($cnter==0) $banner_link_classes .= ' banner-link-first';
			if($cnter==$no_results-1) $banner_link_classes .= ' banner-link-last';
			$banner_links_list .= '<li class="'.$banner_link_classes.'"><a></a></li>';
			
			$img = theme_image(array('path'=>$result['field_image'], 'title'=>$raw_results[$cnter]->field_field_link[0]['raw']['attributes']['title'], 'attributes'=>array('class'=>'img img-nid-'.$result['nid'].' img-'.$id,)));
			print '<div class="banner-cnt-'.$cnter++.'"><a href="'.$raw_results[$cnter]->field_field_link[0]['raw']['display_url'].'" title="'.$raw_results[$cnter++]->field_field_link[0]['raw']['attributes']['title'].'" class="link link-nid-'.$result['nid'].' link-'.$id.'" id="banner-nid-'.$result['nid'].'">'.$img.'</a></div>';
		}
	?>
</div>


<?php $cnter=0; foreach ($results as $id => $result): ?>
<div id="<?php print 'banner-nid-'.$result['nid'] ?>" class="centred-strip banner-caption <?php print 'banner-caption-'.$id ?>">
	<div class="desc-holder" id="desc-<?php print $id ?>"><div class="<?php print 'desc desc-'.$id ?>">
  	<div id="caption-content">
      <div class="title"><?php print $result['field_text_filtered'] ?></div>
      <div class="body"><?php print $result['body'] ?></div>
    </div>
  
		<?php if(false && $cnter==0): ?>
    <div id="carousel-btns"><span id="prev-btn"></span><span id="next-btn"></span></div>
    <div id="carousel-pagination"></div>
    <?php endif; ?>
    
  </div></div>
</div>
<?php $cnter++; endforeach; ?>

<?php //print $banner_links_list.'</ul>' ?>

