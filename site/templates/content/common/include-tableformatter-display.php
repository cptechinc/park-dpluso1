<?php 
	if (file_exists($tableformatter->fullfilepath)) {
		// JSON file will be false if an error occurred during file_get_contents or json_decode
		$tableformatter->process_json();
		
		if ($tableformatter->json['error']) {
			echo $page->bootstrap->alertpanel('warning', $tableformatter->json['errormsg']);
		} else {
			echo $tableformatter->generate_screen();
			echo $tableformatter->generate_javascript();
		}
	} else {
		echo $page->bootstrap->alertpanel('warning', 'Information Not Available');
	}
