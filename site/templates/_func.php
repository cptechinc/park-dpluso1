<?php
	use Dplus\ProcessWire\DplusWire;
	use Dplus\Dpluso\ScreenFormatters\TableScreenMaker;
	use Purl\Url;

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
			if($item->id == DplusWire::wire('page')->id) {
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
		$page = DplusWire::wire('pages')->get('/documentation/');

		if (DplusWire::wire('page')->id == $page->id) {
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
		foreach(DplusWire::wire('page')->parents as $parent) {
			$parents[] = $parent->id;
		}


		echo "<ul class='list-unstyled docs-nav'>";
		// cycle through all the items
		foreach ($items as $item) {
			// markup for the list item...
			// if current item is the same as the page being viewed, add a "current" class to it
			// markup for the link
			if ($item->dplusfunction == '' || has_dpluspermission(DplusWire::wire('user')->loginid, $item->dplusfunction)) {
				if ($item->id == DplusWire::wire('page')->id) {
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
	function cleanforjs($str) {// DEPRECATED 3/5/2018 MOVED TO Stringer.class.php
		return urlencode(str_replace(' ', '-', str_replace('#', '', $str)));
	}

	function determine_qty(Processwire\WireInput $input, $requestmethod, $itemID) {
		if (DplusWire::wire('modules')->isInstalled('CaseQtyBottle')) {
			$qtypercase = DplusWire::wire('modules')->get('CaseQtyBottle');
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
	 function get_localhostURL($path) {
		 $config = DplusWire::wire('config');
		 $url = new Url('127.0.0.1');
		 
		 // IF the path provided contains the httpd directory path
		 if (strpos($path, $config->directory_httpd) !== false) {
			 $url->path = $path;
		 } else {
			 $url->path = $config->directory_httpd . $path;
		 }
		 return $url->getUrl();
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

	/**
	 * Creates a hash for a template file
	 * @param  string $pathtofile Path to file from templates/
	 * @return string             Hash for file
	 */
	function hash_templatefile($pathtofile) {
		return hash_file(DplusWire::wire('config')->userAuthHashType, DplusWire::wire('config')->paths->templates.$pathtofile);
	}

	/**
	 * Gets a URL for a template file with its hash
	 * @param  string $pathtofile Path to file from templates/
	 * @return string             URL for templatefile with hash
	 */
	function get_hashedtemplatefileURL($pathtofile) {
		$hash = hash_templatefile($pathtofile);
		return DplusWire::wire('config')->urls->templates."$pathtofile?v=$hash";
	}
	
	/**
	 * Creates a hash for a Module file
	 * @param  string $pathtofile Path to file from modules/
	 * @return string             Hash for file
	 */
	function hash_modulefile($pathtofile) {
		return hash_file(DplusWire::wire('config')->userAuthHashType, DplusWire::wire('config')->paths->siteModules.$pathtofile);
	}
	
	/**
	 * Gets a URL for a module file with its hash
	 * @param  string $pathtofile Path to file from modules/
	 * @return string             URL for templatefile with hash
	 */
	function get_hashedmodulefileURL($pathtofile) {
		$hash = hash_modulefile($pathtofile);
		return DplusWire::wire('config')->urls->siteModules."$pathtofile?v=$hash";
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
