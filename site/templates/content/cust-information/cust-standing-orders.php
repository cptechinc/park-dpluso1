<?php
	$standfile = $config->jsonfilepath.session_id()."-cistandordr.json";
	//$standfile = $config->jsonfilepath."cistand-cistandordr.json";
	
	if ($config->ajax) {
		echo $page->bootstrap->create_element('p', '', $page->bootstrap->generate_printlink($config->filename, 'View Printable Version'));
	}

	if (file_exists($standfile)) {
		// JSON file will be false if an error occurred during file_get_contents or json_decode
		$standingjson = json_decode(file_get_contents($standfile), true);
		$standingjson = $standingjson ? $standingjson : array('error' => true, 'errormsg' => 'The Customer Standing Orders JSON contains errors JSON ERROR: '.json_last_error());
		
		if ($standingjson['error']) {
			echo $page->bootstrap->alertpanel('warning', $standingjson['errormsg']);
		} else {
			$custcolumns = array_keys($standingjson['columns']['custinfo']);
			$itemcolumns = array_keys($standingjson['columns']['iteminfo']);
			
			foreach ($standingjson['data'] as $order) {
				include $config->paths->content."cust-information/tables/standing-orders.php";
			}
		}
	} else {
		echo $page->bootstrap->alertpanel('warning', 'Information Not Available');
	}
 ?>
