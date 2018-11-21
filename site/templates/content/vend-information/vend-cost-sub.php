<?php
	$costfile = $config->jsonfilepath.session_id()."-vicost.json";
	// $costfile = $config->jsonfilepath."vicst-vicost.json";
	
	if (file_exists($costfile)) {
		// JSON file will be false if an error occurred during file_get_contents or json_decode
		$costjson = json_decode(file_get_contents($costfile), true);
		$costjson = $costjson ? $costjson : array('error' => true, 'errormsg' => 'The Item Cost JSON contains errors. JSON ERROR: ' . json_last_error());
		
		if ($costjson['error']) {
			echo $page->bootstrap->alertpanel('warning', $costjson['errormsg']);
		} else {
			$vendorcostcolumns = array_keys($costjson['columns']['vendor costing']);
			$supercolumns = array_keys($costjson['columns']['super/sub']);
			include $config->paths->content."vend-information/tables/item-costing-tables.php";
			
			echo $itemtable;
			echo $costingtable;
		}
	} else {
		echo $page->bootstrap->alertpanel('warning', 'Information Not Available');
	}
	
	
 ?>
