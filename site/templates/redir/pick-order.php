<?php
	// Figure out page request method, then grab needed inputs
	$requestmethod = $input->requestMethod('POST') ? 'post' : 'get';
	$action = $input->$requestmethod->text('action');

	// Set up filename and sessionID in case this was made through cURL
	$filename = ($input->$requestmethod->sessionID) ? $input->$requestmethod->text('sessionID') : session_id();
	$sessionID = ($input->$requestmethod->sessionID) ? $input->$requestmethod->text('sessionID') : session_id();
		
	$session->fromredirect = $page->url;

	/**
	* PICKING ORDERS REDIRECT
	* USES the whseman.log
	*
	*
	*
	*
	* switch ($action) {
	* 	case 'initiate-whse':
	* 		- Logs into warehouse management creates whsesession record
	*		DBNAME=$config->dplusdbname
	*		LOGIN=$loginID
	*		break;
	*	case 'start-pick':
	*		- Starts PICKING function for session, updates whsesession record
	*		DBNAME=$config->dplusdbname
	*		LOGIN=$loginID
	*		PICKING
	*		break;
	*	case 'start-pick-pack':
	*		- Starts PICK PACK function for session, updates whsesession record
	*		  NOTE Park / U2 Only for now
	*		DBNAME=$config->dplusdbname
	*		LOGIN=$user->loginid
	*		PACKING
	*		break;
	*	case 'logout':
	*		- Logs out of warehouse management clears whsesession record
	*		DBNAME=$config->dplusdbname
	*		LOGOUT
	*		break;
	*	case 'start-order':
	*		- Requests the Order Number to start PICKING / PACKING
	*		DBNAME=$config->dplusdbname
	*		STARTORDER
	*		ORDERNBR=$ordn
	*		break;
	*	case 'select-bin':
	*		- Sets the Starting Bin
	*		DBNAME=$config->dplusdbname
	*		SETBIN=$bin
	*		break;
	*	case 'next-bin':
	*		- Requests the Next Bin to be assigned
	*		DBNAME=$config->dplusdbname
	*		NEXTBIN
	*		break;
	*	case 'add-pallet':
	*		- Requests another Pallet number to be assigned to tthis Order #
	*		DBNAME=$config->dplusdbname
	*		NEWPALLET
	*		break;
	*	case 'set-pallet':
	*		- Requests the pallet number to set to X
	*		DBNAME=$config->dplusdbname
	*		GOTOPALLET=$palletnbr
	*		break;
	*	case 'finish-item':
	*		- Request to finish Item picking
	*		DBNAME=$config->dplusdbname
	*		ACCEPTITEM
	*		ORDERNBR=$ordn
	*		LINENBR=$linenbr
	*		ITEMID=$itemID
	*		ITEMQTY=$totalpicked
	*		break;
	*	case 'accept-item':
	*		- Request to finish Item pick-packing
	*		DBNAME=$config->dplusdbname
	*		ACCEPTITEM
	*		ORDERNBR=$ordn
	*		LINENBR=$linenbr
	*		ITEMID=$itemID
	*		PALLETNBR=$pallet|QTY=$qty  // NOTE 1 LINE FOR EACH PALLET
	*		break;
	*	case 'skip-item':
	*		- Request to skip this item
	*		DBNAME=$config->dplusdbname
	*		SKIPITEM
	*		ORDERNBR=$ordn
	*		LINENBR=$linenbr
	*		break;
	*	case 'finish-order':
	*		// Finish the order
	*		DBNAME=$config->dplusdbname
	*		COMPLETEORDER
	*		ORDERNBR=$ordn
	*		break;
	*	case 'exit-order':
	*		// Leave the order
	*		DBNAME=$config->dplusdbname
	*		STOPORDER
	*		ORDERNBR=$ordn
	*		break;
	*	case 'cancel-order':
	*		// Cancel the order Pick
	*		DBNAME=$config->dplusdbname
	*		CANCELSTART
	*		ORDERNBR=$ordn
	*		break;
	*	case 'remove-order-locks':
	*		// Removes Order Pick Locks
	*		DBNAME=$config->dplusdbname
	*		REFRESHPD
	*		ORDERNBR=$ordn
	*		break;
	* }
	**/

	switch ($action) {
		case 'initiate-whse':
			$login = get_loginrecord($sessionID);
			$loginID = $login['loginid'];
			$data = array("DBNAME=$config->dplusdbname", "LOGIN=$loginID");
			break;
		case 'start-pick':
			$data = array("DBNAME=$config->dplusdbname", 'PICKING');
			break;
		case 'start-pick-pack':
			$data = array("DBNAME=$config->dplusdbname", 'PACKING');
			break;
		case 'logout':
			$data = array("DBNAME=$config->dplusdbname", 'LOGOUT');
			$session->loc = $config->pages->salesorderpicking;
			break;
		case 'start-order':
			$ordn = $input->$requestmethod->text('ordn');
			$url = new Purl\Url($input->$requestmethod->text('page'));
			$data = array("DBNAME=$config->dplusdbname", 'STARTORDER', "ORDERNBR=$ordn");
			$url->query->set('ordn', $ordn);
			$session->loc = $url->getUrl();
			break;
		case 'select-bin':
			$bin = strtoupper($input->$requestmethod->text('bin'));
			$data = array("DBNAME=$config->dplusdbname", "SETBIN=$bin");
			$session->loc = $input->$requestmethod->text('page');
			break;
		case 'next-bin':
			$data = array("DBNAME=$config->dplusdbname", 'NEXTBIN');
			$session->loc = $input->$requestmethod->text('page');
			break;
		case 'add-pallet':
			$data = array("DBNAME=$config->dplusdbname", 'NEWPALLET');
			$session->loc = $input->$requestmethod->text('page');
			break;
		case 'set-pallet':
			$palletnbr = $input->$requestmethod->text('palletnbr');
			$data = array("DBNAME=$config->dplusdbname", "GOTOPALLET=$palletnbr");
			$session->loc = $input->$requestmethod->text('page');
			break;
		case 'finish-item':
			$item = Pick_SalesOrderDetail::load(session_id());
			$totalpicked = $item->get_userpickedtotal();
			$data = array("DBNAME=$config->dplusdbname", 'ACCEPTITEM', "ORDERNBR=$item->ordernbr ", "LINENBR=$item->linenbr", "ITEMID=$item->itemnbr", "ITEMQTY=$totalpicked");
			$session->loc = $input->$requestmethod->text('page');
			break;
		case 'finish-item-pick-pack':
			$item = Pick_SalesOrderDetail::load(session_id());
			$totals = $item->get_userpickedpallettotals();
			$session->sql = $item->get_userpickedpallettotals(true);
			$data = array("DBNAME=$config->dplusdbname", 'ACCEPTITEM', "ORDERNBR=$item->ordernbr ", "LINENBR=$item->linenbr", "ITEMID=$item->itemnbr");
			foreach ($totals as $total) {
				$pallet = str_pad($total['palletnbr'], 4, ' ');
				$qty = str_pad($total['qty'], 10, ' ');
				$data[] = "PALLETNBR=$pallet|QTY=$qty";
			}
			$session->loc = $input->$requestmethod->text('page');
			break;
		case 'skip-item':
			$whsesession = WhseSession::load(session_id());
			$pickitem = Pick_SalesOrderDetail::load(session_id());
			$data = array("DBNAME=$config->dplusdbname", 'SKIPITEM', "ORDERNBR=$pickitem->ordn", "LINENBR=$pickitem->linenbr");
			$session->loc = $input->$requestmethod->text('page');
			break;
		case 'finish-order':
			$whsesession = WhseSession::load(session_id());
			$data = array("DBNAME=$config->dplusdbname", 'COMPLETEORDER', "ORDERNBR=$whsesession->ordn");
			$url = new Purl\Url($input->$requestmethod->text('page'));
			$url->query->remove('ordn');
			$session->loc = $url->getUrl();
			break;
		case 'exit-order':
			$whsesession = WhseSession::load(session_id());
			$data = array("DBNAME=$config->dplusdbname", 'STOPORDER', "ORDERNBR=$whsesession->ordn");
			$url = new Purl\Url($input->$requestmethod->text('page'));
			$url->query->remove('ordn');
			$session->loc = $url->getUrl();
			break;
		case 'cancel-order':
			$whsesession = WhseSession::load(session_id());
			$data = array("DBNAME=$config->dplusdbname", 'CANCELSTART', "ORDERNBR=$whsesession->ordn");
			$session->loc = $input->$requestmethod->text('page');
			break;
		case 'remove-order-locks':
			$ordn = $input->$requestmethod->text('ordn');
			$page = $input->$requestmethod->text('page');
			$data = array("DBNAME=$config->dplusdbname", 'REFRESHPD', "ORDERNBR=$ordn");
			
			if (!empty($page)) {
				$session->loc = $page;
			} else {
				$session->loc = $config->pages->salesorderpicking;
			}
			break;
		case 'add-barcode':
			$barcode = $input->$requestmethod->text('barcode');
			$palletnbr = $input->$requestmethod->int('palletnbr');
			$pickitem = Pick_SalesOrderDetail::load(session_id());
			$pickitem->add_barcode($barcode, $palletnbr);
			$session->sql = $pickitem->add_barcode($barcode, $palletnbr, true);
			$session->loc = $input->$requestmethod->text('page');
			break;
		case 'remove-barcode':
			$barcode = $input->$requestmethod->text('barcode');
			$palletnbr = $input->$requestmethod->text('palletnbr');
			$pickitem = Pick_SalesOrderDetail::load(session_id());
			$pickitem->remove_barcode($barcode, $palletnbr);
			$session->sql = $pickitem->remove_barcode($barcode, $palletnbr, true);
			$session->loc = $input->$requestmethod->text('page');
			break;
	}
	
	write_dplusfile($data, $filename);
	curl_redir("127.0.0.1/cgi-bin/".$config->cgis['whse']."?fname=$filename");
	if (!empty($session->get('loc'))) {
		header("Location: $session->loc");
	}
	exit;
