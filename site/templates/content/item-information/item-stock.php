<?php
	$stockfile = $config->jsonfilepath.session_id()."-iistkstat.json";
	
	$itemlink = $page->fullURL;
	$itemlink->path = $config->pages->products."redir/";
	$itemlink->query = '';
	
	if ($config->ajax) {
		echo $page->bootstrap->create_element('p', '', $page->bootstrap->generate_printlink($config->filename, 'View Printable Version'));
	}

	if (file_exists($stockfile))  {
		// JSON file will be false if an error occurred during file_get_contents or json_decode
		$jsonstock = json_decode(file_get_contents($stockfile), true); 
		$jsonstock = $jsonstock ? $jsonstock : array('error' => true, 'errormsg' => 'The Stock Info JSON contains errors. JSON ERROR: '.json_last_error());
		
		if ($jsonstock['error']) {
			echo $page->bootstrap->alertpanel('warning', $jsonstock['errormsg']);
		} else {
			$columns = array_keys($jsonstock['columns']);
			$tb = new Dplus\Content\Table('class=table table-striped table-condensed table-bordered table-excel');
			$tb->tablesection('thead');
				$tb->tr();
				foreach ($jsonstock['columns'] as $column) {
					$class = $config->textjustify[$column['headingjustify']];
					$tb->th("class=$class", $column['heading']);
				}
			$tb->closetablesection('thead');
			$tb->tablesection('tbody');
				foreach ($jsonstock['data'] as $warehouse) {
					$tb->tr();
					foreach ($columns as $column) {
						$class = $config->textjustify[$jsonstock['columns'][$column]['datajustify']];
						if ($column == "Item ID") {
							$itemlink->query->setData(array("action" => "ii-select", "custID" => $custID, 'itemID' => $warehouse[$column]));;
							$content = $page->bootstrap->create_element('a', "href=".$itemlink->getUrl(), $warehouse[$column]);
						} else {
							$content = $warehouse[$column];
						}
						$tb->td("class=$class", $content);
					}
				}
			$tb->closetablesection('tbody');
			echo $tb->close();
		}
	} else {
		echo $page->bootstrap->alertpanel('warning', 'Information Not Available');
	}
?>
