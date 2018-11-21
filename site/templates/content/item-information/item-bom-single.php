<?php
	$bomfile = $config->jsonfilepath.session_id()."-iibomsingle.json";
	//$bomfile = $config->jsonfilepath."iiboms-iibomsingle.json";
	
	if ($config->ajax) {
		echo $page->bootstrap->create_element('p', '', $page->bootstrap->generate_printlink($config->filename, 'View Printable Version'));
	}
	
	if (file_exists($bomfile)) {
		// JSON file will be false if an error occurred during file_get_contents or json_decode
		$bomjson = json_decode(file_get_contents($bomfile), true);
		$bomjson = $bomjson ? $bomjson : array('error' => true, 'errormsg' => 'The BOM Item Inquiry Single JSON contains errors. JSON ERROR: '.json_last_error());
		
		if ($bomjson['error']) {
			echo $page->bootstrap->alertpanel('warning', $bomjson['errormsg']);
		} else {
			$componentcolumns = array_keys($bomjson['columns']['component']);
			$warehousecolumns = array_keys($bomjson['columns']['warehouse']);
			
			echo "<p><b>Kit Qty:</b> ".$bomjson['qtyneeded']."</p>";
			foreach ($bomjson['data']['component'] as $component)  {
				echo "<h3>".$component['component item']."</h3>";
				$tb = new Dplus\Content\Table('class=table table-striped table-bordered table-condensed table-excel no-bottom');
				$tb->tablesection('thead');
					$tb->tr();
					foreach($bomjson['columns']['component'] as $column) {
						$class = $config->textjustify[$column['headingjustify']];
						$tb->th("class=$class", $column['heading']);
					}
				$tb->closetablesection('thead');
				$tb->tablesection('tbody');
					$tb->tr();
					foreach ($componentcolumns as $column) {
						$class = $config->textjustify[$bomjson['columns']['component'][$column]['datajustify']];
						$tb->td("class=$class", $component[$column]);
					}
				$tb->closetablesection('tbody');
				echo $tb->close();
				
				$tb = new Dplus\Content\Table('class=table table-striped table-bordered table-condensed table-excel');
				$tb->tablesection('thead');
					$tb->tr();
					foreach($bomjson['columns']['warehouse'] as $column) {
						$class = $config->textjustify[$column['headingjustify']];
						$tb->th("class=$class", $column['heading']);
					}
				$tb->closetablesection('thead');
				$tb->tablesection('tbody');
					foreach ($component['warehouse'] as $whse)  {
						$tb->tr();
						foreach ($warehousecolumns as $column) {
							$class = $config->textjustify[$bomjson['columns']['warehouse'][$column]['datajustify']];
							$tb->td("class=$class", $whse[$column]);
						}
					}
				$tb->closetablesection('tbody');
				echo $tb->close();
			} // END foreach ($bomjson['data']['component'] as $component)
			$warehouses = '';
			foreach ($bomjson['data']['whse meeting req'] as $whse => $name) {
				$warehouses .= $name . ' ';
			}
			echo "<p><b>Warehouses that meet the Requirement: </b> $warehouses</p>";
		}
	} else {
		echo $page->bootstrap->alertpanel('warning', 'Information Not Available');
	}
?>
