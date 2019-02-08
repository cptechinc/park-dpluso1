<?php

	$custID = $shipID = '';
	// Figure out page request method, then grab needed inputs
	$requestmethod = $input->requestMethod('POST') ? 'post' : 'get';
	$action = $input->$requestmethod->text('action');

	// Set up filename and sessionID in case this was made through cURL
	$filename = ($input->$requestmethod->sessionID) ? $input->$requestmethod->text('sessionID') : session_id();
	$sessionID = ($input->$requestmethod->sessionID) ? $input->$requestmethod->text('sessionID') : session_id();

	$itemID = $input->$requestmethod->text('itemID');

	/**
	* PRODUCT REDIRECT
	* @param string $action
	*
	*
	*
	* switch ($action) {
	*	case 'item-search':
	*		- Search for Item
	*		DBNAME=$config->dplusdbname
	*		ITNOSRCH=$query
	*		CUSTID=$custID
	*		break;
	*	case 'ii-select':
	*		- Get II page info for item
	*		DBNAME=$config->dplusdbname
	*		IISELECT
	*		ITEMID=$itemID
	*		CUSTID=$custID **OPTIONAL
	*		SHIPID=$shipID **OPTIONAL
	*		break;
	*	case 'item-info':
	*		- Get Item Information
	*		DBNAME=$config->dplusdbname
	*		ITNOSRCH=$query
	*		CUSTID=$custID
	*		break;
	*	case 'get-item-price':
	*		- Load Item Pricing Screen
	*		DBNAME=$config->dplusdbname
	*		IIPRICING
	*		ITEMID=$itemID
	*		CUSTID=$custID
	*		break;
	*	case 'ii-pricing':
	*		- Load Item Pricing Screen
	*		DBNAME=$config->dplusdbname
	*		IIPRICE n2zz725p
	*		ITEMID=$itemID
	*		CUSTID=$custID **OPTIONAL
	*		SHIPID=$shipID **OPTIONAL
	*		break;
	*	case 'ii-costing':
	*		- Load Item Costing Screen
	*		DBNAME=$config->dplusdbname
	*		IICOST n2zz721p
	*		ITEMID=$itemID
	*		break;
	*	case 'ii-purchase-order':
	*		- Load Item Purchase Orders Screen
	*		DBNAME=$config->dplusdbname
	*		IIPURCHORDR n2zz708p
	*		ITEMID=$itemID
	*		break;
	*	case 'ii-quotes':
	*		- Load Item Quotes Screen
	*		DBNAME=$config->dplusdbname
	*		IIQUOTE n2zz716p
	*		ITEMID=$itemID
	*		break;
	*	case 'ii-purchase-history':
	*		- Load Item Purchase History Screen
	*		DBNAME=$config->dplusdbname
	*		IIPURCHHIST n2zz709p
	*		ITEMID=$itemID
	*		break;
	*	case 'ii-where-used':
	*		- Load Item where Used Screen
	*		DBNAME=$config->dplusdbname
	*		IIWHEREUSED n2zz717p
	*		ITEMID=$itemID
	*		break;
	*	case 'ii-kit':
	*		- Load Item Kits Screen
	*		DBNAME=$config->dplusdbname
	*		IIKIT n2zz718p
	*		ITEMID=$itemID
	*		QTYNEEDED=$qty
	*		break;
	*	case 'ii-item-bom':
	*		- Load Item BOM Screen
	*		DBNAME=$config->dplusdbname
	*		IIBOMSINGLE|IIBOMCONS
	*		ITEMID=$itemID
	*		QTYNEEDED=$qty
	*		break;
	*	case 'ii-usage':
	*		- Load Item Usage Screen
	*		DBNAME=$config->dplusdbname
	*		IIUSAGE
	*		ITEMID=$itemID
	*		break;
	*	case 'ii-notes':
	*		- Load Item Notes Screen
	*		DBNAME=$config->dplusdbname
	*		IINOTES
	*		ITEMID=$itemID
	*		break;
	*	case 'ii-misc':
	*		- Load Item Misc Screen
	*		DBNAME=$config->dplusdbname
	*		IIMISC
	*		ITEMID=$itemID
	*		break;
	*	case 'ii-general':
	*		//TODO replace ii-usage, ii-notes, ii-misc
	*		break;
	*	case 'ii-activity':
	*		- Load Item Activity Screen
	*		DBNAME=$config->dplusdbname
	*		IIACTIVITY n2zz711p
	*		ITEMID=$itemID
	*		DATE=$date
	*		break;
	*	case 'ii-requirements':
	*		- Load Item Requirements Screen
	*		DBNAME=$config->dplusdbname
	*		IIREQUIRE n2zz714p
	*		ITEMID=$itemID
	*		WHSE=$whse
	*		REQAVL=REQ|AVL
	*		break;
	*	case 'ii-lot-serial':
	*		- Load Item Lot Serial Screen
	*		DBNAME=$config->dplusdbname
	*		IILOTSER n2zz712p
	*		ITEMID=$itemID
	*		break;
	*	case 'ii-sales-orders':
	*		- Load Item Sales Orders Screen
	*		DBNAME=$config->dplusdbname
	*		IISALESORDR n2zz706p
	*		ITEMID=$itemID
	*		break;
	*	case 'ii-sales-history':
	*		- Load Item Sales history Screen
	*		DBNAME=$config->dplusdbname
	*		IISALESHIST n2zz705p
	*		ITEMID=$itemID
	*		CUSTID=$custID **OPTIONAL
	*		SHIPID=$shipID **OPTIONAL
	*		DATE=$date
	*		break;
	*	case 'ii-stock':
	*		- Load Item Stock Screen
	*		DBNAME=$config->dplusdbname
	*		IISTKBYWHSE n2zz707p
	*		ITEMID=$itemID
	*		break;
	*	case 'ii-substitutes':
	*		- Load Item Substitutes Screen
	*		DBNAME=$config->dplusdbname
	*		IISUB n2zz713p
	*		ITEMID=$itemID
	*		break;
	*	case 'ii-documents':
	*		- Load Item Documents Screen
	*		DBNAME=$config->dplusdbname
	*		DOCVIEW n2zz735p
	*		FLD1CD=IT
	*		FLD1DATA=$itemID
	*		FLD21DESC=$desc
	*		break;
	*	case 'ii-order-documents':
	*		- Load Item Order Documents Screen
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
            $q = strtoupper($input->$requestmethod->text('q'));
			$custID = !empty($input->$requestmethod->custID) ? $input->$requestmethod->text('custID') : $config->defaultweb;
			$data = array("DBNAME=$config->dplusdbname", "ITNOSRCH=$q", "CUSTID=$custID");
            break;
		case 'ii-select':
			if ($session->iidate) { $session->remove('iidate'); }
			$data = array("DBNAME=$config->dplusdbname", 'IISELECT', "ITEMID=$itemID");
			$session->loc = $config->pages->iteminfo."?itemID=".urlencode($itemID);
			$custID = $input->$requestmethod->text('custID');
			$shipID = $input->$requestmethod->text('shipID');
            if ($custID != '') {$data['CUSTID'] = $custID; $session->loc .= "&custID=".urlencode($custID); }
			if ($shipID != '') {$data['SHIPID'] = $shipID; $session->loc .= "&shipID=".urlencode($shipID); }
            break;
        case 'item-info':
            $q = $input->$requestmethod->text('q');
			$custID = !empty($input->$requestmethod->text('custID')) ? $input->$requestmethod->text('custID') : $config->defaultweb;
			$data = array("DBNAME=$config->dplusdbname", "ITNOSRCH=$q", "ITEMID=$itemID", "CUSTID=$custID");
            break;
        case 'get-item-price':
			$custID = !empty($input->$requestmethod->text('custID')) ? $input->$requestmethod->text('custID') : $config->defaultweb;
			$data = array("DBNAME=$config->dplusdbname", 'IIPRICING', "ITEMID=$itemID", "CUSTID=$custID");
            break;
		case 'ii-pricing': //II INFORMATION
			$data = array("DBNAME=$config->dplusdbname", 'IIPRICE', "ITEMID=$itemID");
			$custID = $input->$requestmethod->text('custID');
			$shipID = $input->$requestmethod->text('shipID');
			if (!empty($custID))  {$data['CUSTID'] = $custID; } if (!empty($shipID)) {$data['SHIPID'] = $shipID; }
            break;
		case 'ii-costing':
			$data = array("DBNAME=$config->dplusdbname", 'IICOST', "ITEMID=$itemID");
            break;
		case 'ii-purchase-order':
			$data = array("DBNAME=$config->dplusdbname", 'IIPURCHORDR', "ITEMID=$itemID");
            break;
		case 'ii-quotes':
			$data = array("DBNAME=$config->dplusdbname", 'IIQUOTE', "ITEMID=$itemID");
			$custID = $input->$requestmethod->text('custID');
			if (!empty($custID))  {$data['CUSTID'] = $custID; }
            break;
		case 'ii-purchase-history':
			$data = array("DBNAME=$config->dplusdbname", 'IIPURCHHIST', "ITEMID=$itemID");
            break;
		case 'ii-where-used':
			$data = array("DBNAME=$config->dplusdbname", 'IIWHEREUSED', "ITEMID=$itemID");
            break;
		case 'ii-kit':
			$qty = $input->$requestmethod->text('qty');
			$data = array("DBNAME=$config->dplusdbname", 'IIKIT', "ITEMID=$itemID", "QTYNEEDED=$qty");
            break;
		case 'ii-item-bom':
            $qty = $input->$requestmethod->text('qty');
            $bom = $input->$requestmethod->text('bom');
            if ($bom == 'single') {
				$data = array("DBNAME=$config->dplusdbname", 'IIBOMSINGLE', "ITEMID=$itemID", "QTYNEEDED=$qty");
            } elseif ($bom == 'consolidated') {
				$data = array("DBNAME=$config->dplusdbname", 'IIBOMCONS', "ITEMID=$itemID", "QTYNEEDED=$qty");
            }
            break;
		case 'ii-usage':
			$data = array("DBNAME=$config->dplusdbname", 'IIUSAGE', "ITEMID=$itemID");
            break;
        case 'ii-notes':
			$data = array("DBNAME=$config->dplusdbname", 'IINOTES', "ITEMID=$itemID");
            break;
		case 'ii-misc':
			$data = array("DBNAME=$config->dplusdbname", 'IIMISC', "ITEMID=$itemID");
            break;
		case 'ii-general':
			//TODO replace ii-usage, ii-notes, ii-misc
			break;
		case 'ii-activity':
            $custID = $shipID = $date = '';
			$data = array("DBNAME=$config->dplusdbname", 'IIACTIVITY', "ITEMID=$itemID");
            $date = $input->$requestmethod->text('date');
            if (!empty($date)) {$data['DATE'] = date('Ymd', strtotime($date)); }
            break;
		case 'ii-requirements':
            $whse = $input->$requestmethod->text('whse');
            $screentype = $input->$requestmethod->text('screentype');
            //screen type would be REQ or AVL
			$data = array("DBNAME=$config->dplusdbname", 'IIREQUIRE', "ITEMID=$itemID", "WHSE=$whse", "REQAVL=$screentype");
            break;
		case 'ii-lot-serial':
			$data = array("DBNAME=$config->dplusdbname", 'IILOTSER', "ITEMID=$itemID");
            break;
		case 'ii-sales-orders':
			$data = array("DBNAME=$config->dplusdbname", 'IISALESORDR', "ITEMID=$itemID");
            break;
		case 'ii-sales-history':
            $date = '';
			$data = array("DBNAME=$config->dplusdbname", 'IISALESHIST', "ITEMID=$itemID");
			$custID = $input->$requestmethod->text('custID');
			$shipID = $input->$requestmethod->text('shipID');
			$date = $input->$requestmethod->text('date');
            if (!empty($custID)) {$data['CUSTID'] = $custID; } if (!empty($shipID)) {$data['SHIPID'] = $shipID; }
            if (!empty($date)) { $data['DATE'] = date('Ymd', strtotime($date)); }
            break;
       case 'ii-stock':
			$data = array("DBNAME=$config->dplusdbname", 'IISTKBYWHSE', "ITEMID=$itemID");
            break;
        case 'ii-substitutes':
			$data = array("DBNAME=$config->dplusdbname", 'IISUB', "ITEMID=$itemID");
            break;
		case 'ii-documents':
			$desc = XRefItem::get_itemdescription($itemID);
			$session->sql = XRefItem::get_itemdescription($itemID);
			$data = array("DBNAME=$config->dplusdbname", 'DOCVIEW', "FLD1CD=IT", "FLD1DATA=$itemID", "FLD1DESC=$desc");
            break;
		case 'ii-order-documents':
			$ordn = $input->$requestmethod->text('ordn');
			$type = $input->$requestmethod->text('type');
			$desc = XRefItem::get_itemdescription($itemID);
			$data = array("DBNAME=$config->dplusdbname", 'DOCVIEW', "FLD1CD={$config->documentstoragetypes[$type]}", "FLD1DATA=$ordn", "FLD2CD=IT", "FLD2DATA=$itemID");
            break;
    }

    write_dplusfile($data, $filename);
	curl_redir("127.0.0.1/cgi-bin/".$config->cgis['default']."?fname=$filename");
	if (!empty($session->get('loc')) && !$config->ajax) {
		header("Location: $session->loc");
	}
	exit;
