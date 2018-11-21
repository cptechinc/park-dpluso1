<?php
	if ($input->get->debug) {
		$tableformatter->set_debug(true);
	} elseif ($input->post->text('action') == 'preview') {
		$tableformatter->set_debug(true);
	}

	if ($config->ajax && $input->post->text('action') != 'preview') {
		echo $page->bootstrap->create_element('p', '', $page->bootstrap->generate_printlink($config->filename, 'View Printable Version'));
	}

	if (file_exists($tableformatter->fullfilepath)) {
		// JSON file will be false if an error occurred during file_get_contents or json_decode
		$tableformatter->process_json();
		
		if ($tableformatter->json['error']) {
			echo $page->bootstrap->alertpanel('warning', $tableformatter->json['errormsg']);
		} else {
			echo $tableformatter->generate_screen();
			echo $tableformatter->generate_javascript();
			
			if (!$input->post->action) {
				echo $page->bootstrap->h3('', 'Pricing');
				$tableformatter = $page->screenformatterfactory->generate_screenformatter('item-pricing');
				include $config->paths->content."item-information/ii-formatted-screen.php";
				
				echo $page->bootstrap->h3('', 'Stock');
				$tableformatter = $page->screenformatterfactory->generate_screenformatter('ii-item-stock');
				include $config->paths->content."item-information/ii-formatted-screen.php";
				
				if ($config->cptechcustomer == 'stat') {
					echo $page->bootstrap->h3('', 'Commission Pricing');
					include $config->paths->content."item-information/item-commission-pricing.php";
				}
			}
		}
	} else {
		echo $page->bootstrap->alertpanel('warning', 'Information Not Available');
	}
?>
