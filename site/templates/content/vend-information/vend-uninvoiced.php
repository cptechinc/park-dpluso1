<?php
	 $uninvoicedfile = $config->jsonfilepath.session_id()."-viuninvoiced.json";
	//$uninvoicedfile = $config->jsonfilepath."viuni-viuninvoiced.json";
	
	if ($config->ajax) {
		echo $page->bootstrap->create_element('p', '', $page->bootstrap->generate_printlink($config->filename, 'View Printable Version'));
	}
	
	if (file_exists($uninvoicedfile)) {
		// JSON FILE will be false if an error occured during file get or json decode
		$uninvoicedjson = json_decode(convertfiletojson($uninvoicedfile), true);
		$uninvoicedjson ? $uninvoicedjson : array('error' => true, 'errormsg' => 'The VI Uninvoiced Purchase Orders JSON contains errors. JSON ERROR: ' . json_last_error());
		
		if ($uninvoicedjson['error']) {
			echo $page->bootstrap->alertpanel('warning', $uninvoicedjson['errormsg']);
		} else {
			$headercolumns = array_keys($uninvoicedjson['columns']['header']);
		    $detailcolumns = array_keys($uninvoicedjson['columns']['details']);
			
			$columncount = $detailcolumns > $headercolumns ? sizeof($detailcolumns) : sizeof($headercolumns);
			
			if (sizeof($uninvoicedjson['data']) > 0) {
				$tb = new Dplus\Content\Table('class=table table-striped table-bordered table-condensed table-excel|id=uninvoiced');
				$tb->tablesection('thead');
					$tb->tr();
					foreach ($headercolumns as $column) {
						$class = $config->textjustify[$uninvoicedjson['columns']['header'][$column]['headingjustify']];
						$tb->th("class=$class", $uninvoicedjson['columns']['header'][$column]['heading']);
					}
					
					if (sizeof($headercolumns) < $columncount) {
						for ($i = 0; $i < ($columncount - sizeof($headercolumns)); $i++) {
							$tb->th('');
						}
					}
					
					$tb->tr();
					foreach ($detailcolumns as $column) {
						$class = $config->textjustify[$uninvoicedjson['columns']['details'][$column]['headingjustify']];
						$tb->th("class=$class", $uninvoicedjson['columns']['details'][$column]['heading']);
					}
				$tb->closetablesection('thead');
				$tb->tablesection('tbody');
					 foreach ($uninvoicedjson['data']['purchaseorders'] as $order) {
						$tb->tr('');
					
						foreach ($headercolumns as $column) {
							$class = $config->textjustify[$uninvoicedjson['columns']['header'][$column]['datajustify']];
							$tb->td("class=$class", $order[$column]);
						}
						
						if (sizeof($headercolumns) < $columncount) {
							for ($i = 0; $i < ($columncount - sizeof($headercolumns)); $i++) {
								$tb->td('');
							}
						}
						
						foreach ($order['details'] as $detail) {
							$tb->tr('');
							
							foreach ($detailcolumns as $column) {
								$class = $config->textjustify[$uninvoicedjson['columns']['details'][$column]['datajustify']];
 								$tb->td("class=$class", $detail[$column]);
							}
						}
						
						// Purchase Order Total
						$total = $order['totals'];
						$tb->tr('');
						foreach ($detailcolumns as $column) {
							$class = $config->textjustify[$uninvoicedjson['columns']['details'][$column]['datajustify']];
							$tb->td("class=$class", $total[$column]);
						}
						
						$tb->tr('class=last-section-row');
						$tb->td('colspan='.sizeof($uninvoicedjson['columns']['details']));
					}
					
					$vendortotals = $uninvoicedjson['data']['vendortotals'];
					$tb->tr('class=bg-primary');
					
					foreach ($detailcolumns as $column) {
						$class = $config->textjustify[$uninvoicedjson['columns']['details'][$column]['datajustify']];
						$tb->td("class=$class", $vendortotals[$column]);
					}
					
				$tb->closetablesection('tbody');
				echo $tb->close();
			}
		}
	} else {
		echo $page->bootstrap->alertpanel('warning', 'Information not available.');
	}
?>
