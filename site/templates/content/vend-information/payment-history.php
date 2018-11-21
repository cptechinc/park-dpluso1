<?php
	$paymentfile = $config->jsonfilepath.session_id()."-vipayment.json";
	// $paymentfile = $config->jsonfilepath."vipy-vipayment.json";
	
	if ($config->ajax) {
		echo $page->bootstrap->create_element('p', '', $page->bootstrap->generate_printlink($config->filename, 'View Printable Version'));
	}
	
	if (file_exists($paymentfile)) {
		// JSON FILE will be false if an error occured during file get or json decode
		$paymentjson = json_decode(convertfiletojson($paymentfile), true);
		$paymentjson ? $paymentjson : array('error' => true, 'errormsg' => 'The VI Payment History JSON contains errors. JSON ERROR: ' . json_last_error());
		if ($paymentjson['error']) {
			echo $page->bootstrap->alertpanel('warning', $paymentjson['errormsg']);
		} else {
			$table = include $config->paths->content. 'vend-information/screen-formatters/logic/payment-history.php';
			include $config->paths->content. 'vend-information/tables/payment-history-formatted.php';
			include $config->paths->content. 'vend-information/scripts/payments.js.php';
		}
	} else {
		echo $page->bootstrap->alertpanel('warning', 'Information not available.');
	}
?>
