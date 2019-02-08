<?php
	use Dplus\ProcessWire\DplusWire;
	use Dplus\Content\Paginator;
	use Dplus\Dpluso\OrderDisplays\SalesOrderPanel;

	// Figure out page request method, then grab needed inputs
	$requestmethod = $input->requestMethod('POST') ? 'post' : 'get';
	$action = $input->$requestmethod->text('action');

	// Set up filename and sessionID in case this was made through cURL
	$filename = ($input->$requestmethod->sessionID) ? $input->$requestmethod->text('sessionID') : session_id();
	$sessionID = ($input->$requestmethod->sessionID) ? $input->$requestmethod->text('sessionID') : session_id();

	// USED FOR MAINLY ORDER LISTING FUNCTIONS
	$pagenumber = (!empty($input->get->page) ? $input->get->int('page') : 1);
	$sortaddon = (!empty($input->get->orderby) ? '&orderby=' . $input->get->text('orderby') : '');
	$filteraddon = '';

	if ($input->get->filter) {
		$orderpanel = new SalesOrderPanel(session_id(), $page->fullURL, '', '', '');
		$orderpanel->generate_filter($input);

		if (!empty($orderpanel->filters)) {
			$filteraddon = "&filter=filter";
			foreach ($orderpanel->filters as $filter => $value) {
				$filteraddon .= "&$filter=".implode('|', $value);
			}
		}
	}

	$linkaddon = $sortaddon . $filteraddon;
	$session->fromredirect = $page->url;
	$session->remove('order-search');
	$session->remove('panelorigin');
	$session->remove('paneloriginpage');
	$session->filters = $filteraddon;

	/**
	* ORDERS REDIRECT
	* @param string $action
	*
	*
	*
	* switch ($action) {
	*	case 'get-order-details':
	*		- Loads the Sales Order Detail Lines
	*		DBNAME=$config->dplusdbname
	*		ORDRDET=$ordn
	*		CUSTID=$custID
	* 		break;
	* 	case 'get-order-tracking':
	* 		- Loads the tracking Information for the Sales Order
	*		DBNAME=$config->dplusdbname
	*		ORDTRK=$ordn
	*		CUSTID=$custID
	*		break;
	*	case 'get-order-documents':
	*		- Loads the Sales Order Documents
	*		DBNAME=$config->dplusdbname
	*		ORDDOCS=$ordn
	*		CUSTID=$custID
	*		break;
	* 	case 'edit-new-order':
	* 		- Loads the Sales Order to be Edited
	*		DBNAME=$config->dplusdbname
	*		ORDRDET=$ordn
	*		CUSTID=$custID
	*		LOCK
	* 		break;
	* 	case 'update-orderhead'
	* 		- Updates the Sales Order Head
	* 		DBNAME=$config->dplusdbname
	*		SALESHEAD
	*		ORDERNO=$ordn
	* 		break;
	* 	case 'add-to-order':
	* 		- Adds an Item to the Sales Order
	* 		DBNAME=$config->dplusdbname
	* 		SALEDET
	*		ORDERNO=$ordn
	*		ITEMID=$itemID
	*		QTY=$qty
	* 		break;
	* 	case 'add-multiple-items':
	* 		- Adds multiple items to the Sales Order
	*		DBNAME=$config->dplusdbname
	*		ORDERADDMULTIPLE
	*		ORDERNO=$ordn
	*		ITEMID=$custID   QTY=$qty  ** REPEAT
	*		break;
	*	case 'add-nonstock-item':
	*		- Adds Nonstock Item
	*		DBNAME=$config->dplusdbname
	*		SALEDET
	*		ORDERNO=$ordn
	*		ITEMID=N
	*		QTY=$qty
	*		CUSTID=$custID
	* 		break;
	* 	case 'update-line':
	* 		- Updates Detail Line
	*		DBNAME=$config->dplusdbname
	*		SALEDET
	*		ORDERNO=$ordn
	*		LINENO=$linenbr
	* 		break;
	* 	case 'remove-line':
	* 		- Removes Detail Line
	* 		DBNAME=$config->dplusdbname
	*		SALEDET
	*		ORDERNO=$ordn
	*		LINENO=$linenbr
	* 		break;
	*	case 'unlock-order':
	*		- Unlocks Sales Order
	*		DBNAME=$config->dplusdbname
	*		UNLOCK
	*		ORDERNO=$ordn
	* 		break;
	* }
	*
	**/

	switch ($action) {
		case 'get-order-edit':
			$ordn = $input->get->text('ordn');
			$custID = SalesOrderHistory::is_saleshistory($ordn) ? SalesOrderHistory::find_custid($ordn) : SalesOrder::find_custid($ordn);
			$data = array("DBNAME=$config->dplusdbname", "ORDRDET=$ordn", "CUSTID=$custID");
			//if ($input->get->edit) {
				$data['LOCK'] = false;
			//}
			$session->loc = "{$config->pages->editorder}?ordn=$ordn";
			if ($input->get->orderorigin) {
				$session->panelorigin = 'orders';
				$session->paneloriginpage = $input->get->text('orderorigin');
				if ($input->get->custID) {
					$session->panelcustomer = $input->get->text('custID');
				}
			}
			break;
		case 'get-order-print':
			$ordn = $input->get->text('ordn');
			$custID = SalesOrderHistory::is_saleshistory($ordn) ? SalesOrderHistory::find_custid($ordn) : SalesOrder::find_custid($ordn);
			$data = array("DBNAME=$config->dplusdbname", "ORDRDET=$ordn", "CUSTID=$custID");
			$session->loc = "{$config->pages->print}order/?ordn=$ordn";
			break;
		case 'get-order-details':
			$ordn = $input->get->text('ordn');
			$custID = SalesOrderHistory::is_saleshistory($ordn) ? SalesOrderHistory::find_custid($ordn) : SalesOrder::find_custid($ordn);
			$data = array("DBNAME=$config->dplusdbname", "ORDRDET=$ordn", "CUSTID=$custID");

			if ($input->$requestmethod->page) {
				$session->loc = $input->$requestmethod->text('page');
			} else {
				$url = new Purl\Url($config->pages->ajaxload);
				$insertafter = ($input->get->text('type') == 'history') ? 'sales-history' : 'sales-orders';
				$url->path->add($insertafter);

				if ($input->get->custID) {
					$url->path->add('customer');
					$insertafter = $input->get->text('custID');
					$url->path->add($insertafter);

					if ($input->get->shipID) {
						$insertafter = "shipto-{$input->get->text('shipID')}";
						$url->path->add($insertafter);
					}
				}
				$url->query = "ordn=$ordn$linkaddon";
				Paginator::paginate_purl($url, $pagenumber, $insertafter);
				$session->loc = $url->getUrl();
			}

			break;
		case 'get-order-tracking':
			$ordn = $input->get->text('ordn');
			$data = array("DBNAME=$config->dplusdbname", "ORDRTRK=$ordn");

			if ($input->get->ajax) {
				$session->loc = $config->pages->ajax."load/order/tracking/?ordn=".$ordn;
			} elseif ($input->get->page == 'edit') {
				$session->loc = $config->pages->ajax.'load/sales-orders/tracking/?ordn='.$ordn;
			} else {
				$url = new Purl\Url($config->pages->ajaxload);
				$insertafter = ($input->get->text('type') == 'history') ? 'sales-history' : 'sales-orders';
				$url->path->add($insertafter);

				if ($input->get->custID) {
					$url->path->add('customer');
					$insertafter = $input->get->text('custID');
					$url->path->add($insertafter);

					if ($input->get->shipID) {
						$insertafter = "shipto-{$input->get->text('shipID')}";
						$url->path->add($insertafter);
					}
				}
				$url->query = "ordn=$ordn$linkaddon";
				$url->query->set('show', 'tracking');
				Paginator::paginate_purl($url, $pagenumber, $insertafter);
				$session->loc = $url->getUrl();
			}
			break;
		case 'get-order-documents':
			$ordn = $input->get->text('ordn');

			if ($input->get->page == 'edit') {
				$session->loc = $config->pages->ajax.'load/order/documents/?ordn='.$ordn;
			} else {
				$url = new Purl\Url($config->pages->ajaxload);
				$insertafter = ($input->get->text('type') == 'history') ? 'sales-history' : 'sales-orders';
				$url->path->add($insertafter);

				if ($input->get->custID) { // If looking at customer orders
					$url->path->add('customer');
					$insertafter = $input->get->text('custID');
					$url->path->add($insertafter);

					if ($input->get->shipID) { // If looking at customer shipto orders
						$insertafter = "shipto-{$input->get->text('shipID')}";
						$url->path->add($insertafter);
					}
				}
				$url->query = "ordn=$ordn$linkaddon";
				$url->query->set('show', 'documents');

				if ($input->get->itemdoc) {
					$url->query->set('itemdoc', $input->get->text('itemdoc'));
				}
				Paginator::paginate_purl($url, $pagenumber, $insertafter);
				$session->loc = $url->getUrl();
			}
			$data = array("DBNAME=$config->dplusdbname", "ORDDOCS=$ordn");
			break;
		case 'edit-new-order':
			$ordn = get_createdordn(session_id());
			$custID = SalesOrder::find_custid($ordn);
			$data = array("DBNAME=$config->dplusdbname", "ORDRDET=$ordn", "CUSTID=$custID", 'LOCK');
			$session->createdorder = $ordn;
			$session->loc = "{$config->pages->editorder}?ordn=$ordn";
			break;
		case 'update-orderhead':
			$ordn = $input->$requestmethod->text("ordn");
			$intl = $input->$requestmethod->text("intl");

			$order = SalesOrderEdit::load(session_id(), $ordn);
			$order->set('shiptoid', $input->$requestmethod->text('shiptoid'));
			$order->set('custpo', $input->$requestmethod->text("custpo"));
			$order->set('shipname', $input->$requestmethod->text("shiptoname"));
			$order->set('shipaddress', $input->$requestmethod->text("shipto-address"));
			$order->set('shipaddress2', $input->$requestmethod->text("shipto-address2"));
			$order->set('shipcity', $input->$requestmethod->text("shipto-city"));
			$order->set('shipstate', $input->$requestmethod->text("shipto-state"));
			$order->set('shipzip', $input->$requestmethod->text("shipto-zip"));
			$order->set('contact', $input->$requestmethod->text('contact'));
			$order->set('phone', $input->$requestmethod->text("contact-phone"));
			$order->set('extension', $input->$requestmethod->text("contact-extension"));
			$order->set('faxnbr', $input->$requestmethod->text("contact-fax"));
			$order->set('email', $input->$requestmethod->text("contact-email"));
			$order->set('releasenbr', $input->$requestmethod->text("release-number"));
			$order->set('shipviacd', $input->$requestmethod->text('shipvia'));
			$order->set('rqstdate', $input->$requestmethod->text("rqstdate"));
			$order->set('shipcom', $input->$requestmethod->text("shipcomplete"));
			// $order->set('billname', $input->$requestmethod->text('cust-name'));
			// $order->set('custname', $input->$requestmethod->text('cust-name'));
			// $order->set('billaddress', $input->$requestmethod->text('cust-address'));
			// $order->set('billaddress2', $input->$requestmethod->text('cust-address2'));
			// $order->set('billcity', $input->$requestmethod->text('cust-city'));
			// $order->set('billstate', $input->$requestmethod->text('cust-state'));
			// $order->set('billzip', $input->$requestmethod->text('cust-zip'));

			if ($intl == 'Y') {
				$order->set('phone', $input->$requestmethod->text("office-accesscode") . $input->$requestmethod->text("office-countrycode") . $input->$requestmethod->text("intl-office"));
				$order->set('extension', $input->$requestmethod->text("intl-ofice-ext"));
				$order->set('faxnbr', $input->$requestmethod->text("fax-accesscode") . $input->$requestmethod->text("fax-countrycode") . $input->$requestmethod->text("intl-fax"));
			} else {
				$order->set('phone', $input->$requestmethod->text("contact-phone"));
				$order->set('extension', $input->$requestmethod->text("contact-extension"));
				$order->set('faxnbr', $input->$requestmethod->text("contact-fax"));
			}
			$custID = SalesOrder::find_custid($ordn);
			$session->sql = $order->update();

			$order->set('paymenttype', $input->$requestmethod->text("paytype"));

			if ($order->paymenttype == 'cc') {
				$order->set('cardnumber', $input->$requestmethod->text("ccno"));
				$order->set('cardexpire', $input->$requestmethod->text("xpd"));
				$order->set('cardcode', $input->$requestmethod->text("ccv"));
			}

			$session->sql .= '<br>'. $order->update_payment();
			$data = array("DBNAME=$config->dplusdbname", 'SALESHEAD', "ORDERNO=$ordn", "CUSTID=$custID");

			if ($input->$requestmethod->exitorder) {
				$session->loc = $config->pages->orders."redir/?action=unlock-order&ordn=$ordn";
				$data['UNLOCK'] = false;
				$session->remove('createdorder');
			} else {
				$session->loc = $config->pages->editorder."?ordn=$ordn";
			}
			break;
		case 'add-to-order':
			$itemID = $input->$requestmethod->text('itemID');
			$qty = determine_qty($input, $requestmethod, $itemID);
			$ordn = $input->$requestmethod->text('ordn');
			$custID = SalesOrder::find_custid($ordn);
			$data = array("DBNAME=$config->dplusdbname", 'SALEDET', "ORDERNO=$ordn", "ITEMID=$itemID", "QTY=$qty", "CUSTID=$custID");
			$session->loc = $input->$requestmethod->page;
			$session->editdetail = true;
			break;
		case 'add-multiple-items':
			$ordn = $input->$requestmethod->text('ordn');
			$itemids = $input->$requestmethod->itemID;
			$qtys = $input->$requestmethod->qty;
			$data = array("DBNAME=$config->dplusdbname", 'ORDERADDMULTIPLE', "ORDERNO=$ordn");
			$data = writedataformultitems($data, $itemids, $qtys);
            $session->loc = $config->pages->edit."order/?ordn=".$ordn;
			$session->editdetail = true;
			break;
		case 'add-nonstock-item': // FIX
			$ordn = $input->$requestmethod->text('ordn');
			$qty = $input->$requestmethod->text('qty');
			$orderdetail = new SalesOrderDetail();
			$orderdetail->set('sessionid', session_id());
			$orderdetail->set('linenbr', '0');
			$orderdetail->set('recno', '0');
			$orderdetail->set('orderno', $ordn);
			$orderdetail->set('itemid', 'N');
			$orderdetail->set('vendoritemid', $input->$requestmethod->text('itemID'));
			$orderdetail->set('vendorid', $input->$requestmethod->text('vendorID'));
			$orderdetail->set('shipfromid', $input->$requestmethod->text('shipfromID'));
			$orderdetail->set('vendoritemid', $input->$requestmethod->text('itemID'));
			$orderdetail->set('desc1', $input->$requestmethod->text('desc1'));
			$orderdetail->set('desc2', $input->$requestmethod->text('desc2'));
			$orderdetail->set('qty', $input->$requestmethod->text('qty'));
			$orderdetail->set('price', $input->$requestmethod->text('price'));
			$orderdetail->set('cost', $input->$requestmethod->text('cost'));
			$orderdetail->set('uom', $input->$requestmethod->text('uofm'));
			$orderdetail->set('nsitemgroup', $input->$requestmethod->text('nsitemgroup'));
			$orderdetail->set('ponbr', $input->$requestmethod->text('ponbr'));
			$orderdetail->set('poref', $input->$requestmethod->text('poref'));
			$orderdetail->set('spcord', 'S');
			$orderdetail->set('date', date('Ymd'));
			$orderdetail->set('time', date('His'));
			$orderdetail->set('sublinenbr', '0');

			$session->sql = $orderdetail->save(true);
			$orderdetail->save();

			$data = array("DBNAME=$config->dplusdbname", 'SALEDET', "ORDERNO=$ordn", "LINENO=0", "ITEMID=N", "QTY=$qty", "CUSTID=$custID");

			if ($input->$requestmethod->page) {
				$session->loc = $input->$requestmethod->text('page');
			} else {
				$session->loc = $config->pages->edit."order/?ordn=".$ordn;
			}
			$session->editdetail = true;
			break;
		case 'quick-update-line':
			$ordn = $input->$requestmethod->text('ordn');
			$linenbr = $input->$requestmethod->text('linenbr');
			$custID = SalesOrder::find_custid($ordn);
			$orderdetail = SalesOrderDetail::load(session_id(), $ordn, $linenbr);
			// $orderdetail->set('whse', $input->$requestmethod->text('whse'));
			$qty = determine_qty($input, $requestmethod, $orderdetail->itemid); // TODO MAKE IN CART DETAIL
			$orderdetail->set('qty', $qty);
			$orderdetail->set('price', $input->$requestmethod->text('price'));
			$orderdetail->set('rshipdate', $input->$requestmethod->text('rqstdate'));
			$session->sql = $orderdetail->update();
			$data = array("DBNAME=$config->dplusdbname", 'SALEDET', "ORDERNO=$ordn", "LINENO=$linenbr", "CUSTID=$custID");

			if ($input->$requestmethod->page) {
				$session->loc = $input->$requestmethod->text('page');
			} else {
				$session->loc = $config->pages->edit."order/?ordn=$ordn";
			}
			$session->editdetail = true;
			break;
		case 'update-line':
			$ordn = $input->$requestmethod->text('ordn');
			$linenbr = $input->$requestmethod->text('linenbr');
			$orderdetail = SalesOrderDetail::load(session_id(), $ordn, $linenbr);
			$qty = determine_qty($input, $requestmethod, $orderdetail->itemid); // TODO MAKE IN CART DETAIL
			$orderdetail->set('price', $input->$requestmethod->text('price'));
			$orderdetail->set('discpct', $input->$requestmethod->text('discount'));
			$orderdetail->set('qty', $qty);
			$orderdetail->set('rshipdate', $input->$requestmethod->text('rqstdate'));
			$orderdetail->set('whse', $input->$requestmethod->text('whse'));
			$orderdetail->set('linenbr', $input->$requestmethod->text('linenbr'));
			$orderdetail->set('spcord', $input->$requestmethod->text('specialorder'));
			$orderdetail->set('vendorid', $input->$requestmethod->text('vendorID'));
			$orderdetail->set('shipfromid', $input->$requestmethod->text('shipfromID'));
			$orderdetail->set('vendoritemid', $input->$requestmethod->text('vendoritemID'));
			$orderdetail->set('nsitemgroup', $input->$requestmethod->text('nsgroup'));
			$orderdetail->set('ponbr', $input->$requestmethod->text('ponbr'));
			$orderdetail->set('poref', $input->$requestmethod->text('poref'));
			$orderdetail->set('uom', $input->$requestmethod->text('uofm'));

			if ($orderdetail->spcord != 'N') {
				$orderdetail->set('desc1', $input->$requestmethod->text('desc1'));
				$orderdetail->set('desc2', $input->$requestmethod->text('desc2'));
			}
			$custID = SalesOrder::find_custid($ordn);
			$session->sql = $orderdetail->update();
			$data = array("DBNAME=$config->dplusdbname", 'SALEDET', "ORDERNO=$ordn", "LINENO=$linenbr", "CUSTID=$custID");

			if ($input->$requestmethod->page) {
				$session->loc = $input->$requestmethod->text('page');
			} else {
				$session->loc = $config->pages->edit."order/?ordn=$ordn";
			}
			$session->editdetail = true;
			break;
		case 'remove-line':
			$ordn = $input->$requestmethod->text('ordn');
			$linenbr = $input->$requestmethod->text('linenbr');
			$orderdetail = SalesOrderDetail::load(session_id(), $ordn, $linenbr);
			$orderdetail->set('qty', '0');
			$session->sql = $orderdetail->update();
			$session->editdetail = true;
			$custID = SalesOrder::find_custid($ordn);
			$data = array("DBNAME=$config->dplusdbname", 'SALEDET', "ORDERNO=$ordn", "LINENO=$linenbr", "QTY=0", "CUSTID=$custID");
			if ($input->$requestmethod->page) {
				$session->loc = $input->$requestmethod->text('page');
			} else {
				$session->loc = $config->pages->edit."order/?ordn=".$ordn;
			}
			break;
		case 'remove-line-get':
			$ordn = $input->get->text('ordn');
			$linenbr = $input->get->text('linenbr');
			$orderdetail = SalesOrderDetail::load(session_id(), $ordn, $linenbr);
			$orderdetail->set('qty', '0');
			$session->sql = $orderdetail->update();
			$custID = SalesOrder::find_custid($ordn);
			$data = array("DBNAME=$config->dplusdbname", 'SALEDET', "ORDERNO=$ordn", "LINENO=$linenbr", "QTY=0", "CUSTID=$custID");

			if ($input->$requestmethod->page) {
				$session->loc = $input->$requestmethod->text('page');
			} else {
				$session->loc = $config->pages->edit."order/?ordn=".$ordn;
			}
			$session->editdetail = true;
			break;
		case 'unlock-order':
			$ordn = $input->get->text('ordn');
			$data = array("DBNAME=$config->dplusdbname", 'UNLOCK', "ORDERNO=$ordn");
			$session->remove('createdorder');
			$session->loc = $config->pages->confirmorder."?ordn=$ordn";
			break;
		default:
			$data = array("DBNAME=$config->dplusdbname", 'REPORDRHED', "TYPE=O");
			$session->loc = $config->pages->ajax."load/orders/salesrep/".urlencode($custID)."/?ordn=".$linkaddon."";
			$session->{'orders-loaded-for'} = $user->loginid;
			$session->{'orders-updated'} = date('m/d/Y h:i A');
			break;
	}

	write_dplusfile($data, $filename);
	curl_redir("127.0.0.1/cgi-bin/".$config->cgis['default']."?fname=$filename");
	if (!empty($session->get('loc')) && !$config->ajax) {
		header("Location: $session->loc");
	}
	exit;
