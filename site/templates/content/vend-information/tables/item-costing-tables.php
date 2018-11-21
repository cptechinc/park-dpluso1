<?php 

	$tb = new Dplus\Content\Table('class=table table-striped table-condensed table-excel');
	$tb->tr();
		$tb->td('', '<b>Item ID</b>');
		$tb->td('', $costjson['itemid']);
		$tb->td('colspan=2', $costjson['desc1']);
	$tb->tr();
		$tb->td('', '<b>Vendor ID</b>');
		$button = $page->bootstrap->create_element('button', "type=button|class=btn btn-primary btn-sm|data-dismiss=modal|onclick=iicust('ii-pricing')", 'Change Customer');
		$content = $costjson['vendid']." - ".$costjson['vendname'] . ' &nbsp; ';
		$tb->td('colspan=2', $content);
	$tb->tr();
		$tb->td('', '<b>Purch UoM</b>');
		$tb->td('colspan=2', $costjson['purchuom']);
	$itemtable = $tb->close();
	
	$tb = new Dplus\Content\Table('class=table table-striped table-condensed table-excel');
	$tb->tablesection('thead');
		$tb->tr();
		foreach ($costjson['columns']['vendor costing'] as $column) {
			$class = $config->textjustify[$column['headingjustify']];
			$tb->th("class=$class", $column['heading']);
		}
	$tb->closetablesection('thead');
	$tb->tablesection('body');
		$count = count($costjson['data']['vendor costing']);
		for ($i = 1; $i < $count + 1; $i++) {
			$title = $costjson['data']['vendor costing'][$i]['vend cost label'];
			$tb->tr();
				$tb->td('class='.$config->textjustify[$costjson['columns']['vendor costing']['vend cost label']['headingjustify']], "<b>$title</b>");
				$tb->td('class='.$config->textjustify[$costjson['columns']['vendor costing']['vend cost']['headingjustify']], $costjson['data']['vendor costing'][$i]['vend cost']);
				$tb->td('class='.$config->textjustify[$costjson['columns']['vendor costing']['vend cost date']['headingjustify']], $costjson['data']['vendor costing'][$i]['vend cost date']);
		}
	$tb->closetablesection('tbody');
	$costingtable = $tb->close();
	
?>
