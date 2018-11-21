<?php
	use Dplus\ProcessWire\DplusWire as DplusWire;
	
	function renderNavTree($items, $maxDepth = 3) {
		// if we've been given just one item, convert it to an array of items
		//
		if($items instanceof \Processwire\Page) $items = array($items);
		// if there aren't any items to output, exit now
		if(!count($items)) return;
		// $out is where we store the markup we are creating in this function
		// start our <ul> markup
		echo "<div class='list-group'>";
		// cycle through all the items
		foreach($items as $item) {
			// markup for the list item...
			// if current item is the same as the page being viewed, add a "current" class to it
			// markup for the link
			if($item->id == Processwire\wire('page')->id) {
				echo "<a href='$item->url' class='list-group-item bg-primary'>$item->title</a>";
			} else {
				echo "<a href='$item->url' class='list-group-item'>$item->title</a>";
			}
			// if the item has children and we're allowed to output tree navigation (maxDepth)
			// then call this same function again for the item's children
			if($item->hasChildren() && $maxDepth) {
				renderNavTree($item->children, $maxDepth-1);
			}
			// close the list item
			//echo "</li>";
		}
		// end our <ul> markup
		echo "</div>";
	}

	function generate_documentationmenu(\Processwire\Page $page, $maxdepth = 4) {
		$page = Processwire\wire('pages')->get('/documentation/');

		if (Processwire\wire('page')->id == $page->id) {
			generate_documentationsubmenu($page, 1);
		} else {
			generate_documentationsubmenu($page, $maxdepth);
		}
	}

	function generate_documentationsubmenu($items, $maxdepth) {
		if ($items instanceof \Processwire\Page) $items = array($items);
		// if there aren't any items to output, exit now
		if (!count($items)) return;

		$parents = array();
		foreach(Processwire\wire('page')->parents as $parent) {
			$parents[] = $parent->id;
		}


		echo "<ul class='list-unstyled docs-nav'>";
		// cycle through all the items
		foreach ($items as $item) {
			// markup for the list item...
			// if current item is the same as the page being viewed, add a "current" class to it
			// markup for the link
			if ($item->dplusfunction == '' || has_dpluspermission(Processwire\wire('user')->loginid, $item->dplusfunction)) {
				if ($item->id == Processwire\wire('page')->id) {
					echo "<li class='active'>$item->title</li>";
					$parents[] = $item->id;
				} elseif (in_array($item->id, $parents)) {
					echo "<li class='active'>$item->title</li>";
				} else {
					echo "<li><a href='$item->url'>$item->title</a></li>";
				}
			}


			if (in_array($item->id, $parents)) {
				if ($item->hasChildren() && $maxdepth) {
					generate_documentationsubmenu($item->children, $maxdepth-1);
				}
			} elseif ($maxdepth == 1) {
				if ($item->hasChildren() && $maxdepth) {
					generate_documentationsubmenu($item->children, $maxdepth-1);
				}
			}

			// close the list item
			//echo "</li>";
		}
		// end our <ul> markup
		echo "</ul>";
	}
/* =============================================================
   STRING FUNCTIONS
 ============================================================ */
	function formatnumber($number, $beforedecimal, $afterdecimal) { // DEPRECATED 3/5/2018
		$array = explode('.', $number);
		return str_pad($array[0], $beforedecimal, '0', STR_PAD_LEFT) . '.' . str_pad($array[1], $afterdecimal, '0', STR_PAD_RIGHT);
	}

	function formatphone($number) { // DEPRECATED 3/5/2018 MOVED TO Stringer.class.php
		return preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '$1-$2-$3', $number);
	}

	function cleanforjs($str) {// DEPRECATED 3/5/2018 MOVED TO Stringer.class.php
		return urlencode(str_replace(' ', '-', str_replace('#', '', $str)));
	}

	function determine_qty(Processwire\WireInput $input, $requestmethod, $itemID) {
		if (DplusWire::wire('modules')->isInstalled('QtyPerCase')) {
			$qtypercase = DplusWire::wire('modules')->get('QtyPerCase');
			if (!empty($itemID)) {
				$qty = $qtypercase->generate_qtyfromcasebottle($itemID, $input->$requestmethod->text('bottle-qty'), $input->$requestmethod->text('case-qty'));
			}
		} else {
			$qty = !empty($input->$requestmethod->text('qty')) ? $input->$requestmethod->text('qty') : 1;

		}
		return $qty;
	}


/* =============================================================
   URL FUNCTIONS
 ============================================================ */
	function paginate($url, $page, $insertafter, $hash) { // DEPRECATED 3/5/2018 MOVED TO Paginator
		if (strpos($url, 'page') !== false) {
			$regex = "((page)\d{1,3})";
			if ($page > 1) { $replace = "page".$page; } else {$replace = ""; }
			$newurl = preg_replace($regex, $replace, $url);
		} else {
			$insertafter = str_replace('/', '', $insertafter)."/";
			$regex = "(($insertafter))";
			if ($page > 1) { $replace = $insertafter."page".$page."/";} else {$replace = $insertafter; }
			$newurl = preg_replace($regex, $replace, $url);
		}
		return $newurl . $hash;
	 }

/* =============================================================
   ORDERS FUNCTIONS
 ============================================================ */
	function returntracklink($carrier, $tracknbr, $on) {
		$link = '';
		if (strpos(strtolower($carrier), 'fed') !== false) {
			$link = "https://www.fedex.com/apps/fedextrack/?action=track&trackingnumber=$tracknbr&cntry_code=us";
		} elseif (strpos(strtolower($carrier), 'ups') !== false) {
			$link = "http://wwwapps.ups.com/WebTracking/track?track=yes&trackNums=$tracknbr&loc=en_us";
		} elseif (strpos(strtolower($carrier), 'gro') !== false) {
			$link = "http://wwwapps.ups.com/WebTracking/track?track=yes&trackNums=$tracknbr&loc=en_us";
		} elseif (strpos(strtolower($carrier), 'usps') !== false) {
			$link = "https://tools.usps.com/go/TrackConfirmAction?tLabels=$tracknbr";
		} elseif (strpos(strtolower($carrier), 'spe') !== false) {
			$link = "http://packages.speedeedelivery.com/index.php?barcodes=[$tracknbr";
		} elseif ((strpos(strtolower($carrier), 'will') !== false)) {
			$link = "#$on";
		} else {
			$link = "#$on";
		}
		return $link;
	}

 /* =============================================================
   DB FUNCTIONS
 ============================================================ */
	 function returnsqlquery($sql, $oldtonew, $havequotes) {
		$i = 0;
		foreach ($oldtonew as $old => $new) {
			if ($havequotes[$i]) {
				$sql = str_replace($old, "'".$new."'", $sql);
			} else {
				$sql = str_replace($old, $new, $sql);
			}
			$i++;
		}
		return $sql;
	}

	function returnlimitstatement($limit, $page) {
		if ($limit) {
			if ($page > 1 ) {$start_point = ($page * $limit) - $limit; } else { $start_point = 0; }
			return "LIMIT ".$start_point.",".$limit;
		} else {
			return "";
		}
	}

	/**
	 * [returnpreppedquery description]
	 * @param  [array] $originalarray [Key-Valued array with original record column values]
	 * @param  [type] $changedarray  [Key-Valued array with changed record column values]
	 * @return [array]                [Array that has the Set statement with prepped values, columns changed, how many need quotes, AND
	 * 								   The count of how many values changed between the original and changed.]
	 */
	function returnpreppedquery($originalarray, $changedarray) {
		$withquotes = $switching = array();
		$setstmt = '';
		$columns = array_keys($originalarray);
		foreach ($columns as $column) {
			if (strlen($changedarray[$column])) {
				if ($originalarray[$column] != $changedarray[$column]) {
					$prepped = ':'.$column;
					$setstmt .= $column." = ".$prepped.", ";
					$switching[$prepped] = $changedarray[$column];
					$withquotes[] = true;
				}
			}
		}
		$setstmt = rtrim($setstmt, ', ');
		return array(
			'switching' => $switching,
			'withquotes' => $withquotes,
			'setstatement' => $setstmt,
			'changecount' => sizeof($switching)
		);
	}

	function returnupdatequery($newlinks, $oldlinks, $wherelinks) {
		$wherestmt = '';
		$query = returnpreppedquery($oldlinks, $newlinks);
		foreach ($wherelinks as $column => $val) {
			$prepped = ':x'.$column;
			$wherestmt .= $column." = ".$prepped." AND ";
			$query['switching'][$prepped] = $val;
			$query['withquotes'][] = true;
		}
		$wherestmt = rtrim($wherestmt, ' AND ');
		$query['wherestatement'] = $wherestmt;
		return $query;
	}

	function returnwherelinks($linkarray) {
		$withquotes = $switching = array();
		$wherestmt = '';
		$columns = array_keys($linkarray);
		foreach ($linkarray as $key => $val) {
			if (strlen($val)) {
				$prepped = ':'.$key;
				$wherestmt .= $key." = ".$prepped." AND ";
				$switching[$prepped] = $val;
				$withquotes[] = true;
			}
		}
		$wherestmt = rtrim($wherestmt, ' AND ');
		return array(
			'switching' => $switching,
			'withquotes' => $withquotes,
			'wherestatement' => $wherestmt,
			'changecount' => sizeof($switching)
		);
	}

	function returninsertlinks($linkarray) {
		$withquotes = $switching = array();
		$columnlist = $valueslist = '';
		$columns = array_keys($linkarray);
		foreach ($linkarray as $key => $val) {
			if (strlen($val)) {
				$prepped = ':'.$key;
				$columnlist .= $key.", ";
				$valueslist .= $prepped.", ";
				$switching[$prepped] = $val;
				$withquotes[] = true;
			}
		}
		$columnlist = rtrim($columnlist, ', ');
		$valueslist = rtrim($valueslist, ', ');

		return array(
			'switching' => $switching,
			'withquotes' => $withquotes,
			'valuelist' => $valueslist,
			'columnlist' => $columnlist,
			'changecount' => sizeof($switching)
		);
	}

 /* =============================================================
   DATE FUNCTIONS
 ============================================================ */
	function get_time($timeString) {
		$partofDay = ""; $colon = ":";
		$timeAsString = substr($timeString, 0, 2) . $colon . substr($timeString, 2, 2);
		$time = explode($colon, $timeAsString, 2);
		$hour = $time[0];

		$hr = (int)$hour;

		if ($hr == 00) {
			$hr = 12;
			$partofDay = "AM";
		} else if ($hr > 12) {
			$hr = $hr - 12;
			$partofDay = "PM";
		} else {
			$partofDay = "AM";
		}

		$time = strval($hr) . $colon . $time[1].' '.$partofDay;
		return $time;
	}

/* =============================================================
  FILE FUNCTIONS
============================================================ */
	function writedplusfile($data, $filename) {
		$file = '';
		foreach ($data as $key => $value) {
			if (is_string($key)) {
				if (is_string($value)) {
					$file .= $key . "=" . $value . "\n";
				} else {
					$file .= $key . "\n";
				}
			} else {
				$file .= $value . "\n";
			}

		}
		$vard = "/usr/capsys/ecomm/" . $filename;
		$handle = fopen($vard, "w") or die("cant open file");
		fwrite($handle, $file);
		fclose($handle);
	}
	
/**
 * Writes an array one datem per line into the dplus directory
 * @param  array $data      Array of Lines for the request
 * @param  string $filename What to name File
 * @return void
 */
function write_dplusfile($data, $filename) {
	$file = '';
	foreach ($data as $line) {
		$file .= $line . "\n";
	}
	$vard = "/usr/capsys/ecomm/" . $filename;
	$handle = fopen($vard, "w") or die("cant open file");
	fwrite($handle, $file);
	fclose($handle);
}

	function writedataformultitems($data, $items, $qtys) {
		for ($i = 0; $i < sizeof($items); $i++) {
			$itemID = str_pad(DplusWire::wire('sanitizer')->text($items[$i]), 30, ' ');
			$qty = DplusWire::wire('sanitizer')->text($qtys[$i]);
			
			if (empty($qty)) {$qty = "1"; }
			$data[] = "ITEMID=".$itemID."QTY=".$qty;
		}
		return $data;
	}

	/**
	 * [convertfiletojson description]
	 * @param  [string] $file [String that contains file location]
	 * @return [string]       [Returns json-encode string]
	 */
	function convertfiletojson($file) {
		$json = file_get_contents($file);
		$json = preg_replace('~[\r\n]+~', '', $json);
		$json = utf8_clean($json);
		return $json;
	}

	function hashtemplatefile($filename) {
		$hash = hash_file(Processwire\wire('config')->userAuthHashType, Processwire\wire('config')->paths->templates.$filename);
		return Processwire\wire('config')->urls->templates.$filename.'?v='.$hash;
	}
	
	function hash_modulefile($filename) {
		$hash = hash_file(DplusWire::wire('config')->userAuthHashType, DplusWire::wire('config')->paths->siteModules.$filename);
		return DplusWire::wire('config')->urls->siteModules.$filename.'?v='.$hash;
	}

	function curl_redir($url) {
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => $url,
			CURLOPT_FOLLOWLOCATION => true
		));
		return curl_exec($curl);
	}

	function curl_post($url, $fields) {
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => $url,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_POST => count($fields),
			CURLOPT_POSTFIELDS => http_build_query($fields)
		));
		return curl_exec($curl);
	}

 /* =============================================================
   PROCESSWIRE USER FUNCTIONS
 ============================================================ */
	function setup_user($sessionID) {
		$loginrecord = get_loginrecord($sessionID);
		$loginID = $loginrecord['loginid'];
		$user = LogmUser::load($loginID);
		DplusWire::wire('user')->fullname = $loginrecord['loginname'];
		DplusWire::wire('user')->loginid = $loginrecord['loginid'];
		DplusWire::wire('user')->has_customerrestrictions = $loginrecord['restrictcustomers'];
		DplusWire::wire('user')->salespersonid = $loginrecord['salespersonid'];
		DplusWire::wire('user')->mainrole = $user->get_dplusorole();
		DplusWire::wire('user')->addRole($user->get_dplusrole());
	}

	/**
		 * Trigger a PHP error, warning, or notice. Automatically prepends 'CP-DPLUSO' for easier management. Note
		 * that fatal errors (E_USER_ERROR) will prevent further processing.
		 *
		 * @param    string    $error          Error message (max 1024 characters)
		 * @param    int   $level          PHP error level, from PHP's E_USER constants
		 * @return   null
		 */
		function error($error, $level = E_USER_ERROR) {
			$error = (strpos($error, 'CP-DPLUSO: ') !== 0 ? 'CP-DPLUSO: ' . $error : $error);
			trigger_error($error, $level);
			return;
		}
