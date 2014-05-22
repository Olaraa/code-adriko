<?php
$results = $view->style_plugin->rendered_fields;
$raw_results = $view->result;
$cnter = 0;
$no_results = count($results);

//dsm($results);
//dsm($raw_results);

?>

<div class="locations-list-map-wrapper">

	<div class="locations-list-wrapper">
		<h2>Depot Locations</h2>
		<ul class="clearfix locations-list">
		
		<?php
			$javascript_points = '';
			$cols = 5;
			for ($cnter=0; $cnter<$no_results; $cnter++):
				$location = $raw_results[$cnter];
				$location_classes = 'location-cnter-'.$cnter;
				if ($cnter==0) $location_classes .= ' location-first';
				if ($cnter==$no_results-1) $location_classes .= ' location-last';
				$location_classes .= ($cnter%2) ? ' location-odd' : ' location-even';
				
				//columns
				$location_classes .= ' location-col-'.$cnter%$cols;
				if ($cnter%$cols==0) $location_classes .= ' location-col-first';
				if ($cnter%$cols==4) $location_classes .= ' location-col-last';
				
				$depot_latitude = $location->field_field_text_1[0]['rendered']['#markup'];
				$depot_longitude = $location->field_field_text_2[0]['rendered']['#markup'];
				$depot_phone = $location->field_field_text[0]['rendered']['#markup'];
				$depot_address = $location->field_field_text_filtered[0]['rendered']['#markup'];
				$depot_name = $location->node_title;
				$javascript_points .= '{lat:'.$depot_latitude.', lon:'.$depot_longitude.', phone:"'.$depot_phone.'", address:"'.$depot_address.'", name:"'.$depot_name.'"}';
				if ($cnter<$no_results-1) $javascript_points .= ', ';
		?>
		
		<li class="location <?php print $location_classes ?>">
			<a href="javascript:;" title="Click this location to view it on the map below.">
				<span class="name"><?php print $depot_name ?></span>
				<?php if ($depot_phone): ?>
				<span class="tel"><?php print 'Tel: '.$depot_phone ?></span>
				<?php endif; ?>
				<?php if ($depot_address): ?>
				<span class="address">
					<?php print $depot_address ?>
				</span>
				<?php endif; ?>
			</a>
		</li>
		
		<?php endfor; ?>
		
	</ul></div>
	
	<div class="map-locations">
		<div id="locations-map"></div>
	</div>

</div>

<script type="text/javascript">
	buy_location_points = [<?php print $javascript_points ?>];
</script>