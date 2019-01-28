<?php
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
	*	case 'load-cust-orders':
	*		DBNAME=$config->dplusdbname
	*		ORDRHED
	*		CUSTID=$custID
	*		TYPE=O  ** OPEN ORDERS
	*		break;
	*	case 'load-orders'
	*		DBNAME=$config->dplusdbname
	*		REPORDRHED
	*		TYPE=O
	*		break;
	*	case 'get-order-details':
	*		DBNAME=$config->dplusdbname
	*		ORDRDET=$ordn
	*		CUSTID=$custID
	* 		break;
	* 	case 'get-order-tracking':
	*		DBNAME=$config->dplusdbname
	*		ORDTRK=$ordn
	*		CUSTID=$custID
	*		break;
	*	case 'get-order-documents':
	*		DBNAME=$config->dplusdbname
	*		ORDDOCS=$ordn
	*		CUSTID=$custID
	*		break;
	* 	case 'edit-new-order':
	*		DBNAME=$config->dplusdbname
	*		ORDRDET=$ordn
	*		CUSTID=$custID
	*		LOCK
	* 		break;
	* 	case 'update-orderhead'
	* 		DBNAME=$config->dplusdbname
	*		SALESHEAD
	*		ORDERNO=$ordn
	* 		break;
	* 	case 'add-to-order':
	* 		DBNAME=$config->dplusdbname
	* 		SALEDET
	*		ORDERNO=$ordn
	*		ITEMID=$itemID
	*		QTY=$qty
	* 		break;
	* 	case 'add-multiple-items':
	*		DBNAME=$config->dplusdbname
	*		ORDERADDMULTIPLE
	*		ORDERNO=$ordn
	*		ITEMID=$custID   QTY=$qty  ** REPEAT
	*		break;
	*	case 'add-nonstock-item':
	*		DBNAME=$config->dplusdbname
	*		SALEDET
	*		ORDERNO=$ordn
	*		ITEMID=N
	*		QTY=$qty
	*		CUSTID=$custID
	* 		break;
	* 	case 'update-line':
	*		DBNAME=$config->dplusdbname
	*		SALEDET
	*		ORDERNO=$ordn
	*		LINENO=$linenbr
	* 		break;
	* 	case 'remove-line':
	* 		DBNAME=$config->dplusdbname
	*		SALEDET
	*		ORDERNO=$ordn
	*		LINENO=$linenbr
	* 		break;
	*	case 'unlock-order':
	*		DBNAME=$config->dplusdbname
	*		UNLOCK
	*		ORDERNO=$ordn
	* 		break;
	* }
	*
	**/

	switch ($action) {
		case 'load-cust-orders':
			$custID = $input->get->text('custID');
			$data = array('DBNAME' => $config->dplusdbname, 'ORDRHED' => false, 'CUSTID' => $custID, 'TYPE' => 'O');
			$session->{'orders-loaded-for'} = $custID;
			$session->{'orders-updated'} = date('m/d/Y h:i A');
			if ($input->get->shipID) {
				$session->loc = $config->pages->ajax."load/sales-orders/customer/{$input->get->custID}/shipto-{$input->get->shipID}?ordn=".$linkaddon;
			} else {
				$session->loc = $config->pages->ajax."load/sales-orders/customer/{$input->get->custID}/?ordn=".$linkaddon;
			}
			break;
		case 'load-orders':
			$data = array('DBNAME' => $config->dplusdbname, 'REPORDRHED' => false, 'TYPE' => 'O');
			$session->loc = $config->pages->ajax."load/sales-orders/?ordn=".$linkaddon."";
			$session->{'orders-loaded-for'} = $user->loginid;
			$session->{'orders-updated'} = date('m/d/Y h:i A');
			break;
		case 'get-order-edit':
			$ordn = $input->get->text('ordn');
			$custID = SalesOrderHistory::is_saleshistory($ordn) ? SalesOrderHistory::find_custid($ordn) : SalesOrder::find_custid($ordn);
			$data = array('DBNAME' => $config->dplusdbname, 'ORDRDET' => $ordn, 'CUSTID' => $custID);
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
			$data = array('DBNAME' => $config->dplusdbname, 'ORDRDET' => $ordn, 'CUSTID' => $custID);
			$session->loc = "{$config->pages->print}order/?ordn=$ordn";
			break;
		case 'get-order-details':
			$ordn = $input->get->text('ordn');
			$custID = SalesOrderHistory::is_saleshistory($ordn) ? SalesOrderHistory::find_custid($ordn) : SalesOrder::find_custid($ordn);
			$data = array('DBNAME' => $config->dplusdbname, 'ORDRDET' => $ordn, 'CUSTID' => $custID);

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
			$data = array('DBNAME' => $config->dplusdbname, 'ORDRTRK' => $ordn);

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
			$data = array('DBNAME' => $config->dplusdbname, 'ORDDOCS' => $ordn);
			break;
		case 'edit-new-order':
			$ordn = get_createdordn(session_id());
			$custID = SalesOrder::find_custid($ordn);
			$data = array('DBNAME' => $config->dplusdbname, 'ORDRDET' => $ordn, 'CUSTID' => $custID, 'LOCK' => false);
			$session->createdorder = $ordn;
			$session->loc = "{$config->pages->editorder}?ordn=$ordn";
			break;
		case 'update-orderhead':
			$ordn = $input->post->text("ordn");
			$intl = $input->post->text("intl");

			$order = SalesOrderEdit::load(session_id(), $ordn);
			$order->set('shiptoid', $input->post->text('shiptoid'));
			$order->set('custpo', $input->post->text("custpo"));
			$order->set('shipname', $input->post->text("shiptoname"));
			$order->set('shipaddress', $input->post->text("shipto-address"));
			$order->set('shipaddress2', $input->post->text("shipto-address2"));
			$order->set('shipcity', $input->post->text("shipto-city"));
			$order->set('shipstate', $input->post->text("shipto-state"));
			$order->set('shipzip', $input->post->text("shipto-zip"));
			$order->set('contact', $input->post->text('contact'));
			$order->set('phone', $input->post->text("contact-phone"));
			$order->set('extension', $input->post->text("contact-extension"));
			$order->set('faxnbr', $input->post->text("contact-fax"));
			$order->set('email', $input->post->text("contact-email"));
			$order->set('releasenbr', $input->post->text("release-number"));
			$order->set('shipviacd', $input->post->text('shipvia'));
			$order->set('rqstdate', $input->post->text("rqstdate"));
			$order->set('shipcom', $input->post->text("shipcomplete"));
			// $order->set('billname', $input->post->text('cust-name'));
			// $order->set('custname', $input->post->text('cust-name'));
			// $order->set('billaddress', $input->post->text('cust-address'));
			// $order->set('billaddress2', $input->post->text('cust-address2'));
			// $order->set('billcity', $input->post->text('cust-city'));
			// $order->set('billstate', $input->post->text('cust-state'));
			// $order->set('billzip', $input->post->text('cust-zip'));

			if ($intl == 'Y') {
				$order->set('phone', $input->post->text("office-accesscode") . $input->post->text("office-countrycode") . $input->post->text("intl-office"));
				$order->set('extension', $input->post->text("intl-ofice-ext"));
				$order->set('faxnbr', $input->post->text("fax-accesscode") . $input->post->text("fax-countrycode") . $input->post->text("intl-fax"));
			} else {
				$order->set('phone', $input->post->text("contact-phone"));
				$order->set('extension', $input->post->text("contact-extension"));
				$order->set('faxnbr', $input->post->text("contact-fax"));
			}
			$custID = SalesOrder::find_custid($ordn);
			$session->sql = $order->update();

			$order->set('paymenttype', $input->post->text("paytype"));

			if ($order->paymenttype == 'cc') {
				$order->set('cardnumber', $input->post->text("ccno"));
				$order->set('cardexpire', $input->post->text("xpd"));
				$order->set('cardcode', $input->post->text("ccv"));
			}

			$session->sql .= '<br>'. $order->update_payment();
			$data = array('DBNAME' => $config->dplusdbname, 'SALESHEAD' => false, 'ORDERNO' => $ordn, 'CUSTID' => $custID);

			if ($input->post->exitorder) {
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
			$data = array('DBNAME' => $config->dplusdbname, 'SALEDET' => false, 'ORDERNO' => $ordn, 'ITEMID' => $itemID, 'QTY' => "$qty", 'CUSTID' => $custID);
			$session->loc = $input->$requestmethod->page;
			$session->editdetail = true;
			break;
		case 'add-multiple-items':
			$ordn = $input->post->text('ordn');
			$itemids = $input->post->itemID;
			$qtys = $input->post->qty;
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
			$orderdetail->set('vendoritemid', $input->post->text('itemID'));
			$orderdetail->set('vendorid', $input->post->text('vendorID'));
			$orderdetail->set('shipfromid', $input->post->text('shipfromID'));
			$orderdetail->set('vendoritemid', $input->post->text('itemID'));
			$orderdetail->set('desc1', $input->post->text('desc1'));
			$orderdetail->set('desc2', $input->post->text('desc2'));
			$orderdetail->set('qty', $input->post->text('qty'));
			$orderdetail->set('price', $input->post->text('price'));
			$orderdetail->set('cost', $input->post->text('cost'));
			$orderdetail->set('uom', $input->post->text('uofm'));
			$orderdetail->set('nsitemgroup', $input->post->text('nsitemgroup'));
			$orderdetail->set('ponbr', $input->post->text('ponbr'));
			$orderdetail->set('poref', $input->post->text('poref'));
			$orderdetail->set('spcord', 'S');
			$orderdetail->set('date', date('Ymd'));
			$orderdetail->set('time', date('His'));
			$orderdetail->set('sublinenbr', '0');

			$session->sql = $orderdetail->save(true);
			$orderdetail->save();

			$data = array('DBNAME' => $config->dplusdbname, 'SALEDET' => false, 'ORDERNO' => $ordn, 'LINENO' => '0', 'ITEMID' => 'N', 'QTY' => $qty, 'CUSTID' => $custID);

			if ($input->post->page) {
				$session->loc = $input->post->text('page');
			} else {
				$session->loc = $config->pages->edit."order/?ordn=".$ordn;
			}
			$session->editdetail = true;
			break;
		case 'quick-update-line':
			$ordn = $input->post->text('ordn');
			$linenbr = $input->post->text('linenbr');
			$custID = SalesOrder::find_custid($ordn);
			$orderdetail = SalesOrderDetail::load(session_id(), $ordn, $linenbr);
			// $orderdetail->set('whse', $input->post->text('whse'));
			$qty = determine_qty($input, $requestmethod, $orderdetail->itemid); // TODO MAKE IN CART DETAIL
			$orderdetail->set('qty', $qty);
			$orderdetail->set('price', $input->post->text('price'));
			$orderdetail->set('rshipdate', $input->post->text('rqstdate'));
			$session->sql = $orderdetail->update();
			$data = array('DBNAME' => $config->dplusdbname, 'SALEDET' => false, 'ORDERNO' => $ordn, 'LINENO' => $linenbr, 'CUSTID' => $custID);

			if ($input->post->page) {
				$session->loc = $input->post->text('page');
			} else {
				$session->loc = $config->pages->edit."order/?ordn=$ordn";
			}
			$session->editdetail = true;
			break;
		case 'update-line':
			$ordn = $input->post->text('ordn');
			$linenbr = $input->post->text('linenbr');
			$orderdetail = SalesOrderDetail::load(session_id(), $ordn, $linenbr);
			$qty = determine_qty($input, $requestmethod, $orderdetail->itemid); // TODO MAKE IN CART DETAIL
			$orderdetail->set('price', $input->post->text('price'));
			$orderdetail->set('discpct', $input->post->text('discount'));
			$orderdetail->set('qty', $qty);
			$orderdetail->set('rshipdate', $input->post->text('rqstdate'));
			$orderdetail->set('whse', $input->post->text('whse'));
			$orderdetail->set('linenbr', $input->post->text('linenbr'));
			$orderdetail->set('spcord', $input->post->text('specialorder'));
			$orderdetail->set('vendorid', $input->post->text('vendorID'));
			$orderdetail->set('shipfromid', $input->post->text('shipfromID'));
			$orderdetail->set('vendoritemid', $input->post->text('vendoritemID'));
			$orderdetail->set('nsitemgroup', $input->post->text('nsgroup'));
			$orderdetail->set('ponbr', $input->post->text('ponbr'));
			$orderdetail->set('poref', $input->post->text('poref'));
			$orderdetail->set('uom', $input->post->text('uofm'));

			if ($orderdetail->spcord != 'N') {
				$orderdetail->set('desc1', $input->post->text('desc1'));
				$orderdetail->set('desc2', $input->post->text('desc2'));
			}
			$custID = SalesOrder::find_custid($ordn);
			$session->sql = $orderdetail->update();
			$data = array('DBNAME' => $config->dplusdbname, 'SALEDET' => false, 'ORDERNO' => $ordn, 'LINENO' => $linenbr, 'CUSTID' => $custID);

			if ($input->post->page) {
				$session->loc = $input->post->text('page');
			} else {
				$session->loc = $config->pages->edit."order/?ordn=$ordn";
			}
			$session->editdetail = true;
			break;
		case 'remove-line':
			$ordn = $input->post->text('ordn');
			$linenbr = $input->post->text('linenbr');
			$orderdetail = SalesOrderDetail::load(session_id(), $ordn, $linenbr);
			$orderdetail->set('qty', '0');
			$session->sql = $orderdetail->update();
			$session->editdetail = true;
			$custID = SalesOrder::find_custid($ordn);
			$data = array('DBNAME' => $config->dplusdbname, 'SALEDET' => false, 'ORDERNO' => $ordn, 'LINENO' => $linenbr, 'QTY' => '0', 'CUSTID' => $custID);
			if ($input->post->page) {
				$session->loc = $input->post->text('page');
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
			$data = array('DBNAME' => $config->dplusdbname, 'SALEDET' => false, 'ORDERNO' => $ordn, 'LINENO' => $linenbr, 'QTY' => '0', 'CUSTID' => $custID);

			if ($input->post->page) {
				$session->loc = $input->post->text('page');
			} else {
				$session->loc = $config->pages->edit."order/?ordn=".$ordn;
			}
			$session->editdetail = true;
			break;
		case 'unlock-order':
			$ordn = $input->get->text('ordn');
			$data = array('DBNAME' => $config->dplusdbname, 'UNLOCK' => false, 'ORDERNO' => $ordn);
			$session->remove('createdorder');
			$session->loc = $config->pages->confirmorder."?ordn=$ordn";
			break;
		default:
			$data = array('DBNAME' => $config->dplusdbname, 'REPORDRHED' => false, 'TYPE' => 'O');
			$session->loc = $config->pages->ajax."load/orders/salesrep/".urlencode($custID)."/?ordn=".$linkaddon."";
			$session->{'orders-loaded-for'} = $user->loginid;
			$session->{'orders-updated'} = date('m/d/Y h:i A');
			break;
	}

	writedplusfile($data, $filename);
	curl_redir("127.0.0.1/cgi-bin/".$config->cgis['default']."?fname=$filename");
	if (!empty($session->get('loc')) && !$config->ajax) {
		header("Location: $session->loc");
	}
	exit;
