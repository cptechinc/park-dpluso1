<?php
	use Purl\Url;

	// Figure out page request method, then grab needed inputs
	$requestmethod = $input->requestMethod('POST') ? 'post' : 'get';
	$action = $input->$requestmethod->text('action');
	
	// Set up filename and sessionID in case this was made through cURL
	$filename = ($input->$requestmethod->sessionID) ? $input->$requestmethod->text('sessionID') : session_id();
	$sessionID = ($input->$requestmethod->sessionID) ? $input->$requestmethod->text('sessionID') : session_id();
	
	$session->fromredirect = $page->url;
	$session->remove('binr');
	$session->remove('bincm');
	
	/**
	* BINR REDIRECT
	* USES the whseman.log
	*
	*
	*
	*
	* switch ($action) {
	*	case 'initiate-whse':
	*		- Logs into warehouse management creates whsesession record
	*		DBNAME=$config->dplusdbname
	*		LOGIN=$loginID
	*		break;
	*	case 'logout':
	*		- Logs out of warehouse management clears whsesession record
	*		DBNAME=$config->dplusdbname
	*		LOGOUT
	*		break;
	*	case 'inventory-search:
	*		- Requests for $q to be found in the inventory
	*		NOTE $q can be itemID, lotnbr, serialnbr, UPC, Customer ItemID, Vendor ItemID
	*		DBNAME=$config->dplusdbname
	*		INVSEARCH
	*		QUERY=$q
	*		break;
	*	case 'search-item-bins'
	*		- Find other Bins with this item
	*		DBNAME=$config->dplusdbname
	*		BININFO
	*		ITEMID=$itemID
	*		LOTSERIAL=$lotserial **     // NOTE ONLY FOR LOTTED OR SERIALIZED ITEMS
	*		break;
	*	case 'bin-reassign':
	*		- Reassign Found Item from X BIN to Y BIN
	*		DBNAME=$config->dplusdbname
	*		BINR
	*		ITEMID=$itemID
	*		SERIALNBR=$serialnbr        // NOTE ONLY FOR SERIALIZED ITEMS
	*		LOTNBR=$lotnbr              // NOTE ONLY FOR LOTTED ITEMS
	*		QTY=$qty
	*		FROMBIN=$frombin
	*		TOBIN=$tobin
	*		break;
	* }
	*
	**/

	switch ($action) {
		case 'initiate-whse':
			$login = get_loginrecord($sessionID);
			$loginID = $login['loginid'];
			$data = array("DBNAME=$config->dplusdbname", "LOGIN=$loginID");
			break;
		case 'logout':
			$data = array("DBNAME=$config->dplusdbname", 'LOGOUT');
			$session->loc = $config->pages->salesorderpicking;
			break;
		case 'inventory-search':
			$q = strtoupper($input->$requestmethod->text('scan'));
			$data = array("DBNAME=$config->dplusdbname", 'INVSEARCH', "QUERY=$q");
			$url = new Purl\Url($input->$requestmethod->text('page'));
			$url->query->set('scan', $q);
			$session->loc = $url->getUrl();
			break;
		case 'search-item-bins':
			$itemID = $input->$requestmethod->text('itemID');
			$binID = $input->$requestmethod->text('binID');
			$data = array("DBNAME=$config->dplusdbname", 'BININFO', "ITEMID=$itemID");
			$returnurl = new Purl\Url($input->$requestmethod->text('page'));
			$returnurl->query->remove('scan');
			
			if ($input->$requestmethod->serialnbr || $input->$requestmethod->lotnbr) {
				if ($input->$requestmethod->serialnbr) {
					$lotserial = $input->$requestmethod->text('serialnbr');
					$returnurl->query->set('serialnbr', $lotserial);
				} else {
					$lotserial = $input->$requestmethod->text('lotnbr');
					$returnurl->query->set('lotnbr', $lotserial);
				}
				$data[] = "LOTSERIAL=$lotserial";
			} else {
				$returnurl->query->set('itemID', $itemID);
			}
			
			if (!empty($binID)) {
				$returnurl->query->set('binID', $binID);
			}
			$session->loc = $returnurl->getUrl();
			break;
		case 'bin-reassign':
			$itemID = $input->$requestmethod->text('itemID');
			$frombin = $input->$requestmethod->text('from-bin');
			$qty = $input->$requestmethod->text('qty');
			$tobin = $input->$requestmethod->text('to-bin');
			$data = array("DBNAME=$config->dplusdbname", 'BINR', "ITEMID=$itemID");
			
			if ($input->$requestmethod->serialnbr) {
				$serialnbr = $input->$requestmethod->text('serialnbr');
				$data[] = "SERIALNBR=$serialnbr";
			}
			if ($input->$requestmethod->lotnbr) {
				$lotnbr = $input->$requestmethod->text('lotnbr');
				$data[] = "LOTNBR=$lotnbr";
			}
			$data[] = "QTY=$qty";
			$data[] = "FROMBIN=$frombin";
			$data[] = "TOBIN=$tobin";
			$url = new Purl\Url($input->$requestmethod->text('page'));
			
			if ($url->query->has('tobin')) {
				$url->query->set('tobin', $tobin);
			} elseif ($url->query->has('frombin')) {
				$url->query->set('frombin', $frombin);
			}
			$session->loc = $input->$requestmethod->text('page');
			$session->binr = 'true';
			break;
		case 'move-bin-contents';
			$frombin = $input->$requestmethod->text('from-bin');
			$tobin = $input->$requestmethod->text('to-bin');
			$data = array("DBNAME=$config->dplusdbname", 'MOVEBIN', "FROMBIN=$frombin", "TOBIN=$tobin");
			$session->loc = $input->$requestmethod->text('page');
			$session->bincm = json_encode(array('tobin' => $tobin, 'frombin' => $frombin));
			break;
	}
	
	write_dplusfile($data, $filename);
	curl_redir("127.0.0.1/cgi-bin/".$config->cgis['whse']."?fname=$filename");
	if (!empty($session->get('loc'))) {
		header("Location: $session->loc");
	}
	exit;
