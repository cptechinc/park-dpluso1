<?php
	$whereusedfile = $config->jsonfilepath.session_id()."-iiwhereused.json";
	//$whereusedfile = $config->jsonfilepath."iiuse-iiwhereused.json";
	//$whereusedfile = $config->jsonfilepath."iiuse2-iiwhereused.json";
	
	if ($config->ajax) {
		echo $page->bootstrap->create_element('p', '', $page->bootstrap->generate_printlink($config->filename, 'View Printable Version'));
	}
	
	if (file_exists($whereusedfile)) {
		// JSON file will be false if an error occurred during file_get_contents or json_decode
		$whereusedjson = json_decode(file_get_contents($whereusedfile), true);
		$whereusedjson = $whereusedjson ? $whereusedjson : array('error' => true, 'errormsg' => 'The Item Where Used JSON contains errors. JSON ERROR: '.json_last_error());
		
		if ($whereusedjson['error']) {
			echo $page->bootstrap->alertpanel('warning', $whereusedjson['errormsg']);
		} else {
			$kitcolumns = array_keys($whereusedjson['columns']['kit']);
			$bomcolumns = array_keys($whereusedjson['columns']['bom']);
			
			if (isset($whereusedjson['data']['kit'])) {
				echo '<h3>Kit</h3>';
				$tb = new Dplus\Content\Table('class=table table-striped table-bordered table-condensed table-excel');
				$tb->tablesection('thead');
					$tb->tr();
					foreach($whereusedjson['columns']['kit'] as $column) {
						$class = $config->textjustify[$column['headingjustify']];
						$tb->th("class=$class", $column['heading']);
					}
				$tb->closetablesection('thead');
				$tb->tablesection('tbody');
					foreach ($whereusedjson['data']['kit'] as $kit) {
						$tb->tr();
						foreach($kitcolumns as $column) {
							$class = $config->textjustify[$quotesjson['columns']['kit'][$column]['datajustify']];
							$tb->td("class=$class", $kit[$column]);
						}
					}
				$tb->closetablesection('tbody');
				echo $tb->close();
			}
			
			if (isset($whereusedjson['data']['bom'])) {
				echo '<h3>BOM</h3>';
				$tb = new Dplus\Content\Table('class=table table-striped table-bordered table-condensed table-excel');
				$tb->tablesection('thead');
					$tb->tr();
					foreach($whereusedjson['columns']['bom'] as $column) {
						$class = $config->textjustify[$column['headingjustify']];
						$tb->th("class=$class", $column['heading']);
					}
				$tb->closetablesection('thead');
				$tb->tablesection('tbody');
					foreach ($whereusedjson['data']['bom'] as $bom) {
						$tb->tr();
						foreach($bomcolumns as $column) {
							$class = $config->textjustify[$quotesjson['columns']['bom'][$column]['datajustify']];
							$tb->td("class=$class", $bom[$column]);
						}
					}
				$tb->closetablesection('tbody');
				echo $tb->close();
			}
		}
	} else {
		echo $page->bootstrap->alertpanel('warning', 'Information Not Available');
	}
 ?>
