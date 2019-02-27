<?php
	// Figure out page request method, then grab needed inputs
	$requestmethod = $input->requestMethod('POST') ? 'post' : 'get';
	$action = $input->$requestmethod->text('action');

	// Set up filename and sessionID in case this was made through cURL
	$filename = ($input->$requestmethod->sessionID) ? $input->$requestmethod->text('sessionID') : session_id();
	$sessionID = ($input->$requestmethod->sessionID) ? $input->$requestmethod->text('sessionID') : session_id();

	$session->fromredirect = $page->url;

	/**
	* INVENTORY REDIRECT
	* USES the whseman.log
	*
	*
	*
	*
	* switch ($action) {
	*	case 'inventory-search:
	*		- Requests for $q to be found in the inventory
	*		NOTE $q can be itemID, lotnbr, serialnbr, UPC, Customer ItemID, Vendor ItemID
	*		DBNAME=$config->dplusdbname
	*		INVSEARCH
	*		QUERY=$q
	*		break;
	*	case 'physical-count':
	*		- Sends the # of units found for this item as bin location
	*		DBNAME=$config->dplusdbname
	*		ITEMTAG
	*		ITEMID=$itemID
	*		BIN=$binID
	*		break;
	* }
	*
	**/

	switch ($action) {
		case 'inventory-search':
			$q = strtoupper($input->$requestmethod->text('scan'));
			$binID = $input->$requestmethod->text('binID');
			$data = array("DBNAME=$config->dplusdbname", 'INVSEARCH', "QUERY=$q");
			$url = new Purl\Url($input->$requestmethod->text('page'));
			$url->query->set('scan', $q);
			$url->query->set('binID', $binID);
			$session->loc = $url->getUrl();
			break;
		case 'physical-count':
			$binID = $input->$requestmethod->text('binID');
			$itemID = $input->$requestmethod->text('itemID');
			$imitem = ItemMasterItem::load($itemID);
			$returnurl = new Purl\Url($input->$requestmethod->text('page'));
			$returnurl->query->remove('scan');
			$qty_total = 0;

			if (!empty($input->$requestmethod->serialnbr) | !empty($input->$requestmethod->lotnbr)) {
				if ($input->$requestmethod->serialnbr) {
					$lotserial = $input->$requestmethod->text('serialnbr');
				} elseif ($input->$requestmethod->lotnbr) {
					$lotserial = $input->$requestmethod->text('lotnbr');
				}
				$item = InventorySearchItem::load_from_lotserial(session_id(), $lotserial);
			} else {
				$item = InventorySearchItem::load_from_itemid(session_id(), $itemID);
			}
			$outerpacks = $input->$requestmethod->int('outer-pack-qty');
			$innerpacks = $input->$requestmethod->int('inner-pack-qty');

			$qty_outerpack = $outerpacks * $imitem->outerpackqty;
			$qty_innerpack = $innerpacks * $imitem->innerpackqty;
			$qty_each = $input->$requestmethod->int('each-qty');

			$qty_total = $qty_outerpack + $qty_innerpack + $qty_each;

			$data = array("DBNAME=$config->dplusdbname", "ITEMTAG", "ITEMID=$item->itemid", "BIN=$binID");

			if ($item->is_lotted() || $item->is_serialized()) {
				$data[] = "LOTSERIAL=$item->lotserial";
			}

			$data[] = "QTY=$qty_total";
			$returnurl->query->remove('lotnbr');
			$returnurl->query->remove('serialnbr');
			$returnurl->query->remove('itemID');
			$returnurl->query->remove('itemid');
			$session->loc = $returnurl->getUrl();

			$itemhistory = array('binID' => $binID, 'itemID' => $item->itemid, 'qty' => $qty_total);

			if ($session->physicalcounthistory) {
				$history = json_decode($session->physicalcounthistory, true);
			} else {
				$history = array();
			}
			$history[$binID][$item->itemid] = $itemhistory;
			$session->physicalcounthistory = json_encode($history);
			break;
		case 'bin-inquiry':
			$binID = $input->$requestmethod->text('binID');
			$data = array("DBNAME=$config->dplusdbname", 'BININQUIRY', "BINID=$binID");

			if ($input->$requestmethod->page) {
				$page = $input->$requestmethod->text('page');
			} else {
				$page = $config->pages->inventory_bininquiry;
			}

			$url = new Purl\Url($page);
			$url->query->set('binID', $binID);
			$session->loc = $url->getUrl();
			break;
	}

	write_dplusfile($data, $filename);
	curl_redir("127.0.0.1/cgi-bin/".$config->cgis['whse']."?fname=$filename");
	if (!empty($session->get('loc'))) {
		header("Location: $session->loc");
	}
	exit;
