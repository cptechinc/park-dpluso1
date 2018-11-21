<?php
	$notesfile = $config->jsonfilepath.session_id()."-vinotes.json";
	// $notesfile = $config->jsonfilepath."vintv-vinotes.json";

	if ($config->ajax) {
		echo $page->bootstrap->create_element('p', '', $page->bootstrap->generate_printlink($config->filename, 'View Printable Version'));
	}

	if (file_exists($notesfile)) {
		// JSON file will be false if an error occurred during file_get_contents or json_decode
		$notesjson = json_decode(file_get_contents($notesfile), true);
		$notesjson = $notesjson ? $notesjson : array('error' => true, 'errormsg' => 'The Vendor Notes JSON contains errors. JSON ERROR: '.json_last_error()); 

		if ($notesjson['error']) {
			echo $page->bootstrap->alertpanel('warning', $notesjson['errormsg']); 
		} else {
			$internalcolumns = array_keys($notesjson['columns']['internal notes']);
			$purchasecolumns = array_keys($notesjson['columns']['purchase order notes']);
			
			if (sizeof($notesjson['data']) > 0) {
				echo '<div class="panel panel-primary">';
					foreach ($internalcolumns as $column) {
						$internalnotestitle = $notesjson['columns']['internal notes'][$column]['heading'];
						echo '<div class="panel-heading">';
							echo "<h4>$internalnotestitle</h4>";
						echo '</div>';
					}
					echo '<div class="panel-body list-group">';
						$internalcount = count($notesjson['data']['internal notes']);
						for ($i = 1; $i < $internalcount + 1; $i++) {
							$internalnotesdata = $notesjson['data']['internal notes'][$i]['internal note'];
							echo "<p class='list-group-item'>$internalnotesdata</p>";
						}
					echo '</div>';
				echo '</div>';
						
				echo '<div class="panel panel-primary">';
					foreach ($purchasecolumns as $column) {
						$purchasenotestitle = $notesjson['columns']['purchase order notes'][$column]['heading'];
						echo '<div class="panel-heading">';
							echo "<h4>$purchasenotestitle</h4>";
						echo '</div>';
					}
					echo '<div class="panel-body list-group">';
						$purchasecount = count($notesjson['data']['purchase order notes']);
						for ($i = 1; $i < $purchasecount + 1; $i++) {
							$purchasenotesdata = $notesjson['data']['purchase order notes'][$i]['purchase order note'];
							echo "<p class='list-group-item'>$purchasenotesdata</p>";
						}
					echo '</div>';
				echo '</div>';
			} else {
				echo $page->bootstrap->alertpanel('warning', 'Information Not Available'); 
			} // END if (sizeof($notesjson['data']) > 0)
		}
	} else {
		echo $page->bootstrap->alertpanel('warning', 'Vendor has no Notes'); 
	}
?>
