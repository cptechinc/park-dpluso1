<?php
	use Dplus\ProcessWire\DplusWire;
	
	// Figure out page request method, then grab needed inputs
	$requestmethod = $input->requestMethod('POST') ? 'post' : 'get';
	$action = $input->$requestmethod->text('action');
	
	// Set up filename and sessionID in case this was made through cURL
	$filename = ($input->$requestmethod->sessionID) ? $input->$requestmethod->text('sessionID') : session_id();
	$sessionID = ($input->$requestmethod->sessionID) ? $input->$requestmethod->text('sessionID') : session_id();
	
	// Set up custID & shipID for requests
	$custID = $input->$requestmethod->text('custID');
	$shipID = $input->$requestmethod->text('shipID');
	
	$session->fromredirect = $page->url;
	
	/**
	* CART REDIRECT
	* @param string $action
	*
	* switch ($action) {
	*	case 'add-to-cart':
	*		- Adds item to the cart for customer
	*		DBNAME=$config->dplusdbname
	*		CARTDET
	*		ITEMID=$itemID
	*		CUSTID=$custID
	*		SHIPTOID=$shipID
	*		WHSE=$whse  **OPTIONAL
	*		break;
	*	case 'add-nonstock-item':
	*		- Adds Nonstock item to the cart for customer
	*		DBNAME=$config->dplusdbname
	*		CARTDET
	*		ITEMID=N
	*		QTY=$qty
	*		CUSTID=$custID
	*		break;
	*	case 'add-multiple-items':
	*		- Adds Multiple Items to the cart for customer
	*		DBNAME=$config->dplusdbname
	*		CARTADDMULTIPLE
	*		CUSTID=$custID
	*		ITEMID=$custID   QTY=$qty  **REPEAT
	*		break;
	*	case 'reorder':
	*		- Adds multiple items from a quote or order for that order / quote's customer
	*		CARTADDMULTIPLE
	*		CUSTID=$custID || PULL FROM QUOTENBR / ORDN
	*		ITEMID=$custID   QTY=$qty  **REPEAT
	*		break;
	*	case 'update-line':
	*		- Edits a cart detail line
	*		DBNAME=$config->dplusdbname
	*		CARTDET
	*		LINENO=$linenbr
	*		CUSTID=$custID
	*		SHIPTOID=$shipID
	*		break;
	*	case 'remove-line':
	*		- Remove Detail Line
	*		DBNAME=$config->dplusdbname
	*		CARTDET
	*		LINENO=$linenbr
	*		CUSTID=$custID
	*		SHIPTOID=$shipID
	*		break;
	*	case 'empty-cart':
	*		- Removes all items from the Cart
	*		DBNAME=$config->dplusdbname
	*		EMPTYCART
	*		break;
	*	case 'create-sales-order':
	*		- Create Sales Order from cart 
	*		DBNAME=$config->dplusdbname
	*		CREATESO
	*		break;
	*	case 'create-quote':
	*		- Create Quote from cart 
	*		DBNAME=$config->dplusdbname
	*		CREATEQT
	*		break;
	* }
	*
	**/

	switch ($action) {
		case 'add-to-cart':
			$itemID = $input->$requestmethod->text('itemID');
			$qty = determine_qty($input, $requestmethod, $itemID); // TODO MAKE IN CART DETAIL
			$custID = !empty($custID) ? $custID : $config->defaultweb;
			$whse = $input->$requestmethod->text('whse');
			$data = array("DBNAME=$config->dplusdbname", 'CARTDET', "ITEMID=$itemID", "QTY=$qty", "CUSTID=$custID");
			if (!empty($shipID)) {
				$data[] = "SHIPTOID=$shipID";
			}
			if (!empty($whse)) {
				$data[] = "WHSE=$whse";
			}
			$session->addtocart = 'You added ' . $qty . ' of ' . $itemID . ' to your cart';
			$session->loc = $input->$requestmethod->page;
			break;
		case 'add-nonstock-item':
			$qty = $input->$requestmethod->text('qty');
			$cartdetail = new CartDetail();
			$cartdetail->set('sessionid', $sessionID);
			$cartdetail->set('linenbr', '0');
			$cartdetail->set('recno', 0);
			$cartdetail->set('orderno', $sessionID);
			$cartdetail->set('vendorid', $input->$requestmethod->text('vendorID'));
			$cartdetail->set('shipfromid', $input->$requestmethod->text('shipfromID'));
			$cartdetail->set('vendoritemid', $input->$requestmethod->text('itemID'));
			$cartdetail->set('desc1', $input->$requestmethod->text('desc1'));
			$cartdetail->set('desc2', $input->$requestmethod->text('desc2'));
			$cartdetail->set('qty', $qty);
			$cartdetail->set('price', $input->$requestmethod->text('price'));
			$cartdetail->set('cost', $input->$requestmethod->text('cost'));
			$cartdetail->set('uom', $input->$requestmethod->text('uofm'));
			$cartdetail->set('nsitemgroup', $input->$requestmethod->text('nsitemgroup'));
			$cartdetail->set('ponbr', $input->$requestmethod->text('ponbr'));
			$cartdetail->set('poref', $input->$requestmethod->text('poref'));
			$cartdetail->set('spcord', 'S');
			$session->sql = $cartdetail->create();
			$data = array("DBNAME=$config->dplusdbname", 'CARTDET', 'LINENO=0', 'ITEMID=N', "QTY=$qty", "CUSTID=$custID");
			$session->loc = $config->pages->cart;
			break;
		case 'add-multiple-items':
			$itemids = $input->$requestmethod->itemID;
			$data = array("DBNAME=$config->dplusdbname", 'CARTADDMULTIPLE', "CUSTID=$custID");

			if (DplusWire::wire('modules')->isInstalled('CaseQtyBottle')) {
				$case_qtys = $input->$requestmethod->{'case-qty'};
				$bottle_qtys = $input->$requestmethod->{'bottle-qty'};
				$qtypercase = DplusWire::wire('modules')->get('CaseQtyBottle');
				// TODO FIX tHIS for new DATA array
				$data = $qtypercase->generate_multipleitemdata($data, $itemids, $case_qtys, $bottle_qtys);
			} else {
				$qtys = $input->$requestmethod->qty;
				for ($i = 0; $i < sizeof($itemids); $i++) {
					$itemID = str_pad(DplusWire::wire('sanitizer')->text($itemidss[$i]), 30, ' ');
					$qty = DplusWire::wire('sanitizer')->text($qtys[$i]);
					$qty = !empty($qty) ? $qty : "1";
					$data[] = "ITEMID={$itemID}QTY=$qty";
				}
			}
			$session->addtocart = sizeof($itemIDs);
			$session->loc = $config->pages->cart;
			break;
		case 'reorder':
			$from = $input->$requestmethod->text('from');
			$itemids = array();
			$qtys = array();
			switch ($from) {
				case 'salesorder':
					$ordn = $input->get->text('ordn');
					$custID = SalesOrder::find_custid($ordn);;
					$details = get_orderdetails(session_id(), $ordn, true, false);
					foreach ($details as $detail) {
						$itemids[] = $detail->itemid;
						$qtys[] = $detail->qty;
					}
					break;
			}
			$data = array("DBNAME=$config->dplusdbname", 'CARTADDMULTIPLE', "CUSTID=$custID");
			for ($i = 0; $i < sizeof($items); $i++) {
				$itemID = str_pad(DplusWire::wire('sanitizer')->text($items[$i]), 30, ' ');
				$qty = DplusWire::wire('sanitizer')->text($qtys[$i]);
				$qty = !empty($qty) ? $qty : "1";
				$data[] = "ITEMID={$itemID}QTY=$qty";
			}
			$session->loc = $config->pages->cart;
			break;
		case 'quick-update-line':
			$linenbr = $input->$requestmethod->text('linenbr');
			$cartdetail = CartDetail::load($sessionID, $linenbr);
			$qty = determine_qty($input, $requestmethod, $cartdetail->itemid); // TODO MAKE IN CART DETAIL
			$custID = CartQuote::get_cartcustid($sessionID);
			$custID = !empty($custID) ? $custID : $config->defaultweb;
			// $cartdetail->set('whse', $input->$requestmethod->text('whse'));
			$cartdetail->set('qty', $qty);
			$cartdetail->set('price', $input->$requestmethod->text('price'));
			$cartdetail->set('rshipdate', $input->$requestmethod->text('rqstdate'));
			$session->sql = $cartdetail->update();
			$data = array("DBNAME=$config->dplusdbname", 'CARTDET', "LINENO=$linenbr", "CUSTID=$custID");
			$session->loc = $config->pages->cart;
			break;
		case 'update-line':
			$linenbr = $input->$requestmethod->text('linenbr');
			$cartdetail = CartDetail::load($sessionID, $linenbr);
			$custID = !empty($custID) ? $custID : $config->defaultweb;
			$qty = determine_qty($input, $requestmethod, $cartdetail->itemid); // TODO MAKE IN CART DETAIL
			$cartdetail->set('price', $input->$requestmethod->text('price'));
			$cartdetail->set('discpct', $input->$requestmethod->text('discount'));
			$cartdetail->set('qty', $qty);
			$cartdetail->set('rshipdate', $input->$requestmethod->text('rqstdate'));
			$cartdetail->set('whse', $input->$requestmethod->text('whse'));
			$cartdetail->set('spcord', $input->$requestmethod->text('specialorder'));
			$cartdetail->set('vendorid', $input->$requestmethod->text('vendorID'));
			$cartdetail->set('shipfromid', $input->$requestmethod->text('shipfromID'));
			$cartdetail->set('vendoritemid', $input->$requestmethod->text('vendoritemID'));
			$cartdetail->set('nsitemgroup', $input->$requestmethod->text('nsitemgroup'));
			$cartdetail->set('ponbr', $input->$requestmethod->text('ponbr'));
			$cartdetail->set('poref', $input->$requestmethod->text('poref'));
			$cartdetail->set('uom', $input->$requestmethod->text('uofm'));

			if ($cartdetail->spcord != 'N') {
				$cartdetail->set('desc1', $input->$requestmethod->text('desc1'));
				$cartdetail->set('desc2', $input->$requestmethod->text('desc2'));
			}
			$session->sql = $cartdetail->update();
			$session->loc = $input->$requestmethod->text('page');
			$data = array("DBNAME=$config->dplusdbname", 'CARTDET', "LINENO=$linenbr", "CUSTID=$custID");
			$session->loc = $config->pages->cart;
			break;
		case 'remove-line':
			$linenbr = $input->get->text('line');
			$cartdetail = CartDetail::load($sessionID, $linenbr);
			$cartdetail->set('qty', '0');
			$session->sql = $cartdetail->update();
			$custID = CartQuote::get_cartcustid($sessionID);
			$custID = !empty($custID) ? $custID : $config->defaultweb;
			$data = array("DBNAME=$config->dplusdbname", 'CARTDET', "LINENO=$linenbr", 'QTY=0', "CUSTID=$custID");
			$session->loc = $config->pages->cart;
			break;
		case 'empty-cart':
			$data = array("DBNAME=$config->dplusdbname", 'EMPTYCART');
			$session->loc = $config->pages->cart;
			break;
		case 'create-sales-order':
			$data = array("DBNAME=$config->dplusdbname", 'CREATESO');
			$session->loc = "{$config->pages->orders}redir/?action=edit-new-order";
			break;
		case 'create-quote':
			$data = array("DBNAME=$config->dplusdbname", 'CREATEQT');
			$session->loc = "{$config->pages->quotes}redir/?action=edit-new-quote";
			break;
	}

	write_dplusfile($data, $filename);
	curl_redir("127.0.0.1/cgi-bin/".$config->cgis['default']."?fname=$filename");
	if (!empty($session->get('loc')) && !$config->ajax) {
		header("Location: $session->loc");
	}
	exit;
