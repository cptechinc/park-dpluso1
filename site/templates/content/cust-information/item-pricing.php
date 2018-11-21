<?php
	$pricefile = $config->jsonfilepath.session_id()."-iiprice.json";
	//$pricefile = $config->jsonfilepath."iiprc-iiprice.json";
	
	if ($config->ajax) {
		echo $page->bootstrap->create_element('p', '', $page->bootstrap->generate_printlink($config->filename, 'View Printable Version'));
	}
	
	if (file_exists($pricefile)) {
		// JSON file will be false if an error occurred during file_get_contents or json_decode
		$pricejson = json_decode(file_get_contents($pricefile), true);
		$pricejson = $pricejson ? $pricejson : array('error' => true, 'errormsg' => 'The Item Price JSON contains errors. JSON ERROR: ' . json_last_error());
		
		if ($pricejson['error']) {
			echo $page->bootstrap->alertpanel('warning', $pricejson['errormsg']);
		} else {
			$standardpricecolumns = array_keys($pricejson['columns']['standard pricing']);
			$customerpricecolumns = array_keys($pricejson['columns']['customer pricing']);
			$derivedpricecolumns = array_keys($pricejson['columns']['pricing derived from']);
			include $config->paths->content."cust-information/tables/item-pricing-tables.php";
			
			echo $itemtable;
			echo '<div class="row">';
				echo '<div class="col-sm-4">';
					echo '<h3>Standard Pricing</h3>';
					echo $standardpricingtable;
				echo '</div>';
				echo '<div class="col-sm-4">';
					echo '<h3>Customer Pricing</h3>';
					echo $customerpricingtable;
				echo '</div>';
				echo '<div class="col-sm-4">';
					echo '<h3>Pricing Derived From</h3>';
					echo $derivedpricingtable;
				echo '</div>';
			echo '</div>';
		}
	} else {
		echo $page->bootstrap->alertpanel('warning', 'Information Not Available');
	}
 ?>
