<?php
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
	* CUSTOMER REDIRECT
	* @param string $action
	*
	*
	*
	* switch ($action) {
	* 	case 'add-customer':
	* 		DBNAME=$config->dplusdbname
	* 		NEWCUSTOMER
	*		BILLTONAME=$customer-name
	*		BILLTOADDRESS1=$customer-addr1
	*		BILLTOADDRESS2=$customer-addr2
	*		BILLTOADDRESS3=$billtoaddress3
	*		BILLTOCITY=$customer-city
	*		BILLTOSTATE=$customer-state
	*		BILLTOZIP=$customer-zip
	*		BILLTOCOUNTRY=$billtocountry
	*		BILLTOPHONE=$customer-phone
	*		BILLTOFAX=$customer-faxnbr
	*		BILLTOEMAIL=$customer-email
	*		SHIPTOID=$shipto-shiptoid
	*		SHIPTONAME=$shipto-name
	*		SHIPTOADDRESS1=$shipto-addr1
	*		SHIPTOADDRESS2=$shipto-addr2
	*		SHIPTOADDRESS3=$shiptoaddress3
	*		SHIPTOCITY=$shipto-city
	*		SHIPTOSTATE=$shipto-state
	*		SHIPTOZIP=$shipto-zip
	*		SHIPTOCOUNTRY=$shipto-country
	*		SHIPTOPHONE=$shipto-phone
	*		SHIPTOFAX=$shipto-faxnbr
	*		SHIPTOEMAIL=$shipto-email
	*		SALESPERSON1=$salesperson1
	*		SALESPERSON2=$salesperson2
	*		SALESPERSON3=$salesperson3
	*		PRICECODE=$pricecode
	*		CONTACT=$customer-contact
	*		ARCONTACT="Y" : "N"
	*		DUNCONTACT="Y" : "N"
	*		BUYCONTACT="Y" : "N"
	*		CERCONTACT=$input-post-text(cercontact)
	*		ACKCONTACT="Y" : "N"
	*		EXTENSION=$contactext
	*		TITLE=$contacttitle
	*		NOTES=
	*		break;
	* 	case 'load-new-customer':
	*		DBNAME=$config->dplusdbname
	*		CUSTID=$custID
	*		break;
	*	case 'load-customer': // START DEPRECATING 1/25/2018
	*		DBNAME=$config->dplusdbname
	*		CUSTID=$custID
	*		break;
	*	case 'shop-as-customer':
	*		DBNAME=$config->dplusdbname
	*		CARTCUST
	*		CUSTID=$custID
	*		SHIPID=$shipID
	*		break;
	*	case 'add-contact':
	*		DBNAME=$config->dplusdbname
	*		ADDCONTACT
	*		CUSTID=$custID
	*		SHIPID=$shipID
	*		CONTACT=$contactID
	*		TITLE=$title
	*		PHONE=$phone
	*		EXTENSION=$extension
	*		FAX=$fax
	*		EMAIL=$email
	*		CELLPHONE=$cellphone
	*		ARCONTACT= Y | N ** ONLY BILLTO
	*		DUNCONTACT= Y | N ** ONLY BILLTO
	*		ACKCONTACT= Y | N ** ONLY BILLTO
	*		BUYCONTACT= P | Y | N
	*		CERCONTACT= Y | N
	*		break;
	*	case 'edit-contact':
	*		DBNAME=$config->dplusdbname
	*		EDITCONTACT
	*		CUSTID=$custID
	*		SHIPID=$shipID
	*		CONTACT=$contactID
	*		NAME=$name
	*		PHONE=$phone
	*		EXTENSION=$extension
	*		CELLPHONE=$cellphone
	*		EMAIL=$email
	* 		break;
	* 	case 'ci-buttons':
	* 		DBNAME=$config->dplusdbname
	*		CIBUTTONS
	*		break;
	*	case 'ci-customer':
	*		DBNAME=$config->dplusdbname
	*		CICUSTOMER
	*		CUSTID=$custID
	* 		break;
	* 	case 'ci-shiptos':
	*		DBNAME=$config->dplusdbname
	*		CISHIPTOLIST n2zz729p
	*		CUSTID=$custID
	* 		break;
	* 	case 'ci-shipto-info':
	*		DBNAME=$config->dplusdbname
	*		CISHIPTOINFO n2zz730p
	*		CUSTID=$custID
	*		SHIPID=$shipID
	* 		break;
	* 	case 'ci-shipto-buttons':
	*		DBNAME=$config->dplusdbname
	*		CISTBUTTONS
	* 		break;
	* 	case 'ci-pricing':
	*		DBNAME=$config->dplusdbname
	*		CIPRICE n2zz725p
	*		ITEMID=$itemID
	*		CUSTID=$custID
	* 		break;
	* 	case 'ci-contacts':
	*		DBNAME=$config->dplusdbname
	*		CICONTACT n2zz732p
	*		CUSTID=$custID
	*		SHIPID=$shipID
	*		break;
	*	case 'ci-documents':
	*		DOCVIEW
	*		FLD1CD=CU
	*		FLD1DATA=$custID
	*		FLD1DESC=$custname
	* 		break;
	* 	case 'ci-order-documents':
	*		DOCVIEW n2zz735p
	*		FLD1CD=SO
	*		FLD1DATA=$ordn
	* 		break;
	* 	case 'ci-standing-orders':
	*		CISTANDORDR n2zz736p
	*		CUSTID=$custID
	*		SHIPID=$shipID
	* 		break;
	* 	case 'ci-credit':
	*		CICREDIT n2zz737p
	*		CUSTID=$custID
	* 		break;
	* 	case 'ci-open-invoices':
	*		CIOPENINV n2zz745p
	*		CUSTID=$custID
	* 		break;
	* 	case 'ci-quotes':
	*		CIQUOTE n2zz748p
	*		CUSTID=$custID
	* 		break;
	* 	case 'ci-payments':
	*		CIPAYMENT n2zz746p
	*		CUSTID=$custID
	* 		break;
	* 	case 'ci-sales-orders':
	*		CISALESORDR n2zz733p
	*		CUSTID=$custID
	*		SHIPID=$shipID
	*		SALESORDRNBR=''
	*		ITEMID=''
	* 		break;
	* 	case 'ci-sales-history':
	* 		CISALESHIST n2zz751p
	* 		CUSTID=$custID
	*		SHIPID=$shipID
	*		DATE=$startdate
	*		SALESORDRNBR=''
	*		ITEMID=$itemID
	* 		break;
	* 	case 'ci-custpo':
	* 		CICUSTPO n2zz751p
	* 		CUSTID=$custID
	*		SHIPID=$shipID
	*		CUSTPO=$custpo
	* 		break;
	* }
	*
	**/

	switch ($action) {
		case 'add-customer':
			$customer = new Customer();
			$customer->set('custid', session_id());
			$customer->set('splogin1', $input->post->text('salesperson1'));
			$customer->set('splogin2',  $input->post->text('salesperson2'));
			$customer->set('splogin3', $input->post->text('salesperson3'));
			$customer->set('date', date('Ymd'));
			$customer->set('time', date('His'));
			$customer->set('source', 'C');
			$customer->set('name',  $input->post->text('billto-name'));
			$customer->set('addr1', $input->post->text('billto-address'));
			$customer->set('addr2', $input->post->text('billto-address2'));
			$customer->set('city', $input->post->text('billto-city'));
			$customer->set('state', $input->post->text('billto-state'));
			$customer->set('zip', $input->post->text('billto-zip'));
			$customer->set('contact', !empty($input->post->text('contact-name')) ? $input->post->text('contact-name') : $customer->name);
			$customer->set('phone', $input->post->text('contact-phone'));
			$customer->set('extension', $input->post->text('contact-ext'));
			$customer->set('faxnbr', $input->post->text('contact-fax'));
			$customer->set('email', $input->post->text('contact-email'));
			$customer->set('recno', get_maxcustindexrecnbr() + 1);
			$customer->set('arcontact', $input->post->text('arcontact') == 'Y' ? "Y" : "N");
			$customer->set('dunningcontact', $input->post->text('dunningcontact') == 'Y' ? "Y" : "N");
			$customer->set('buyingcontact', $input->post->text('buycontact'));
			$customer->set('certcontact', $input->post->text('certcontact') == 'Y' ? "Y" : "N");
			$customer->set('ackcontact', $input->post->text('ackcontact') == 'Y' ? "Y" : "N");
			$customer->create();
			$customer->create_custpermpermission($user->loginid);

			$shipto = Customer::create_fromobject($customer);
			$shipto->set('shiptoid', '1');
			$shipto->set('source', 'CS');
			$shipto->set('name', !empty($input->post->text('shipto-name')) ? $input->post->text('shipto-name') : $customer->name);
			$shipto->set('addr1', $input->post->text('shipto-address'));
			$shipto->set('addr2', $input->post->text('shipto-address2'));
			$shipto->set('city', $input->post->text('shipto-city'));
			$shipto->set('state', $input->post->text('shipto-state'));
			$shipto->set('zip', $input->post->text('shipto-zip'));
			$shipto->set('contact', !empty($input->post->text('contact-name')) ? $input->post->text('contact-name') : $shipto->name);
			$shipto->set('phone', $input->post->text('contact-phone'));
			$shipto->set('extension', $input->post->text('contact-ext'));
			$shipto->set('faxnbr', $input->post->text('contact-fax'));
			$shipto->set('email', $input->post->text('contact-email'));
			$shipto->set('recno', get_maxcustindexrecnbr() + 1);
			$shipto->set('arcontact', "N");
			$shipto->set('dunningcontact', "N");
			$shipto->set('buyingcontact', $input->post->text('buycontact'));
			$shipto->set('certcontact', $input->post->text('certcontact') == 'Y' ? "Y" : "N");
			$shipto->set('ackcontact', "N");
			$shipto->create();
			$shipto->create_custpermpermission($user->loginid);

			$data = array(
				'DBNAME' => $config->dplusdbname,
				'NEWCUSTOMER' => false,
				'BILLTONAME' => $customer->name,
				'BILLTOADDRESS1' => $customer->addr1,
				'BILLTOADDRESS2' => $customer->addr2,
				'BILLTOADDRESS3' => $input->post->text('billto-address3'),
				'BILLTOCITY' => $customer->city,
				'BILLTOSTATE' => $customer->state,
				'BILLTOZIP' => $customer->zip,
				'BILLTOCOUNTRY' => $input->post->text('billto-country'),
				'BILLTOPHONE' => str_replace('-', '', $customer->phone),
				'BILLTOFAX' => str_replace('-', '', $customer->faxnbr),
				'BILLTOEMAIL' => $customer->email,
				'SHIPTOID' => $shipto->shiptoid,
				'SHIPTONAME' => $shipto->name,
				'SHIPTOADDRESS1' => $shipto->addr1,
				'SHIPTOADDRESS2' => $shipto->addr2,
				'SHIPTOADDRESS3' => $input->post->text('shipto-address3'),
				'SHIPTOCITY' => $shipto->city,
				'SHIPTOSTATE' => $shipto->state,
				'SHIPTOZIP' => $shipto->zip,
				'SHIPTOCOUNTRY' => $input->post->text('shipto-country'),
				'SHIPTOPHONE' => str_replace('-', '', $shipto->phone),
				'SHIPTOFAX' => str_replace('-', '', $shipto->faxnbr),
				'SHIPTOEMAIL' => $shipto->email,
				'SALESPERSON1' => $input->post->text('salesperson1'),
				'SALESPERSON2' => $input->post->text('salesperson2'),
				'SALESPERSON3' => $input->post->text('salesperson3'),
				'PRICECODE' => $input->post->text('pricecode'),
				'CONTACT' => $customer->contact,
				'ARCONTACT' => $input->post->text('arcontact') == 'Y' ? "Y" : "N",
				'DUNCONTACT' => $input->post->text('duncontact') == 'Y' ? "Y" : "N",
				'BUYCONTACT' => $input->post->text('buycontact'),
				'CERCONTACT' => $input->post->text('cercontact') == 'Y' ? "Y" : "N",
				'ACKCONTACT' => $input->post->text('ackcontact') == 'Y' ? "Y" : "N",
				'EXTENSION' => $input->post->text('contact-ext'),
				'TITLE' => $input->post->text('contact-title'),
				'NOTES' => ''
			);
			$session->loc = $config->pages->customer.'redir/?action=load-new-customer';
			break;
		case 'load-new-customer':
			$custID = get_createdordn(session_id());
			$session->sql = Customer::change_custid(session_id(), $custID);
			$customer = Customer::load($custID);
			$shipto = Customer::load($custID, '1');
			$customer->create_custpermpermission($user->loginid);
			$shipto->create_custpermpermission($user->loginid);

			$session->loc = $config->pages->custinfo."$custID/";

			if (!empty($shipID)) {
				$session->loc = $config->pages->custinfo."$custID/shipto-$shipID/";
				$data = array('DBNAME' => $config->dplusdbname, 'CISHIPTOINFO' => false, 'CUSTID' => $custID, 'SHIPID' => $shipID);
			} else {
				$data = array('DBNAME' => $config->dplusdbname, 'CICUSTOMER' => false, 'CUSTID' => $custID);
			}
			break;
		case 'load-customer':
			$session->loc = $config->pages->custinfo."$custID/";
			if (!empty($shipID)) {
				$session->loc = $config->pages->custinfo."$custID/shipto-$shipID/";
				$data = array('DBNAME' => $config->dplusdbname, 'CISHIPTOINFO' => false, 'CUSTID' => $custID, 'SHIPID' => $shipID);
			} else {
				$data = array('DBNAME' => $config->dplusdbname, 'CICUSTOMER' => false, 'CUSTID' => $custID);
			}
			break;
		case 'shop-as-customer':
			$cart = new CartQuote();
			$cart->set('sessionid', session_id());
			$cart->set('custid', "$custID");
			$cart->set('shiptoid', "$shipID");
			$session->sql = $cart->save(true);
			$cart->create();
			$data = false;
			
			if ($input->post->page) {
				$session->loc = $input->post->text('page');
			} elseif ($input->get->page) {
				$session->loc = $input->get->text('page');
			} else {
				$session->loc = $config->pages->cart;
			}
			break;
		case 'add-contact':
			$contact = new Contact();
			$contact->set('custid', $custID);
			$contact->set('shiptoid', $shipID);
			$contact->set_contacttype();
			$contact->set('contact', $input->post->text('contact-name'));
			$contact->set('title', $input->post->text('contact-title'));
			$contact->set('phone', $input->post->text('contact-phone'));
			$contact->set('extension', $input->post->text('contact-extension'));
			$contact->set('faxnbr', $input->post->text('contact-fax'));
			$contact->set('cellphone', $input->post->text('contact-cellphone'));
			$contact->set('email', $input->post->text('contact-email'));
			$contact->set('arcontact', $input->post->text('arcontact') == 'Y' ? "Y" : "N");
			$contact->set('dunningcontact', $input->post->text('duncontact') == 'Y' ? "Y" : "N");
			$contact->set('buyingcontact', $input->post->text('buycontact'));
			$contact->set('certcontact', $input->post->text('certcontact') == 'Y' ? "Y" : "N");
			$contact->set('ackcontact', $input->post->text('ackcontact') == 'Y' ? "Y" : "N");
			$contact->create();

			$data = array(
				'DBNAME' => $config->dplusdbname,
				'ADDCONTACT' => false,
				'CUSTID' => $custID,
				'SHIPID' => $shipID,
				'CONTACT' => $contact->contact,
				'TITLE' => $contact->title,
				'PHONE' => str_replace('-', '', $contact->phone),
				'EXTENSION' => $contact->extension,
				'FAX' => str_replace('-', '', $contact->faxnbr),
				'EMAIL' => $contact->email,
				'CELLPHONE' => str_replace('-', '', $contact->cellphone),
				'ARCONTACT' => $contact->arcontact,
				'DUNCONTACT' => $contact->dunningcontact,
				'ACKCONTACT' => $contact->ackcontact,
				'BUYCONTACT' => $contact->buyingcontact,
				'CERCONTACT' => $contact->certcontact,
			);
			break;
		case 'edit-contact':
			$custID = $input->post->text('custID');
			$shipID = $input->post->text('shipID');
			$contactID = $input->post->text('contactID');
			$newcontactID = $input->post->text('contact-name');

			$contact = Contact::load($custID, $shipID, $contactID, false);
			$contact->set('title', $input->post->text('contact-title'));
			$contact->set('phone', $input->post->text('contact-phone'));
			$contact->set('extension', $input->post->text('contact-extension'));
			$contact->set('faxnbr', $input->post->text('contact-fax'));
			$contact->set('cellphone', $input->post->text('contact-cellphone'));
			$contact->set('email', $input->post->text('contact-email'));
			$contact->set('arcontact', $input->post->text('arcontact') == 'Y' ? "Y" : "N");
			$contact->set('dunningcontact', $input->post->text('duncontact') == 'Y' ? "Y" : "N");
			$contact->set('buyingcontact', $input->post->text('buycontact'));
			$contact->set('certcontact', $input->post->text('certcontact') == 'Y' ? "Y" : "N");
			$contact->set('ackcontact', $input->post->text('ackcontact') == 'Y' ? "Y" : "N");

			$session->sql = $contact->update();
			if ($newcontactID != $contact->contact) {
				$session->sql .= "<br>" . $contact->change_contactid($newcontactID);
				$contact->set('contact', $newcontactID);
			}

			$data = array(
				'DBNAME' => $config->dplusdbname,
				'EDITCONTACT' => false,
				'CUSTID' => $custID,
				'SHIPID' => $shipID,
				'CONTACT' => $contactID,
				'NAME' => $contact->contact,
				'TITLE' => $contact->title,
				'PHONE' => str_replace('-', '', $contact->phone),
				'EXTENSION' => $contact->extension,
				'FAX' => str_replace('-', '', $contact->faxnbr),
				'EMAIL' => $contact->email,
				'CELLPHONE' => str_replace('-', '', $contact->cellphone),
				'ARCONTACT' => $contact->arcontact,
				'DUNCONTACT' => $contact->dunningcontact,
				'ACKCONTACT' => $contact->ackcontact,
				'BUYCONTACT' => $contact->buyingcontact,
				'CERCONTACT' => $contact->certcontact
			);
			$returnpage = new \Purl\Url($input->post->text('page'));
			$returnpage->query->set('contactID', $contact->contact);

			$oldlinks = new UserAction();
			$oldlinks->set('customerlink', $custID);
			$oldlinks->set('shiptolink', $shipID);

			$newlinks = UserAction::create_fromobject($oldlinks);
			$newlinks->set('contactlink', $contact->contact);

			$oldlinks->set('contactlink', $contactID);

			if ($contactID != $contact->contact) {
				$session->sql .= "<br>" . update_useractionlinks($oldlinks, $newlinks, true);
				update_useractionlinks($oldlinks, $newlinks);
			}
			$session->loc = $returnpage->getUrl();
			break;
		case 'ci-buttons':
			$data = array('DBNAME' => $config->dplusdbname, 'CIBUTTONS' => false);
			break;
		case 'ci-customer':
			$data = array('DBNAME' => $config->dplusdbname, 'CICUSTOMER' => false, 'CUSTID' => $custID);
			$session->loc = $config->pages->custinfo."$custID/";
			break;
		case 'ci-shiptos':
			$data = array('DBNAME' => $config->dplusdbname, 'CISHIPTOLIST' => false, 'CUSTID' => $custID);
			break;
		case 'ci-shipto-info':
			$shipID = $input->get->text('shipID');
			$data = array('DBNAME' => $config->dplusdbname, 'CISHIPTOINFO' => false, 'CUSTID' => $custID, 'SHIPID' => $shipID);
			$session->loc = $config->pages->custinfo."$custID/shipto-$shipID/";
			break;
		case 'ci-shipto-buttons':
			$data = array('DBNAME' => $config->dplusdbname, 'CISTBUTTONS' => false);
			break;
		case 'ci-pricing':
			$itemID = $input->get->text('itemID');
			$data = array('DBNAME' => $config->dplusdbname, 'CIPRICE' => false, 'ITEMID' => $itemID, 'CUSTID' => $custID);
			break;
		case 'ci-contacts': 
			$shipID = $input->get->text('shipID');
			$data = array('DBNAME' => $config->dplusdbname, 'CICONTACT' => false, 'CUSTID' => $custID, 'SHIPID' => $shipID);
			break;
		case 'ci-documents':
			$custname = Customer::get_customernamefromid($custID);
			$data = array('DBNAME' => $config->dplusdbname, 'DOCVIEW' => false, 'FLD1CD' => 'CU', 'FLD1DATA' => $custID, 'FLD1DESC' => $custname);
			break;
		case 'ci-order-documents':
			$ordn = $input->get->text('ordn');
			$type = $input->get->text('type');
			$data = array('DBNAME' => $config->dplusdbname, 'DOCVIEW' => false, 'FLD1CD' => $config->documentstoragetypes[$type], 'FLD1DATA' => $ordn);
			break;
		case 'ci-quote-documents':
			$qnbr = $input->get->text('qnbr');
			$type = $input->get->text('type');
			$data = array('DBNAME' => $config->dplusdbname, 'DOCVIEW' => false, 'FLD1CD' => $config->documentstoragetypes[$type], 'FLD1DATA' => $qnbr);
			break;
		case 'ci-standing-orders':
			$shipID = $input->get->text('shipID');
			$data = array('DBNAME' => $config->dplusdbname, 'CISTANDORDR' => false, 'CUSTID' => $custID, 'SHIPID' => $shipID);
			break;
		case 'ci-credit':
			$data = array('DBNAME' => $config->dplusdbname, 'CICREDIT' => false, 'CUSTID' => $custID);
			break;
		case 'ci-open-invoices':
			$data = array('DBNAME' => $config->dplusdbname, 'CIOPENINV' => false, 'CUSTID' => $custID);
			break;
		case 'ci-quotes':
			$data = array('DBNAME' => $config->dplusdbname, 'CIQUOTE' => false, 'CUSTID' => $custID);
			break;
		case 'ci-payments':
			$data = array('DBNAME' => $config->dplusdbname, 'CIPAYMENT' => false, 'CUSTID' => $custID);
			break;
		case 'ci-sales-orders':
			$shipID = $input->get->text('shipID');
			$data = array('DBNAME' => $config->dplusdbname, 'CISALESORDR' => false, 'CUSTID' => $custID, 'SHIPID' => $shipID, 'SALESORDRNBR' => '', 'ITEMID' => '');
			break;
		case 'ci-sales-history':
			$shipID = $input->get->text('shipID');
			$itemID = $input->get->text('itemID');
			$date = $input->get->text('startdate');
			$session->date = $date;
			$startdate = date('Ymd', strtotime($date));
			$data = array('DBNAME' => $config->dplusdbname, 'CISALESHIST' => false, 'CUSTID' => $custID, 'SHIPID' => $shipID, 'DATE' => $startdate, 'SALESORDRNBR' => '', 'ITEMID' => $itemID);
			break;
		case 'ci-custpo':
			$custpo = $input->get->text('custpo');
			$shipID = $input->get->text('shipID');
			$data = array('DBNAME' => $config->dplusdbname, 'CICUSTPO' => false, 'CUSTID' => $custID, 'SHIPID' => $shipID, 'CUSTPO' => $custpo);
			break;
	}
	
	if (!empty($data)) {
		writedplusfile($data, $filename);
		curl_redir("127.0.0.1/cgi-bin/".$config->cgis['default']."?fname=$filename");
	}
	
	if (!empty($session->get('loc')) && !$config->ajax) {
		header("Location: $session->loc");
	}
	exit;
