<?php
	use Dplus\Dpluso\OrderDisplays\QuotePanel;
	use Dplus\Content\Paginator;

	// Figure out page request method, then grab needed inputs
	$requestmethod = $input->requestMethod('POST') ? 'post' : 'get';
	$action = $input->$requestmethod->text('action');

	// Set up filename and sessionID in case this was made through cURL
	$filename = ($input->$requestmethod->sessionID) ? $input->$requestmethod->text('sessionID') : session_id();
	$sessionID = ($input->$requestmethod->sessionID) ? $input->$requestmethod->text('sessionID') : session_id();
	$session->fromredirect = $page->url;

	// USED FOR MAINLY ORDER LISTING FUNCTIONS
	$pagenumber = (!empty($input->get->page) ? $input->get->int('page') : 1);
	$sortaddon = (!empty($input->get->orderby) ? '&orderby=' . $input->get->text('orderby') : '');
	$filteraddon = '';
	if ($input->get->filter) {
		$quotepanel = new QuotePanel(session_id(), $page->fullURL, '', '', '');
		$quotepanel->generate_filter($input);

		if (!empty($quotepanel->filters)) {
			$filteraddon = "&filter=filter";
			foreach ($quotepanel->filters as $filter => $value) {
				$filteraddon .= "&$filter=".implode('|', $value);
			}
		}
	}

	$linkaddon = $sortaddon . $filteraddon;
	$session->remove('quote-search');
	$session->remove('panelorigin');
	$session->remove('paneloriginpage');
	$session->filters = $filteraddon;
	$filename = session_id();

	//TODO merge get-quote-details and get-quote-details-print
	/**
	*  QUOTE REDIRECT
	* @param string $action
	*
	*
	*
	* switch ($action) {
	* 	case 'load-quotes':
	*		DBNAME=$config->dplusdbname
	*		LOADREPQUOTEHED
	*		TYPE=QUOTE
	*		break;
	* 	case 'load-cust-quotes':
	*		DBNAME=$config->dplusdbname
	*		LOADCUSTQUOTEHEAD
	*		TYPE=QUOTE
	*		CUSTID=$custID
	*		break;
	*	case 'load-quote-details':
	*		DBNAME=$config->dplusdbname
	*		LOADQUOTEDETAIL
	*		QUOTENO=$qnbr
	*		CUSTID=$custID
	*		break;
	*	case 'get-quote-details-print': // DEPRECATED 10/30/2017
	*		DBNAME=$config->dplusdbname
	*		LOADQUOTEDETAIL
	*		QUOTENO=$qnbr
	*		CUSTID=$custID
	*		break;
	*	case 'edit-new-quote':
	*		DBNAME=$config->dplusdbname
	*		EDITQUOTE=$qnbr
	*		QUOTENO=$qnbr
	*		break;
	*	case 'update-quotehead':
	*		DBNAME=$config->dplusdbname
	*		UPDATEQUOTEHEAD
	*		QUOTENO=$qnbr
	*		CUSTID=$custID
	*		break;
	*	case 'add-to-quote':
	*		DBNAME=$config->dplusdbname
	*		UPDATEQUOTEDETAIL
	*		QUOTENO=$qnbr
	*		ITEMID=$itemID
	*		QTY=$qty
	*		break;
	*	case 'add-multiple-items':
	*		DBNAME=$config->dplusdbname
	*		ORDERADDMULTIPLE
	*		QUOTENO=$ordn
	*		ITEMID=$custID   QTY=$qty  **REPEAT
	*		break;
	*	case 'add-nonstock-item':
	*		DBNAME=$config->dplusdbname
	*		UPDATEQUOTEDETAIL
	*		QUOTENO=$qnbr
	*		LINENO=0
	*		ITEMID=N
	*		QTY=$qty
	*		CUSTID=$custID
	* 		break;
	*	case 'update-line':
	*		DBNAME=$config->dplusdbname
	*		UPDATEQUOTEDETAIL
	*		QUOTENO=$qnbr
	*		LINENO=$linenbr
	*		break;
	*	case 'remove-line':
	*		DBNAME=$config->dplusdbname
	*		UPDATEQUOTEDETAIL
	*		QUOTENO=$qnbr
	*		LINENO=$linenbr
	*		QTY=0
	*		break;
	*	case 'remove-line-get' // SAME AS ABOVE
	*		break;
	*	case 'unlock-quote':
	*		UNLOCKING QUOTE
	*		break;
	*	case 'send-quote-to-order':
	*		DBNAME=$config->dplusdbname
	*		QUOTETOORDER
	*		QUOTENO=$quotnbr
	*		LINENO = 'ALL'
	*		break;
	* }
	**/


	switch ($action) {
		case 'load-quotes':
			$data = array('DBNAME' => $config->dplusdbname, 'LOADREPQUOTEHED' => false);
			$session->loc = $config->pages->ajax."load/quotes/?qnbr=".$linkaddon;
			$session->{'quotes-loaded-for'} = $user->loginid;
			$session->{'quotes-updated'} = date('m/d/Y h:i A');
			break;
		case 'load-cust-quotes':
			$custID = $input->get->text('custID');
			$shipID = $input->get->text('shipID');
			$url = new Purl\Url($config->pages->ajax."load/quotes/customer/");
			$url->path->add($custID);
			if (!empty($shipID)) {
				$url->path->add("shipto-$shipID");
			}
			$url->query = "qnbr=".$linkaddon;
			$session->loc = $url->getUrl();
			$data = array('DBNAME' => $config->dplusdbname, 'LOADCUSTQUOTEHEAD' => false, 'TYPE' => 'QUOTE', 'CUSTID' => $custID);
			$session->{'quotes-loaded-for'} = $custID;
			$session->{'quotes-updated'} = date('m/d/Y h:i A');
			break;
		case 'load-quote-details':
			$qnbr = $input->get->text('qnbr');
			$custID = Quote::find_custid(session_id(), $qnbr, false);

			$data = array('DBNAME' => $config->dplusdbname, 'LOADQUOTEDETAIL' => false, 'QUOTENO' => $qnbr, 'CUSTID' => $custID);

			if ($input->get->lock) {
				$session->loc = $config->pages->editquote."?qnbr=".$qnbr;
			} elseif ($input->get->print) {
				$session->loc = $config->pages->print."quote/?qnbr=".$qnbr;
			} else {
				if ($input->get->custID) {
					if ($input->get->shipID) {
						$session->loc = Paginator::paginate_url($config->pages->ajax."load/quotes/cust/{$input->get->custID}/shipto-{$input->get->shipID}/?qnbr=".$qnbr.$linkaddon, $pagenumber, "shipto-{$input->get->shipID}", '');
					} else {
						$session->loc = Paginator::paginate_url($config->pages->ajax."load/quotes/cust/{$input->get->custID}/?qnbr=".$qnbr.$linkaddon, $pagenumber, $input->get->custID, '');
					}
				} else {
					$session->loc = Paginator::paginate_url($config->pages->ajax."load/quotes/salesrep/?qnbr=".$qnbr.$linkaddon, $pagenumber, "quotes", '');
				}
			}
			break;
		case 'edit-quote':
			$qnbr = $input->get->text('qnbr');
			$date = date('Ymd');
			$time = date('Hi');
			$custID = Quote::find_custid(session_id(), $qnbr, false);
			$data = array('DBNAME' => $config->dplusdbname, 'EDITQUOTE' => false, 'QUOTENO' => $qnbr);
			$session->loc= $config->pages->editquote."?qnbr=".$qnbr;
			if ($input->get->quoteorigin) {
				$session->panelorigin = 'quotes';
				$session->paneloriginpage = $input->get->text('quoteorigin');
				if ($input->get->custID) {
					$session->panelcustomer = $input->get->text('custID');
				}
			}
			break;
		case 'edit-new-quote':
			$qnbr = get_createdordn(session_id());
			$date = date('Ymd');
			$time = date('Hi');
			$data = array('DBNAME' => $config->dplusdbname, 'EDITQUOTE' => $qnbr, 'QUOTENO' => $qnbr);
			$session->loc = $config->pages->editquote."?qnbr=".$qnbr;
			break;
		case 'update-quotehead':
			$qnbr = $input->post->text('qnbr');
			$quote = Quote::load(session_id(), $qnbr);
			$quote->set('shiptoid', $input->post->text('shiptoid'));
			$quote->set('shipname', $input->post->text('shiptoname'));
			$quote->set('shipaddress', $input->post->text('shipto-address'));
			$quote->set('shipaddress2', $input->post->text('shipto-address2'));
			$quote->set('shipcity', $input->post->text('shipto-city'));
			$quote->set('shipstate', $input->post->text('shipto-state'));
			$quote->set('shipzip', $input->post->text('shipto-zip'));
			$quote->set('contact', $input->post->text('contact'));
			$quote->set('email', $input->post->text('contact-email'));
			$quote->set('revdate', $input->post->text('reviewdate'));
			$quote->set('expdate', $input->post->text('expiredate'));
			$quote->set('shipviacd', $input->post->text('shipvia'));
			$quote->set('deliverydesc', $input->post->text('delivery'));
			$quote->set('custpo', $input->post->text('custpo'));
			$quote->set('custref', $input->post->text('reference'));
			$quote->set('phone', $input->post->text('contact-phone'));
			$quote->set('faxnbr', $input->post->text('contact-fax'));
			$haschanges = $quote->has_changes();
			$session->sql = $quote->update();

			$data = array('DBNAME' => $config->dplusdbname, 'UPDATEQUOTEHEAD' => false, 'QUOTENO' => $qnbr);

			if ($input->post->exitquote) {
				$session->loc = $config->pages->edit."quote/confirm/?qnbr=".$qnbr.$linkaddon;
				if (!$haschanges) {
					$data = array('UNLOCKING QUOTE' => false);
				}
			} else {
				$session->loc = $config->pages->editquote."?qnbr=".$qnbr.$linkaddon;
			}
			break;
		case 'add-to-quote':
			$qnbr = $input->post->text('qnbr');
			$itemID = $input->post->text('itemID');
			$fororder = $input->get->order ? true : false;
			$qty = determine_qty($input, $requestmethod, $itemID);
			$data = array('DBNAME' => $config->dplusdbname, 'UPDATEQUOTEDETAIL' => false, 'QUOTENO' => $qnbr, 'ITEMID' => $itemID, 'QTY' => "$qty");
			if ($input->post->page) {
				$session->loc = $input->post->text('page');
			} else {
				$session->loc = $fororder ? $config->pages->edit."quote-to-order/?qnbr=$qnbr" : $config->pages->edit."quote/?qnbr=$qnbr";
			}

			$session->editdetail = true;
			break;
		case 'add-multiple-items':
			$qnbr = $input->post->text('qnbr');
			$itemids = $input->post->itemID;
			$qtys = $input->post->qty;
			$fororder = $input->get->order ? true : false;
			$data = array("DBNAME=$config->dplusdbname", 'QUOTEADDMULTIPLE', "QUOTENO=$qnbr");
			$data = writedataformultitems($data, $itemids, $qtys);
            $session->loc = $fororder ? $config->pages->edit."quote-to-order/?qnbr=$qnbr" : $config->pages->edit."quote/?qnbr=$qnbr";
			$session->editdetail = true;
			break;
		case 'add-nonstock-item':
			$qnbr = $input->$requestmethod->text('qnbr');
			$qty = $input->$requestmethod->text('qty');
			$quotedetail = new QuoteDetail();
			$quotedetail->set('sessionid', session_id());
			$quotedetail->set('quotenbr', $qnbr);
			$quotedetail->set('recno', '0');
			$quotedetail->set('linenbr', '0');
			$quotedetail->set('ordrprice', $input->post->text('price'));
			$quotedetail->set('quotqty', $qty);
			$quotedetail->set('desc1', $input->post->text('desc1'));
			$quotedetail->set('desc2', $input->post->text('desc2'));
			$quotedetail->set('vendorid', $input->post->text('vendorID'));
			$quotedetail->set('shipfromid', $input->post->text('shipfromID'));
			$quotedetail->set('vendoritemid', $input->post->text('itemID'));
			$quotedetail->set('nsitemgroup', $input->post->text('nsitemgroup'));
			//$quotedetail->set('ponbr', $input->post->text('ponbr'));
			//$quotedetail->set('poref', $input->post->text('poref'));
			$quotedetail->set('uom', $input->post->text('uofm'));
			$quotedetail->set('spcord', 'S');
			$session->sql = $quotedetail->create();
			$fororder = $input->get->order ? true : false;
			$data = array('DBNAME' => $config->dplusdbname, 'UPDATEQUOTEDETAIL' => false, 'QUOTENO' => $qnbr, 'LINENO' => '0', 'ITEMID' => 'N', 'QTY' => $qty);
			if ($input->post->page) {
				$session->loc = $input->post->text('page');
			} else {
				$session->loc = $fororder ? $config->pages->edit."quote-to-order/?qnbr=$qnbr" : $config->pages->edit."quote/?qnbr=$qnbr";
			}
			$session->editdetail = true;
			break;
		case 'quick-update-line':
			$qnbr = $input->post->text('qnbr');
			$linenbr = $input->post->text('linenbr');
			$quotedetail = QuoteDetail::load(session_id(), $qnbr, $linenbr);
			$custID = Quote::find_custid(session_id(), $qnbr);
			$qty = determine_qty($input, $requestmethod, $quotedetail->itemid); // TODO MAKE IN CART DETAIL
			// $quotedetail->set('whse', $input->post->text('whse'));
			$quotedetail->set('quotqty', $qty);
			$quotedetail->set('ordrqty', $qty);
			$quotedetail->set('quotprice', $input->post->text('price'));
			$quotedetail->set('ordrprice', $input->post->text('price'));
			$quotedetail->set('rshipdate', $input->post->text('rqstdate'));
			$session->sql = $quotedetail->update();

			$data = array('DBNAME' => $config->dplusdbname, 'UPDATEQUOTEDETAIL' => false, 'QUOTENO' => $qnbr, 'LINENO' => $linenbr, 'CUSTID' => $custID);

			if ($input->post->page) {
				$session->loc = $input->post->text('page');
			} else {
				$session->loc = $config->pages->edit."quote/?qnbr=".$qnbr;
			}
			$session->editdetail = true;
			break;
		case 'update-line':
			$qnbr = $input->$requestmethod->text('qnbr');
			$linenbr = $input->$requestmethod->text('linenbr');
			$quotedetail = QuoteDetail::load(session_id(), $qnbr, $linenbr);
			$qty = determine_qty($input, $requestmethod, $quotedetail->itemid);

			$quotedetail->set('quotprice', $input->post->text('price'));
			$quotedetail->set('ordrprice', $input->post->text('price'));
			$quotedetail->set('discpct', $input->post->text('discount'));
			$quotedetail->set('quotqty', $qty);
			$quotedetail->set('ordrqty', $qty);
			$quotedetail->set('rshipdate', $input->post->text('rqstdate'));
			$quotedetail->set('whse', $input->post->text('whse'));
			$quotedetail->set('linenbr', $input->post->text('linenbr'));
			$quotedetail->set('spcord', $input->post->text('specialorder'));
			$quotedetail->set('vendorid', $input->post->text('vendorID'));
			$quotedetail->set('shipfromid', $input->post->text('shipfromid'));
			$quotedetail->set('vendoritemid', $input->post->text('itemID'));
			$quotedetail->set('nsitemgroup', $input->post->text('group'));
			$quotedetail->set('uom', $input->post->text('uofm'));

			if ($quotedetail->spcord != 'N') {
				$quotedetail->set('desc1', $input->post->text('desc1'));
				$quotedetail->set('desc2', $input->post->text('desc2')) ;
			}

			$custID = Quote::find_custid(session_id(), $qnbr);
			$session->sql = $quotedetail->update();

			$data = array('DBNAME' => $config->dplusdbname, 'UPDATEQUOTEDETAIL' => false, 'QUOTENO' => $qnbr, 'LINENO' => $linenbr, 'CUSTID' => $custID);
			if ($input->post->page) {
				$session->loc = $input->post->text('page');
			} else {
				$session->loc = $config->pages->edit."quote/?qnbr=".$qnbr;
			}
			$session->editdetail = true;
			break;
		case 'remove-line':
			$qnbr = $input->post->text('qnbr');
			$custID = $input->post->text('custID');
			$linenbr = $input->post->text('linenbr');
			$quotedetail = QuoteDetail::load(session_id(), $qnbr, $linenbr);
			$quotedetail->set('quotqty', '0');
			$quotedetail->set('linenbr', $input->post->text('linenbr'));
			$session->sql = $quotedetail->update();
			// $custID = Quote::find_custid(session_id(), $qnbr, false);
			$data = array('DBNAME' => $config->dplusdbname, 'UPDATEQUOTEDETAIL' => false, 'QUOTENO' => $qnbr, 'LINENO' => $linenbr, 'QTY' => '0', 'CUSTID' => $custID);

			if ($input->post->page) {
				$session->loc = $input->post->text('page');
			} else {
				$session->loc = $config->pages->edit."quote/?qnbr=".$qnbr;
			}
			$session->editdetail = true;
			break;
		case 'remove-line-get':
			$qnbr = $input->get->text('qnbr');
			$linenbr = $input->get->text('linenbr');
			$quotedetail = QuoteDetail::load(session_id(), $qnbr, $linenbr);
			$quotedetail->set('quotqty', '0');
			$session->sql = $quotedetail->update();
			$custID = Quote::find_custid(session_id(), $qnbr, false);
			$data = array('DBNAME' => $config->dplusdbname, 'UPDATEQUOTEDETAIL' => false, 'QUOTENO' => $qnbr, 'LINENO' => $linenbr, 'QTY' => '0', 'CUSTID' => $custID);

			if ($input->get->page) {
				$session->loc = $input->get->text('page');
			} else {
				$session->loc = $config->pages->edit."quote/?qnbr=".$qnbr;
			}
			$session->editdetail = true;
			break;
		case 'unlock-quote':
			$qnbr = $input->get->text('qnbr');
			$data = array('UNLOCKING QUOTE' => false);
			$session->loc = $config->pages->edit."quote/confirm/?qnbr=".$qnbr.$linkaddon;
			break;
		case 'send-quote-to-order':
			$qnbr = $input->post->text('qnbr');
			$linenbrs = $input->post->linenbr;
			$linecount = count_quotedetails(session_id(), $qnbr) + 1;
			$session->linenbrs = $input->post->linenbr;
			for ($i = 1; $i < $linecount; $i++) {
				$quotedetail = QuoteDetail::load(session_id(), $qnbr, $i);
				if (in_array($i, $linenbrs)) {
					$quotedetail->set('ordrqty', $quotedetail->quotqty);
					$quotedetail->set('ordrprice', $quotedetail->quotprice);
				} else {
					$quotedetail->set('ordrqty', '0');
				}
				$session->sql = $quotedetail->update();
			}
			$session->custID = $custID = Quote::find_custid(session_id(), $qnbr, false);
			$data = array('DBNAME' => $config->dplusdbname, 'QUOTETOORDER' => false, 'QUOTENO' => $qnbr, 'LINENO' => 'ALL');
			$session->loc = $config->pages->orders."redir/?action=edit-new-order";
			break;
		case 'send-dplus-file':
			$qnbr = $input->get->text('qnbr');
			break;
	}

	writedplusfile($data, $filename);
	curl_redir("127.0.0.1/cgi-bin/".$config->cgis['default']."?fname=$filename");
	if (!empty($session->get('loc')) && !$config->ajax) {
		header("Location: $session->loc");
	}
	exit;
