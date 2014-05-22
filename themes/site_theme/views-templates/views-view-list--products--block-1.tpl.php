<?php

$results = $view->style_plugin->rendered_fields;
$raw_results = $view->result;
$no_results = count($results);
$no_cols = 2;
$no_rows = ceil($no_results/$no_cols);
$row_counter = 0;

//dsm($results);
//print dsm($raw_results);

?>

<div id="company-products-carousel">

	<?php 
		for($i=0; $i<$no_results; $i++):
			$li_classes = 'product-col-'. (($i%$no_cols)+1);
			$start_row = $end_row = false;
			$row_classes = '';
			$row = $results[$i];
			if ($i%$no_cols==0) {
				$start_row = true;
				$li_classes .= ' product-col-first';
				$row_counter++;
				$row_classes = 'product-row-'.$row_counter;
				$row_classes .= ' product-row-'.($row_counter%2 ? 'odd' : 'even');
				$row_classes .= ($row_counter==1) ? ' product-row-first' : '';
				$row_classes .= ($row_counter==$no_rows) ? ' product-row-last' : '';
			}
			if ($i%$no_cols==$no_cols-1 || $i==$no_results-1) {
				$end_row = true;
				$li_classes .= ' product-col-last';
			}
	?>
  	<?php if ($start_row) echo '<div class="ul-holder '.$row_classes.'"><ul class="clearfix">'; ?>
    	<li class="<?php print $li_classes ?>"><div class="product-wrapper clearfix">
    		<a href="<?php print $row['path'] ?>" title="<?php print $row['title'].' - Adrikos - West Nile Distilling Company' ?>" style="background-image: url('<?php print $row['field_image'] ?>');"><span><?php print $row['title'] ?></span></a>
      </div></li>
  	<?php if ($end_row) echo '</ul></div>'; ?>
  <?php endfor; ?>
    
</div>
