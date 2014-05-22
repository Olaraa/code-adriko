<?php

$results = $view->style_plugin->rendered_fields;
$raw_results = $view->result;
$no_results = count($results);
$no_cols = 4;
$no_rows = ceil($no_results/$no_cols);
$row_counter = 0;

//dsm($results);
//print dsm($raw_results);

?>

<div id="adrikos-mixes">

	<?php 
		for($i=0; $i<$no_results; $i++):
			$li_classes = 'mix-col-'. (($i%$no_cols)+1);
			$start_row = $end_row = false;
			$row_classes = '';
			$row = $results[$i];
			if ($i%$no_cols==0) {
				$start_row = true;
				$li_classes .= ' mix-col-first';
				$row_counter++;
				$row_classes = 'mix-row-'.$row_counter;
				$row_classes .= ' mix-row-'.($row_counter%2 ? 'odd' : 'even');
				$row_classes .= ($row_counter==1) ? ' mix-row-first' : '';
				$row_classes .= ($row_counter==$no_rows) ? ' mix-row-last' : '';
			}
			if ($i%$no_cols==$no_cols-1 || $i==$no_results-1) {
				$end_row = true;
				$li_classes .= ' mix-col-last';
			}
	?>
  	<?php if ($start_row) echo '<div class="ul-holder '.$row_classes.'"><ul class="clearfix">'; ?>
    	<li class="<?php print $li_classes ?>"><div class="mix-wrapper clearfix">
				<div class="img"><?php print $row['field_image'] ?></div>
				<div class="title"><?php print $row['title'] ?></div>
				<div class="desc"><?php print $row['body'] ?></div>
      </div></li>
  	<?php if ($end_row) echo '</ul></div>'; ?>
  <?php endfor; ?>
    
</div>
