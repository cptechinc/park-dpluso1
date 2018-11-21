<?php
	$tb = new Dplus\Content\Table('class=table table-striped table-bordered table-condensed table-excel|id=unreleased-purchase-orders');
	$tb->tablesection('thead');
		for ($x = 1; $x < $table['header']['maxrows'] + 1; $x++) {
			$tb->tr();
			for ($i = 1; $i < $table['maxcolumns'] + 1; $i++) {
				if (isset($table['header']['rows'][$x]['columns'][$i])) {
					$column = $table['header']['rows'][$x]['columns'][$i];
					$class = $config->textjustify[$fieldsjson['data']['header'][$column['id']]['headingjustify']];
					$colspan = $column['col-length'];
					$tb->th('colspan='.$colspan.'|class='.$class, $column['label']);
					if ($colspan > 1) { $i = $i + ($colspan - 1); }
				} else {
					$tb->th();
				}
			}
		}
		
		for ($x = 1; $x < $table['detail']['maxrows'] + 1; $x++) {
			$tb->tr();
			for ($i = 1; $i < $table['maxcolumns'] + 1; $i++) {
				if (isset($table['detail']['rows'][$x]['columns'][$i])) {
					$column = $table['detail']['rows'][$x]['columns'][$i];
					$class = $config->textjustify[$fieldsjson['data']['detail'][$column['id']]['headingjustify']];
					$colspan = $column['col-length'];
					$tb->th('colspan='.$colspan.'|class='.$class, $column['label']);
					if ($colspan > 1) { $i = $i + ($colspan - 1); }
				} else {
					$tb->th();
				}
			}
		}
		
	$tb->closetablesection('thead');
	$tb->tablesection('tbody');
        foreach($purchaseorderjson['data']['purchaseorders'] as $order) {
			for ($x = 1; $x < $table['header']['maxrows'] + 1; $x++) {
				$tb->tr('');
				for ($i = 1; $i < $table['maxcolumns'] + 1; $i++) {
					if (isset($table['header']['rows'][$x]['columns'][$i])) {
						$column = $table['header']['rows'][$x]['columns'][$i];
						$class = $config->textjustify[$fieldsjson['data']['header'][$column['id']]['datajustify']];
						$colspan = $column['col-length'];
						$celldata = Table::generatejsoncelldata($fieldsjson['data']['header'][$column['id']]['type'], $order, $column);
						$tb->td('colspan='.$colspan.'|class='.$class, $celldata);
						if ($colspan > 1) { $i = $i + ($colspan - 1); }
					} else {
						$tb->td();
					}
				}
				foreach ($order['details'] as $detail) {
					for ($x = 1; $x < $table['detail']['maxrows'] + 1; $x++) {
		                $tb->tr('');
		                for ($i = 1; $i < $table['maxcolumns'] + 1; $i++) {
		                    if (isset($table['detail']['rows'][$x]['columns'][$i])) {
		                        $column = $table['detail']['rows'][$x]['columns'][$i];
		                        $class = $config->textjustify[$fieldsjson['data']['detail'][$column['id']]['datajustify']];
		                        $colspan = $column['col-length'];
		                        $celldata = Table::generatejsoncelldata($fieldsjson['data']['detail'][$column['id']]['type'], $detail, $column);
		                        $tb->td('colspan='.$colspan.'|class='.$class, $celldata);
		                        if ($colspan > 1) { $i = $i + ($colspan - 1); }
		                    } else {
		                        $tb->td();
		                    }
		                }
						foreach ($detail['detailnotes'] as $note) {
							for ($y = 1; $y < $table['detail']['maxrows'] + 1; $y++) {
								$tb->tr('');
								for ($i = 1; $i < $table['maxcolumns'] + 1; $i++) {
									if ($i == 2) {
										$tb->td('', $note['Detail Notes']);
									} else {
										$tb->td('');
									}
								}
							}	
						} // end of detail notes
		            }
				} // end of details
				
				foreach ($order['ordernotes'] as $ordernote) {
					for ($y = 1; $y < $table['detail']['maxrows'] + 1; $y++) {
						$tb->tr('');
						for ($i = 1; $i < $table['maxcolumns'] + 1; $i++) {
							if ($i == 2) {
								$tb->td('', $ordernote['Order Notes']);
							} else {
								$tb->td('');
							}
						}
					}
				}
				
	            $pototals = $order['pototals'];
	            for ($x = 1; $x < $table['detail']['maxrows'] + 1; $x++) {
	                $tb->tr('');
	                for ($i = 1; $i < $table['maxcolumns'] + 1; $i++) {
	                    if (isset($table['detail']['rows'][$x]['columns'][$i])) {
	                        $column = $table['detail']['rows'][$x]['columns'][$i];
	                        $class = $config->textjustify[$fieldsjson['data']['detail'][$column['id']]['datajustify']];
	                        $colspan = $column['id'] == "Purchase Order Number" ? 2 : $column['col-length'];
	                        $celldata = Table::generatejsoncelldata($fieldsjson['data']['detail'][$column['id']]['type'], $pototals, $column);
	                        $tb->td('colspan='.$colspan.'|class='.$class, $celldata);
	                        if ($colspan > 1) { $i = $i + ($colspan - 1); }
	                    } else {
	                        $tb->td();
	                    }
	                }
	            } // end of pototals
			} // end of purchase order #
			
            $tb->tr('class=last-section-row');
            for ($i = 1; $i < $table['maxcolumns'] + 1; $i++) {
                $tb->td();
            }
		}
        
        $vendortotal = $purchaseorderjson['data']['vendortotals'];
			for ($x = 1; $x < $table['detail']['maxrows'] + 1; $x++) {
				$tb->tr('class=bg-primary');
				for ($i = 1; $i < $table['maxcolumns'] + 1; $i++) {
					if (isset($table['detail']['rows'][$x]['columns'][$i])) {
						$column = $table['detail']['rows'][$x]['columns'][$i];
						$class = $config->textjustify[$fieldsjson['data']['detail'][$column['id']]['datajustify']];
						$colspan = $column['id'] == "Line Number" ? 2 : $column['col-length'];
						$celldata = Table::generatejsoncelldata($fieldsjson['data']['detail'][$column['id']]['type'], $vendortotal, $column);
						$tb->td('colspan='.$colspan.'|class='.$class, $celldata);
						if ($colspan > 1) { $i = $i + ($colspan - 1); }
					} else {
						$tb->td();
					}
				}
			}
            
	$tb->closetablesection('tbody');
	echo $tb->close();
