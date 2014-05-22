<?php
$results = $view->style_plugin->rendered_fields;
$no_results = count($results);
$no_cols = 2;
$no_rows = ceil($no_results/$no_cols);
$row_counter = 0;
//print dsm($view->result);
?>

<div class="staff-listing">

	<?php 
		for($i=0; $i<$no_results; $i++):
			$li_classes = 'staff-col-'. (($i%$no_cols)+1);
			$start_row = $end_row = false;
			$row_classes = '';
			$row = $results[$i];
			if ($i%$no_cols==0) {
				$start_row = true;
				$li_classes .= ' staff-col-first';
				$row_counter++;
				$row_classes = 'staff-row-'.$row_counter;
				$row_classes .= ' staff-row-'.($row_counter%2 ? 'odd' : 'even');
				$row_classes .= ($row_counter==1) ? ' staff-row-first' : '';
				$row_classes .= ($row_counter==$no_rows) ? ' staff-row-last' : '';
			}
			if ($i%$no_cols==$no_cols-1 || $i==$no_results-1) {
				$end_row = true;
				$li_classes .= ' staff-col-last';
			}
	?>
  	<?php if ($start_row) echo '<div class="ul-holder '.$row_classes.'"><ul class="clearfix">'; ?>
    	<li class="<?php print $li_classes ?>"><div class="staff clearfix">
        <?php print $row['nid'] ?>
      </div></li>
  	<?php if ($end_row) echo '</ul></div>'; ?>
  <?php endfor; ?>
    
</div>
