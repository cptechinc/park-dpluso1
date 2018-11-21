<?php
	$costfile = $config->jsonfilepath.session_id()."-iicost.json";
	//$costfile = $config->jsonfilepath."iicost-iicost.json";
	
	if ($config->ajax) {
		$url = new Purl\Url($page->fullURL->getUrl());
		$url->query->set('View', 'print');
		echo $page->bootstrap->create_element('p', '', $page->bootstrap->generate_printlink($url->getUrl(), 'View Printable Version'));
	}
	
	if (file_exists($costfile)) {
		// JSON file will be false if an error occurred during file_get_contents or json_decode
		$costjson = json_decode(file_get_contents($costfile), true); 
		$costjson = $costjson ? $costjson : array('error' => true, 'errormsg' => 'The Item Costing JSON contains errors. JSON ERROR: '.json_last_error());
		
		if ($costjson['error']) {
			echo $page->bootstrap->alertpanel('warning', $costjson['errormsg']);
		} else {
			$warehousecolumns = array_keys($costjson['columns']['warehouse']);
			$vendorcolumns = array_keys($costjson['columns']['vendor']);
			$purchasecolumns = array_keys($costjson['columns']['last purchase']);
			
			$tb = new Dplus\Content\Table('class=table table-striped table-condensed table-excel');
			$tb->tr();
			$tb->td('', '<b>Item ID</b>')->td('', $costjson['itemid'])->td('colspan=2', $costjson['desc1']);
			
			$tb->tr();
			$tb->td('', '<b>Sales UoM</b>')->td('', $costjson['sale uom'])->td('colspan=2', $costjson['desc2']);
			
			$tb->tr();
			$tb->td('', '<b>Stan Cost</b>')->td('class=text-center', $costjson['stan cost'])->td('', '<b>Avg Cost:</b> ' . $costjson['avg cost']);
			$tb->td('', '<b>Avg Cost:</b> ' . $costjson['last cost']);
			echo $tb->close();
			
			echo $page->bootstrap->open('ul', 'class=nav nav-tabs|role=tablist');
				echo $page->bootstrap->create_element('li', 'role=presentation|class=active', $page->bootstrap->create_element('a', 'href=#whse|aria-controls=warehouse|role=tab|data-toggle=tab', 'Warehouse'));
				echo $page->bootstrap->create_element('li', 'role=presentation', $page->bootstrap->create_element('a', 'href=#vendor|aria-controls=vendor|role=tab|data-toggle=tab', 'Vendor'));
				echo $page->bootstrap->create_element('li', 'role=presentation', $page->bootstrap->create_element('a', 'href=#lastpurchase|aria-controls=lastpurchase|role=tab|data-toggle=tab', 'Last Purchase'));
			echo $page->bootstrap->close('ul');
			
			echo $page->bootstrap->open('div', '');
			echo $page->bootstrap->open('div', 'class=tab-content');
				// WAREHOUSE TAB
				echo $page->bootstrap->open('div', 'role=tabpanel|class=tab-pane active|id=whse');
					foreach ($costjson['data']['warehouse'] as $whse) {
						echo '<h3>'.$whse['whse name'].'</h3>';
						$tb = new Dplus\Content\Table('class=table table-striped table-bordered table-condensed table-excel no-bottom');
						$tb->tablesection('thead')->tr();
							foreach ($costjson['columns']['warehouse'] as $column) {
								$class = $config->textjustify[$column['headingjustify']];
								$tb->th("class=$class", $column['heading']);
							}
						$tb->closetablesection('thead');
						$tb->tablesection('tbody');
							foreach ($whse['lots'] as $lot) {
								$tb->tr();
								foreach ($warehousecolumns as $column) {
									$class = $config->textjustify[$costjson['columns']['warehouse'][$column]['datajustify']];
									$tb->td("class=$class", $lot[$column]);
								}
							}
						$tb->closetablesection('tbody');
						echo $tb->close();
					}
				echo $page->bootstrap->close('div'); // CLOSES #whse
				
				echo $page->bootstrap->open('div', 'role=tabpanel|class=tab-pane|id=vendor');
					foreach ($costjson['data']['vendor'] as $vendor) {
						echo '<h3>'.$vendor['vend id'].'</h3>';
						echo $page->bootstrap->open('div', 'class=row');
							echo $page->bootstrap->open('div', 'class=col-sm-6');
								$tb = new Dplus\Content\Table('class=table table-striped table-bordered table-condensed table-excel no-bottom');
								$tb->tr()->td('', 'Vendor:')->td('', $vendor['vend name']);
								$tb->tr()->td('', 'Phone Nbr:')->td('', $vendor['vend phone']);
								$tb->tr()->td('', 'Purch UoM:')->td('', $vendor['vend uom']);
								$tb->tr()->td('', 'Case Qty:')->td('', $vendor['vend case qty']);
								$tb->tr()->td('', 'List Price:')->td('', $vendor['vend price']);
								$tb->tr()->td('', 'Change Date:')->td('', $vendor['vend chg date']);
								$tb->tr()->td('', 'PO Order Code:')->td('', $vendor['vend po code']);
								echo $tb->close();
							echo $page->bootstrap->close('div'); // CLOSES col-sm-6
							
							echo $page->bootstrap->open('div', 'class=col-sm-6');
								$tb = new Dplus\Content\Table('class=table table-striped table-bordered table-condensed table-excel no-bottom');
								$tb->tr();
								$tb->tablesection('thead');
									foreach ($costjson['columns']['vendor'] as $column) {
										$class = $config->textjustify[$column['headingjustify']];
										$tb->th("class=$class", $column['heading']);
									}
								$tb->closetablesection('thead');
								$tb->tablesection('tbody');
									foreach ($vendor['vend cost breaks'] as $costbreak) {
										$tb->tr();
										foreach ($vendorcolumns as $column) {
											$class = $config->textjustify[$costjson['columns']['vendor'][$column]['datajustify']];
											$tb->td("class=$class", $costbreak[$column]);
										}
									}
								$tb->closetablesection('tbody');
								echo $tb->close();
							echo $page->bootstrap->close('div'); // CLOSES col-sm-6
							
						echo $page->bootstrap->close('div');
					}
				echo $page->bootstrap->close('div'); // CLOSES #vendor
				
				echo $page->bootstrap->open('div', 'role=tabpanel|class=tab-pane|id=lastpurchase');
					$tb = new Dplus\Content\Table('class=table table-striped table-bordered table-condensed table-excel no-bottom');
					$tb->tr();
					$tb->tablesection('thead');
						foreach ($costjson['columns']['last purchase'] as $column) {
							$class = $config->textjustify[$column['headingjustify']];
							$tb->th("class=$class", $column['heading']);
						}
					$tb->closetablesection('thead');
					$tb->tablesection('tbody');
						foreach ($costjson['data']['last purchase'] as $lastpurchase) {
							$tb->tr();
							foreach ($purchasecolumns as $column) {
								$class = $config->textjustify[$costjson['columns']['last purchase'][$column]['datajustify']];
								$tb->td("class=$class", $lastpurchase[$column]);
							}
						}
					$tb->closetablesection('tbody');
					echo $tb->close();
				echo $page->bootstrap->close('div'); // CLOSES #lastpurchase
			echo $page->bootstrap->close('div');
			echo $page->bootstrap->close('div');
		}
	} else {
		echo $page->bootstrap->alertpanel('warning', 'Information Not Available');
	}
?>
