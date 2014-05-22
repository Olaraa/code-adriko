<?php
$results = $view->style_plugin->rendered_fields;
$raw_results = $view->result;
$cnter = 0;
$results_no = count($results);
$results_by_year = array();
$year_keys = array();
$overall_cnter = 0;

for ($cnter=0; $cnter<$results_no; $cnter++) {
	$result = $results[$cnter];
	list($year) = explode('-', $raw_results[$cnter]->field_data_field_date_field_date_value);
	if (!isset($results_by_year['year-'.$year])) {
		$results_by_year['year-'.$year] = array('year'=>$year, 'results'=>array());
		$year_keys[] = $year;
	}
	$results_by_year['year-'.$year]['results'][] = $result;
}

$no_years = count($year_keys);

//dsm($results);
//print dsm($raw_results);
//print dsm($rows);

?>

<?php
	for ($cnter=0; $cnter<$no_years; $cnter++):
		$current_year = $year_keys[$cnter];
		$year_classes = 'year-cnter-'.$cnter.' year-'.$current_year;
		if ($cnter==0) $year_classes .= ' year-first';
		if ($cnter==$no_years-1) $year_classes .= ' year-last';
		
		$year_results = $results_by_year['year-'.$current_year]['results'];
		$no_year_results = count($year_results);
?>

<div class="year-wrapper <?php print $year_classes ?>">

	<div class="history-year">
		<div class="top-line"></div>
		<div class="history-year-figure"><?php print 'IN '.$current_year ?></div>
	</div>
	
	<div class="history-year-items-wrapper">

		<?php
			for ($i=0; $i<$no_year_results; $i++):
				$year_item = $year_results[$i];
				$year_item_classes = ' year-item-cnter-'.$i;
				if ($i==0) $year_item_classes .= ' year-item-first';
				if ($i==$no_year_results-1) $year_item_classes .= ' year-item-last';
				$year_item_classes .= ($i%2) ? ' year-item-odd' : ' year-item-even';
				$year_item_classes .= ($overall_cnter%2) ? ' year-item-overall-odd' : ' year-item-overall-even';
		?>

		<div class="history-year-item clearfix <?php print $year_item_classes ?>">
			<div class="images">
				<?php print $year_item['field_images'] ?>
			</div>
			<div class="desc">
				<h2><?php print $year_item['title'] ?></h2>
				<div class="body">
					<?php print $year_item['body'] ?>
				</div>
			</div>
		</div>

		<?php $overall_cnter++; endfor; ?>

	</div>

</div>

<?php endfor; ?>