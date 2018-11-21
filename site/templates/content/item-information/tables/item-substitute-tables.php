<?php 
	$tb = new Dplus\Content\Table('class=table table-striped table-bordered table-condensed table-excel');
	$tb->tr();
	$tb->td('', 'Item ID:');
	$content = $substitutejson['itemid'] . "<br>";
	$content .= $substitutejson['desc1'] . "<br>";
	
	if (isset($substitutejson['alt item'])) {
		$content .= "<b>Alt Item ID:</b> ".$substitutejson['alt item'];
	} else {
		$content .= $substitutejson['desc2'];
	}
	
	$tb->td('', $content);
	$itemtable = $tb->close();

	$tb = new Dplus\Content\Table('class=table table-striped table-bordered table-condensed table-excel');
	$tb->tr();
	$tb->td('', 'Sale UoM');
	$tb->td('', $substitutejson['sale uom']);
	$tb->tr();
	$tb->td('', 'Base Price');
	$tb->td('', $substitutejson['base price']);
	$saletable = $tb->close();

	$tb = new Dplus\Content\Table('class=table table-striped table-bordered table-condensed table-excel');
	$tb->tablesection('thead');
		$tb->tr();
		foreach ($substitutejson['columns'] as $column) {
			$class = $config->textjustify[$column['headingjustify']];
			$tb->td("class=$class", $column['heading']);
		}
	$tb->closetablesection('thead');

	$tb->tablesection('tbody');
		foreach ($substitutejson['data']['sub items'] as $item) {
			$tb->tr();
			$class = $config->textjustify[$substitutejson['columns']["sub item"]['datajustify']];
			$tb->td("colspan=2|class=$class", $item["sub item"]);
			$tb->td('', $item['same/like']);
			$colspan = sizeof($substitutejson['columns']) - 3;
			$tb->td("colpan=$colspan", $item['sub desc']);
			
			if (isset($item['alt items'])) {
				$tb->td('colspan=2', '&nbsp; &nbsp; &nbsp; &nbsp;'.$item["alt items"]["alt item"]);
				$colspan = sizeof($columns) - 2;
				$tb->td("colpan=$colspan", $item["alt items"]["bag qty"]);
			}
			
			foreach ($item['whse'] as $whse) {
				$tb->tr();
				foreach(array_keys($substitutejson['columns']) as $column) {
					if ($column == 'sub item') {
						$tb->td();
					} else {
						$class = $config->textjustify[$substitutejson['columns'][$column]['datajustify']];
						$tb->td("class=$class", $whse[$column]);
					}
				}
			}
		}
	$tb->closetablesection('tbody');
	$subtitutetable = $tb->close();
