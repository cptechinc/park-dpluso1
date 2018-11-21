<?php
	$shiptofile = $config->jsonfilepath.session_id()."-cishiptolist.json";
	//$shiptofile = $config->jsonfilepath."cislist-cishiptolist.json";
	
	if (file_exists($shiptofile))  {
		$shiptojson = json_decode(file_get_contents($shiptofile), true); 
		$shiptojson = $shiptojson ? $shiptojson : array('error' => true, 'errormsg' => 'The customer Ship-tos Inquiry JSON contains errors');
		
		if ($shiptojson['error']) {
			echo $page->bootstrap->alertpanel('warning', $shiptojson['errormsg']);
		} else {
			if (sizeof($shiptojson['data']) > 0) {
				$columns = array_keys($shiptojson['columns']);
				$link = $config->pages->customer."redir/?action=ci-customer&custID=$custID";
				$attr = "href=$link|class=btn btn-sm btn-primary";
				echo $page->bootstrap->create_element('a', $attr, '<i class="glyphicon glyphicon-remove"></i> Clear Ship-to');
				$tb = new Dplus\Content\Table("class=table table-striped table-bordered table-condensed table-excel|id=shiptolist");
				$tb->tablesection('thead');
					$tb->tr();
					foreach ($columns as $column) {
						$class = $config->textjustify[$shiptojson['columns'][$column]['headingjustify']];
						$tb->th("class=$class", $shiptojson['columns'][$column]['heading']);
					}
				$tb->closetablesection('thead');
				$tb->tablesection('tbody');
					foreach ($shiptojson['data'] as $shipto) {
						$tb->tr();
						foreach ($columns as $column) {
							$class = $config->textjustify[$shiptojson['columns'][$column]['datajustify']];
							$content = '';
							if ($column == 'shipid') {
								$link = $config->pages->customer.'redir/?action=ci-shipto-info&custID='.$custID.'&shipID='.$shipto['shipid'];
								$content = $page->bootstrap->create_element('a', "href=$link|class=btn btn-sm btn-primary", $shipto[$column]);
							} else {
								$content = $shipto[$column];
							}
							$tb->td("class=$class", $content);
						}
					}
				$tb->closetablesection('tbody');
				echo $tb->close();
				include $config->paths->content."cust-information/scripts/cust-shiptos.js.php"; 
			} else {
				echo $page->bootstrap->alertpanel('warning', 'Customer has no Shiptos');
			}
		}
	} else {
		echo $page->bootstrap->alertpanel('warning', 'Information Not Available');
	}
 ?>
