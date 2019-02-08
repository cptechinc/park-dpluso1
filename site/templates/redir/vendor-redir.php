<?php
	// Figure out page request method, then grab needed inputs
	$requestmethod = $input->requestMethod('POST') ? 'post' : 'get';
	$action = $input->$requestmethod->text('action');

	// Set up filename and sessionID in case this was made through cURL
	$filename = ($input->$requestmethod->sessionID) ? $input->$requestmethod->text('sessionID') : session_id();
	$sessionID = ($input->$requestmethod->sessionID) ? $input->$requestmethod->text('sessionID') : session_id();

	$session->fromredirect = $page->url;
	$vendorID = $input->$requestmethod->text('vendorID');

	/**
	* VENDOR REDIRECT
	* @param string $action
	*
	*
	*
	* switch ($action) {
	* 	case 'vi-buttons': 760p
	* 		- Loads the Permissioned VI functions
	* 		DBNAME=$config->dplusdbname
	*		VIBUTTONS
	*		break;
	*	case 'vi-vendor': 759p  //AUTO CALLS vi-buttons and vi-shipfromlist
	*		- Loads the VI Vendor info for the Vendor page
	*		DBNAME=$config->dplusdbname
	*		VIVENDOR
	*		VENDID=$vendorID
	* 		break;
	* 	case 'vi-shipfrom-list'
	* 		- Loads the Vendor Shipfroms
	* 		DBNAME=$config->dplusdbname
	*		VISHIPFROMLIST
	*		VENDID=$vendorID
	* 		break;
	*	case 'vi-payments'
	*		- Loads the Vendor Payments
	* 		DBNAME=$config->dplusdbname
	*		VIPAYMENT n2zz764p
	*		VENDID=$vendorID
	* 		break;
	*	case 'vi-shipfrom'
	*		- Loads the Vendor Shipfrom Info
	* 		DBNAME=$config->dplusdbname
	*		VISHIPFROMINFO n2zz761p
	*		VENDID=$vendorID
	*		SHIPID=
	* 		break;
	*	case 'vi-purchase-history'
	*		- Loads the Vendor Purchase History
	* 		DBNAME=$config->dplusdbname
	*		VIPURCHHIST n2zz766p
	*		VENDID=$vendorID
	*		SHIPID=
	*		DATE=
	* 		break;
	*	case 'vi-purchaseorder'
	*		- Loads the Vendor Purchase Orders Screen
	* 		DBNAME=$config->dplusdbname
	*		VIPURCHORDR n2zz767p
	*		VENDID=$vendorID
	*		SHIPID=
	* 		break;
	*	case 'vi-contact'
	*		- Loads the Vendor Contact Info
	* 		DBNAME=$config->dplusdbname
	*		VICONTACT n2zz768p
	*		VENDID=$vendorID
	*		SHIPID=
	* 		break;
	*	case 'vi-costing'
	*		- Loads the Vendor Cost for an Item
	* 		DBNAME=$config->dplusdbname
	*		VICOST n2zz770p
	*		VENDID=$vendorID
	*		ITEMID=
	* 		break;
	*	case 'vi-unreleased'
	*		- Loads the Vendor Unreleased Purchase Orders
	* 		DBNAME=$config->dplusdbname
	*		VIUNRELEASED n2zz772p
	*		VENDID=$vendorID
	*		SHIPID=
	* 		break;
	*	case 'vi-uninvoiced'
	*		- Loads the Vendor Uninvoiced Purchase Orders
	* 		DBNAME=$config->dplusdbname
	*		VIUNINVOICED n2zz773p
	*		VENDID=$vendorID
	* 		break;
	* 	case 'vi-open-invoices'
	* 		- Loads the Vendor Open Invoices
	* 		DBNAME=$config->dplusdbname
	*		VIOPENINV n2zz765p
	*		VENDID=$vendorID
	* 		break;
	* 	case 'vi-24monthsummary'
	* 		- Loads the Vendor 24-month Summary
	* 		DBNAME=$config->dplusdbname
	*		VIMONTHSUM n2zz774p
	*		VENDID=$vendorID
	* 		break;
	* 	case 'vi-notes'
	* 		- Loads the Vendor Notes
	* 		DBNAME=$config->dplusdbname
	*		VINOTES
	*		VENDID=$vendorID
	*		SHIPID=
	* 		break;
	* 	case 'vi-docview'
	* 		- Loads the Vendor Documents
	* 		DBNAME=$config->dplusdbname
	*		DOCVIEW n2zz735p
	*		FLD1CO=VI
	*		FLD1DATA=$vendorID
	* 		break;
	* }
	*
	**/


	switch ($action) {
		case 'vi-buttons': //NOT USED WILL BE AUTOCALLED BY vend-vendor
			$data = array("DBNAME=$config->dplusdbname", 'VIBUTTONS');
			break;
		case 'vi-vendor':
			$data = array("DBNAME=$config->dplusdbname", 'VIVENDOR', "VENDID=$vendorID");
			$session->loc = $config->pages->vendorinfo.urlencode($vendorID)."/";
			break;
		case 'vi-shipfrom-list':
			$data = array("DBNAME=$config->dplusdbname", "VISHIPFROMLIST=$vendorID");
			break;
		case 'vi-shipfrom':
			$shipfromID = $input->get->text('shipfromID');
			$data = array("DBNAME=$config->dplusdbname", 'VISHIPFROMINFO', "VENDID=$vendorID", "SHIPID=$shipfromID");
			// USE THIS for cases where buttons will be grabbed twice
			// if (!empty($input->get->text('shipfromID'))) {
			// 	$data['SHIPID'] = $input->get->text('shipfromID');
			// }
			$session->loc = $config->pages->vendorinfo.urlencode($vendorID)."/shipfrom-".urlencode($shipfromID);
			break;
		case 'vi-open-invoices':
			$data = array("DBNAME=$config->dplusdbname", 'VIOPENINV', "VENDID=$vendorID");
			break;
		case 'vi-payments':
			$data = array("DBNAME=$config->dplusdbname", 'VIPAYMENT', "VENDID=$vendorID");
			break;
		case 'vi-purchase-history':
			$date = $input->post->text('date');
			$session->date = $date;
			$startdate = date('Ymd', strtotime($date));
			$data = array("DBNAME=$config->dplusdbname", 'VIPURCHHIST', "VENDID=$vendorID", "DATE=$startdate");
			if (!empty($input->post->shipfromID)) {
				$data['SHIPID'] = $input->post->text('shipfromID');
			}
			break;
		case 'vi-purchase-orders':
			$data = array("DBNAME=$config->dplusdbname", 'VIPURCHORDR', "VENDID=$vendorID");
			if (!empty($input->post->shipfromID)) {
				$data['SHIPID'] = $input->post->text('shipfromID');
			}
			break;
		case 'vi-contact':
			$data = array("DBNAME=$config->dplusdbname", 'VICONTACT', "VENDID=$vendorID");
			if (!empty($input->post->shipfromID)) {
				$data['SHIPID'] = $input->post->text('shipfromID');
			}
			break;
		case 'vi-notes':
			$data = array("DBNAME=$config->dplusdbname", 'VINOTES', "VENDID=$vendorID");
			if (!empty($input->post->shipfromID)) {
				$data['SHIPID'] = $input->post->text('shipfromID');
			}
			break;
		case 'vi-costing':
			$itemID = $input->get->text('itemID');
			$data = array("DBNAME=$config->dplusdbname", 'VICOST', "VENDID=$vendorID", "ITEMID=$itemID");
			break;
		case 'vi-unreleased-purchase-orders':
			$data = array("DBNAME=$config->dplusdbname", 'VIUNRELEASED', "VENDID=$vendorID");
			if (!empty($input->post->shipfromID)) {
				$data['SHIPID'] = $input->post->text('shipfromID');
			}
			break;
		case 'vi-uninvoiced':
			$data = array("DBNAME=$config->dplusdbname", 'VIUNINVOICED', "VENDID=$vendorID");
			break;
		case 'vi-24monthsummary':
			$data = array("DBNAME=$config->dplusdbname", 'VIMONTHSUM', "VENDID=$vendorID");
			if (!empty($input->post->shipfromID)) {
				$data['SHIPID'] = $input->post->text('shipfromID');
			}
			break;
		case 'vi-docview':
			$data = array("DBNAME=$config->dplusdbname", 'VIDOCVIEW', "FLD1CD=VI", "FLD1DATA=$vendorID");
			break;
	}

	write_dplusfile($data, $filename);
	curl_redir("127.0.0.1/cgi-bin/".$config->cgis['default']."?fname=$filename");
	if (!empty($session->get('loc')) && !$config->ajax) {
		header("Location: $session->loc");
	}
	exit;
