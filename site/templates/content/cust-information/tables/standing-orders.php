<?php
	$tb = new Dplus\Content\Table('class=table table-striped table-bordered table-condensed table-excel');
	$tb->tablesection('tbody');
		foreach ($order['custinfo'] as $custinfo) {
			$tb->tr();
			foreach ($custcolumns as $column) {
				$tb->td('',$custinfo[$column]); 
			}
			$tb->td('', '&nbsp;');
			$tb->td('', '&nbsp;');
		}

		$tb->tr('');
		$tb->td('colspan=6|class=text-center', '------ STANDING ORDER DETAILS ------');
		
		foreach ($order['iteminfo'] as $iteminfo) {
			$tb->tr();
			$tb->td('', $iteminfo['itemidtext']);
			$tb->td('', $iteminfo['itemid']);
			$tb->td('', $iteminfo['itemdesc']);
			$tb->td('', '&nbsp;');
			$tb->td('', '&nbsp;');
			$tb->td('', '&nbsp;');
			
			foreach ($iteminfo['itemlines'] as $itemline) {
				$tb->tr();
				foreach ($itemcolumns as $column) {
					$tb->td('', $itemline[$column]); 
				}
			}
			
		}
	$tb->closetablesection('tbody');
	$tb->tablesection('tfoot');
	$tb->closetablesection('tfoot');
	echo $tb->close();	
	echo '<hr class="dark">';
