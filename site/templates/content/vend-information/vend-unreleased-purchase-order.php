<?php
	$purchaseorderfile = $config->jsonfilepath.session_id()."-viunreleased.json";
	// $purchaseorderfile = $config->jsonfilepath."viunrv-viunreleased.json";
	
	if ($config->ajax) {
		echo $page->bootstrap->create_element('p', '', $page->bootstrap->generate_printlink($config->filename, 'View Printable Version'));
	}
	
	if (file_exists($purchaseorderfile)) {
		// JSON FILE will be false if an error occured during file get or json decode
		$purchaseorderjson = json_decode(convertfiletojson($purchaseorderfile), true);
		$purchaseorderjson ? $purchaseorderjson : array('error' => true, 'errormsg' => 'The VI Unreleased Purchase Orders JSON contains errors. JSON ERROR: ' . json_last_error());
		if ($purchaseorderjson['error']) {
			echo $page->bootstrap->alertpanel('warning', $purchaseorderjson['errormsg']);
		} else {
			$table = include $config->paths->content. 'vend-information/screen-formatters/logic/unreleased-purchase-order.php';
			include $config->paths->content. 'vend-information/tables/unreleased-purchase-order-formatted.php';
			include $config->paths->content. 'vend-information/scripts/unreleased-purchase-orders.js.php';
		}
	} else {
		echo $page->bootstrap->alertpanel('warning', 'Information not available.');
	}
?>
