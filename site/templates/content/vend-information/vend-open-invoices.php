<?php
	$invoicefile = $config->jsonfilepath.session_id()."-viopeninv.json";
	// $invoicefile = $config->jsonfilepath."viopen-viopeninv.json";

	if ($config->ajax) {
		echo $page->bootstrap->create_element('p', '', $page->bootstrap->generate_printlink($config->filename, 'View Printable Version'));
	}
	
	if (file_exists($invoicefile)) {
		// JSON file will be false if an error occurred during file_get_contents or json_decode
		$invoicejson = json_decode(file_get_contents($invoicefile), true);
		$invoicejson = $invoicejson ? $invoicejson : array('error' => true, 'errormsg' => 'The open invoice JSON contains errors. JSON ERROR: '.json_last_error());
		
		if ($invoicejson['error']) {
			echo $page->bootstrap->alertpanel('warning', $invoicejson['errormsg']);
		} else {
			$table = include $config->paths->content."vend-information/screen-formatters/logic/open-invoices.php"; 
			include $config->paths->content."vend-information/tables/open-invoices-formatted.php"; 
			include $config->paths->content."vend-information/scripts/open-invoices.js.php"; 
		}
	} else {
		echo $page->bootstrap->alertpanel('warning', 'Information Not Available');
	}
?>
