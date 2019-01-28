<?php

	$custID = $shipID = '';
	// Figure out page request method, then grab needed inputs
	$requestmethod = $input->requestMethod('POST') ? 'post' : 'get';
	$action = $input->$requestmethod->text('action');

	// Set up filename and sessionID in case this was made through cURL
	$filename = ($input->$requestmethod->sessionID) ? $input->$requestmethod->text('sessionID') : session_id();
	$sessionID = ($input->$requestmethod->sessionID) ? $input->$requestmethod->text('sessionID') : session_id();

	/**
	* PRODUCT REDIRECT
	* @param string $action
	*
	*
	*
	* switch ($action) {
	*	case 'item-search':
	*		DBNAME=$config->dplusdbname
	*		ITNOSRCH=$query
	*		CUSTID=$custID
	*		break;
	*	case 'ii-select':
	*		DBNAME=$config->dplusdbname
	*		IISELECT
	*		ITEMID=$itemID
	*		CUSTID=$custID **OPTIONAL
	*		SHIPID=$shipID **OPTIONAL
	*		break;
	*	case 'item-info':
	*		DBNAME=$config->dplusdbname
	*		ITNOSRCH=$query
	*		CUSTID=$custID
	*		break;
	*	case 'get-item-price':
	*		DBNAME=$config->dplusdbname
	*		IIPRICING
	*		ITEMID=$itemID
	*		CUSTID=$custID
	*		break;
	*	case 'ii-pricing':
	*		DBNAME=$config->dplusdbname
	*		IIPRICE n2zz725p
	*		ITEMID=$itemID
	*		CUSTID=$custID **OPTIONAL
	*		SHIPID=$shipID **OPTIONAL
	*		break;
	*	case 'ii-costing':
	*		DBNAME=$config->dplusdbname
	*		IICOST n2zz721p
	*		ITEMID=$itemID
	*		break;
	*	case 'ii-purchase-order':
	*		DBNAME=$config->dplusdbname
	*		IIPURCHORDR n2zz708p
	*		ITEMID=$itemID
	*		break;
	*	case 'ii-quotes':
	*		DBNAME=$config->dplusdbname
	*		IIQUOTE n2zz716p
	*		ITEMID=$itemID
	*		break;
	*	case 'ii-purchase-history':
	*		DBNAME=$config->dplusdbname
	*		IIPURCHHIST n2zz709p
	*		ITEMID=$itemID
	*		break;
	*	case 'ii-where-used':
	*		DBNAME=$config->dplusdbname
	*		IIWHEREUSED n2zz717p
	*		ITEMID=$itemID
	*		break;
	*	case 'ii-kit':
	*		DBNAME=$config->dplusdbname
	*		IIKIT n2zz718p
	*		ITEMID=$itemID
	*		QTYNEEDED=$qty
	*		break;
	*	case 'ii-item-bom':
	*		DBNAME=$config->dplusdbname
	*		IIBOMSINGLE|IIBOMCONS
	*		ITEMID=$itemID
	*		QTYNEEDED=$qty
	*		break;
	*	case 'ii-usage':
	*		DBNAME=$config->dplusdbname
	*		IIUSAGE
	*		ITEMID=$itemID
	*		break;
	*	case 'ii-notes':
	*		DBNAME=$config->dplusdbname
	*		IINOTES
	*		ITEMID=$itemID
	*		break;
	*	case 'ii-misc':
	*		DBNAME=$config->dplusdbname
	*		IIMISC
	*		ITEMID=$itemID
	*		break;
	*	case 'ii-general':
	*		//TODO replace ii-usage, ii-notes, ii-misc
	*		break;
	*	case 'ii-activity':
	*		DBNAME=$config->dplusdbname
	*		IIACTIVITY n2zz711p
	*		ITEMID=$itemID
	*		DATE=$date
	*		break;
	*	case 'ii-requirements':
	*		DBNAME=$config->dplusdbname
	*		IIREQUIRE n2zz714p
	*		ITEMID=$itemID
	*		WHSE=$whse
	*		REQAVL=REQ|AVL
	*		break;
	*	case 'ii-lot-serial':
	*		DBNAME=$config->dplusdbname
	*		IILOTSER n2zz712p
	*		ITEMID=$itemID
	*		break;
	*	case 'ii-sales-orders':
	*		DBNAME=$config->dplusdbname
	*		IISALESORDR n2zz706p
	*		ITEMID=$itemID
	*		break;
	*	case 'ii-sales-history':
	*		DBNAME=$config->dplusdbname
	*		IISALESHIST n2zz705p
	*		ITEMID=$itemID
	*		CUSTID=$custID **OPTIONAL
	*		SHIPID=$shipID **OPTIONAL
	*		DATE=$date
	*		break;
	*	case 'ii-stock':
	*		DBNAME=$config->dplusdbname
	*		IISTKBYWHSE n2zz707p
	*		ITEMID=$itemID
	*		break;
	*	case 'ii-substitutes':
	*		DBNAME=$config->dplusdbname
	*		IISUB n2zz713p
	*		ITEMID=$itemID
	*		break;
	*	case 'ii-documents':
	*		DBNAME=$config->dplusdbname
	*		DOCVIEW n2zz735p
	*		FLD1CD=IT
	*		FLD1DATA=$itemID
	*		FLD21DESC=$desc
	*		break;
	*	case 'ii-uments':
	*		DBNAME=$config->dplusdbname
	*		DOCVIEW
	*		FLD1CD=SO
	*		FLD1DATA=$ordn
	*		FLD2CD=IT
	*		FLD2DATA=$itemID
	*		break;
	* }
	*
	**/


    switch ($action) {
        case 'item-search':
            $q = $input->$requestmethod->text('q');
			$custID = !empty($input->$requestmethod->custID) ? $input->$requestmethod->text('custID') : $config->defaultweb;
			$data = array('DBNAME' => $config->dplusdbname, 'ITNOSRCH' => strtoupper($q), 'CUSTID' => $custID);
            break;
		case 'ii-select':
			if ($session->iidate) { $session->remove('iidate'); }
			$data = array('DBNAME' => $config->dplusdbname, 'IISELECT' => false, 'ITEMID' => $itemID);
			$session->loc = $config->pages->iteminfo."?itemID=".urlencode($itemID);
            if ($input->post->custID) { $custID = $input->post->custID; } else { $custID = $input->get->text('custID'); }
            if ($input->post->shipID) { $shipID = $input->post->shipID; } else { $shipID = $input->get->text('shipID'); }
            if ($custID != '') {$data['CUSTID'] = $custID; $session->loc .= "&custID=".urlencode($custID); }
			if ($shipID != '') {$data['SHIPID'] = $shipID; $session->loc .= "&shipID=".urlencode($shipID); }
            break;
        case 'item-info':
            $q = ($input->post->q ? $input->post->text('q') : $input->get->text('q'));
			$custID = ($input->post->custID ? $input->post->text('custID') : $input->get->text('custID'));
			if (empty($custID)) { $custID == $config->defaultweb; }
			$data = array('DBNAME' => $config->dplusdbname, 'ITNOSRCH' => $q, 'ITEMID' => $itemID, 'CUSTID' => $custID);
            break;
        case 'get-item-price':
			$custID = ($input->post->custID ? $input->post->text('custID') : $input->get->text('custID'));
			if (empty($custID)) { $custID == $config->defaultweb; }
			$data = array('DBNAME' => $config->dplusdbname, 'IIPRICING' => false, 'ITEMID' => $itemID, 'CUSTID' => $custID);
            break;
		case 'ii-pricing': //II INFORMATION
			$data = array('DBNAME' => $config->dplusdbname, 'IIPRICE' => false, 'ITEMID' => $itemID);
			$custID = ($input->post->custID ? $input->post->text('custID') : $input->get->text('custID'));
			$shipID = ($input->post->shipID ? $input->post->text('shipID') : $input->get->text('shipID'));
			if (!empty($custID))  {$data['CUSTID'] = $custID; } if (!empty($shipID)) {$data['SHIPID'] = $shipID; }
            break;
		case 'ii-costing':
			$data = array('DBNAME' => $config->dplusdbname, 'IICOST' => false, 'ITEMID' => $itemID);
            break;
		case 'ii-purchase-order':
			$data = array('DBNAME' => $config->dplusdbname, 'IIPURCHORDR' => false, 'ITEMID' => $itemID);
            break;
		case 'ii-quotes':
			$data = array('DBNAME' => $config->dplusdbname, 'IIQUOTE' => false, 'ITEMID' => $itemID);
			$custID = ($input->post->custID ? $input->post->text('custID') : $input->get->text('custID'));
			if (!empty($custID))  {$data['CUSTID'] = $custID; }
            break;
		case 'ii-purchase-history':
			$data = array('DBNAME' => $config->dplusdbname, 'IIPURCHHIST' => false, 'ITEMID' => $itemID);
            break;
		case 'ii-where-used':
			$data = array('DBNAME' => $config->dplusdbname, 'IIWHEREUSED' => false, 'ITEMID' => $itemID);
            break;
		case 'ii-kit':
			$qty = ($input->post->qty ? $input->post->text('qty') : $input->get->text('qty'));
			$data = array('DBNAME' => $config->dplusdbname, 'IIKIT' => false, 'ITEMID' => $itemID, 'QTYNEEDED' => $qty);
            break;
		case 'ii-item-bom':
            $qty = ($input->post->qty ? $input->post->text('qty') : $input->get->text('qty'));
            $bom = ($input->post->bom ? $input->post->text('bom') : $input->get->text('bom'));
            if ($bom == 'single') {
				$data = array('DBNAME' => $config->dplusdbname, 'IIBOMSINGLE' => false, 'ITEMID' => $itemID, 'QTYNEEDED' => $qty);
            } elseif ($bom == 'consolidated') {
				$data = array('DBNAME' => $config->dplusdbname, 'IIBOMCONS' => false, 'ITEMID' => $itemID, 'QTYNEEDED' => $qty);
            }
            break;
		case 'ii-usage':
			$data = array('DBNAME' => $config->dplusdbname, 'IIUSAGE' => false, 'ITEMID' => $itemID);
            break;
        case 'ii-notes':
			$data = array('DBNAME' => $config->dplusdbname, 'IINOTES' => false, 'ITEMID' => $itemID);
            break;
		case 'ii-misc':
			$data = array('DBNAME' => $config->dplusdbname, 'IIMISC' => false, 'ITEMID' => $itemID);
            break;
		case 'ii-general':
			//TODO replace ii-usage, ii-notes, ii-misc
			break;
		case 'ii-activity':
            $custID = $shipID = $date = '';
			$data = array('DBNAME' => $config->dplusdbname, 'IIACTIVITY' => false, 'ITEMID' => $itemID);
            $date = ($input->post->date ? $input->post->text('date') : $input->get->text('date'));
            if (!empty($date)) {$data['DATE'] = date('Ymd', strtotime($date)); }
            break;
		case 'ii-requirements':
            $whse = ($input->post->whse ? $input->post->text('whse') : $input->get->text('whse'));
            $screentype = ($input->post->screentype ? $input->post->text('screentype') : $input->get->text('screentype'));
            //screen type would be REQ or AVL
			$data = array('DBNAME' => $config->dplusdbname, 'IIREQUIRE' => false, 'ITEMID' => $itemID, 'WHSE' => $whse, 'REQAVL' => $screentype);
            break;
		case 'ii-lot-serial':
			$data = array('DBNAME' => $config->dplusdbname, 'IILOTSER' => false, 'ITEMID' => $itemID);
            break;
		case 'ii-sales-orders':
			$data = array('DBNAME' => $config->dplusdbname, 'IISALESORDR' => false, 'ITEMID' => $itemID);
            break;
		case 'ii-sales-history':
            $date = '';
			$data = array('DBNAME' => $config->dplusdbname, 'IISALESHIST' => false, 'ITEMID' => $itemID);
			$custID = ($input->post->custID ? strtoupper($input->post->text('custID')) : strtoupper($input->get->text('custID')));
			$shipID = ($input->post->shipID ? $input->post->text('shipID') : $input->get->text('shipID'));
			$date = ($input->post->date ? $input->post->text('date') : $input->get->text('date'));
            if (!empty($custID)) {$data['CUSTID'] = $custID; } if (!empty($shipID)) {$data['SHIPID'] = $shipID; }
            if (!empty($date)) { $data['DATE'] = date('Ymd', strtotime($date)); }
            break;
       case 'ii-stock':
			$data = array('DBNAME' => $config->dplusdbname, 'IISTKBYWHSE' => false, 'ITEMID' => $itemID);
            break;
        case 'ii-substitutes':
			$data = array('DBNAME' => $config->dplusdbname, 'IISUB' => false, 'ITEMID' => $itemID);
            break;
		case 'ii-documents':
			$desc = XRefItem::get_itemdescription($itemID);
			$session->sql = XRefItem::get_itemdescription($itemID);
			$data = array('DBNAME' => $config->dplusdbname, 'DOCVIEW' => false, 'FLD1CD' => 'IT', 'FLD1DATA' => $itemID, 'FLD1DESC' => $desc);
            break;
		case 'ii-order-documents':
			$ordn = $input->get->text('ordn');
			$type = $input->get->text('type');
			$desc = XRefItem::get_itemdescription($itemID);
			$data = array('DBNAME' => $config->dplusdbname, 'DOCVIEW' => false, 'FLD1CD' => $config->documentstoragetypes[$type], 'FLD1DATA' => $ordn, 'FLD2CD' => 'IT', 'FLD2DATA' => $itemID);
            break;
    }

    writedplusfile($data, $filename);
	curl_redir("127.0.0.1/cgi-bin/".$config->cgis['default']."?fname=$filename");
	if (!empty($session->get('loc')) && !$config->ajax) {
		header("Location: $session->loc");
	}
	exit;
