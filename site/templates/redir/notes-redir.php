<?php
	/**
	* NOTES REDIRECT
	* @param string $action
	*
	*/
	$date = date('Ymd');
	$time = date('His');

	$action = ($input->post->action ? $input->post->text('action') : $input->get->text('action'));

	$session->{'from-redirect'} = $page->url;
	if ($input->post->sessionID) {
		$filename = $input->post->text('sessionID');
		$sessionID = $input->post->text('sessionID');
	} elseif ($input->get->sessionID) {
		$filename = $input->get->text('sessionID');
		$sessionID = $input->get->text('sessionID');
	} else {
		$filename = session_id();
		$sessionID = session_id();
	}
	$session->action = $action;

	/**
	* NOTES REDIRECT
	*
	*
	*
	*
	* switch ($action) {
	*	case 'get-order-notes':
	*		DBNAME=$config->dplusdbname
	*		LQNOTE=SORD
	*		KEY1=$ordn
	*		KEY2=$linenbr
	*		break;
	*	case 'get-quote-notes':
	*		DBNAME=$config->dplusdbname
	*		LQNOTE=QUOT
	*		KEY1=$qnbr
	*		KEY2=$linenbr
	*		break;
	*	case 'get-cart-notes':
	*		DBNAME=$config->dplusdbname
	*		LOAD CART NOTES
	*		break;
	*	case 'edit-note':
	*		DBNAME=>$config->dplusdbname
	*		RQNOTE=$rectype
	*		KEY1=$key1,
	*		KEY2=$key2
	*		FORM1=$form1
	*		FORM2=$form2
	*		FORM3=$form3
	*		FORM4=$form4
	*		FORM5=$form5
	*		break;
	*	case 'add-note':
	*		DBNAME=>$config->dplusdbname
	*		RQNOTE=$rectype
	*		KEY1=$key1,
	*		KEY2=$key2
	*		FORM1=$form1
	*		FORM2=$form2
	*		FORM3=$form3
	*		FORM4=$form4
	*		FORM5=$form5
	* }
	*
	**/

	switch ($action) {
		case 'get-order-notes':
			$ordn = $input->get->text('ordn');
			$linenbr = $input->get->text('linenbr');
			$data = array('DBNAME' => $config->dplusdbname, 'LQNOTE' => 'SORD', 'KEY1' => $ordn, 'KEY2' => $linenbr);
			$session->loc = $config->pages->ajax."load/notes/dplus/order/?ordn=".$ordn."&linenbr=".$linenbr;
			if ($config->modal) {$session->loc .= "&modal=modal";}
			break;
		case 'get-quote-notes':
			$qnbr = $input->get->text('qnbr');
			$linenbr = $input->get->text('linenbr');
			$data = array('DBNAME' => $config->dplusdbname, 'LQNOTE' => 'QUOT', 'KEY1' => $qnbr, 'KEY2' => $linenbr);
			$session->loc = $config->pages->ajax."load/notes/dplus/quote/?qnbr=".$qnbr."&linenbr=".$linenbr;
			if ($config->modal) {$session->loc .= "&modal=modal";}
			break;
		case 'get-cart-notes':
			$linenbr = $input->get->text('linenbr');
			$data = array('DBNAME' => $config->dplusdbname, 'LOAD CART NOTES' => false);
			$session->loc = $config->pages->ajax."load/notes/dplus/cart/?linenbr=".$linenbr;
			if ($config->modal) {$session->loc .= "&modal=modal";}
			break;
		case 'edit-note':
			$type = $input->post->text('type');
			$recnbr = $input->post->text('recnbr');
			$key1 = $input->post->text('key1');
			$key2 = $input->post->text('key2');
			$note = Qnote::load(session_id(), $key1, $key2, $type, $recnbr);
			$note->set('form1', $input->post->form1 ? "Y" : "N");
			$note->set('form2', $input->post->form2 ? "Y" : "N");
			$note->set('form3', $input->post->form3 ? "Y" : "N");
			$note->set('form4', $input->post->form4 ? "Y" : "N");
			$note->set('form5', ($note->rectype == Qnote::get_qnotetype('sales-order')) ? '' : ($input->post->form5 ? "Y" : "N"));
			$note->set('notefld', addslashes($input->post->text('note')));
			$session->sql = $note->update();

			$data = array(
				'DBNAME' => $config->dplusdbname,
				'RQNOTE' => $note->rectype,
				'KEY1' => $note->key1,
				'KEY2' => $note->key2,
				'FORM1' => $note->form1,
				'FORM2' => $note->form2,
				'FORM3' => $note->form3,
				'FORM4' => $note->form4,
			);
			if ($note->rectype != Qnote::get_qnotetype('sales-order')) {
				$data['FORM5'] = $note->form5;
			}
			break;
		case 'add-note':
			$note = new QNote();
			$note->set('sessionid', $sessionID);
			$note->set('rectype', $input->post->text('type'));
			$note->set('key1', $input->post->text('key1'));
			$note->set('key2', $input->post->text('key2'));
			$note->set('form1', $input->post->form1 ? "Y" : "N");
			$note->set('form2', $input->post->form2 ? "Y" : "N");
			$note->set('form3', $input->post->form3 ? "Y" : "N");
			$note->set('form4', $input->post->form4 ? "Y" : "N");
			$note->set('form5', ($note->rectype == Qnote::get_qnotetype('sales-order')) ? '' : ($input->post->form5 ? "Y" : "N"));
			$note->set('notefld', addslashes($input->post->text('note')));
			$session->sql = $note->create();

			$data = array(
				'DBNAME' => $config->dplusdbname,
				'RQNOTE' => $note->rectype,
				'KEY1' => $note->key1,
				'KEY2' => $note->key2,
				'FORM1' => $note->form1,
				'FORM2' => $note->form2,
				'FORM3' => $note->form3,
				'FORM4' => $note->form4,
				'FORM5' => $note->form5
			);
			break;
	}

	writedplusfile($data, $filename);
	curl_redir("127.0.0.1/cgi-bin/".$config->cgis['default']."?fname=$filename");
	if (!empty($session->get('loc')) && !$config->ajax) {
		header("Location: $session->loc");
	}
	exit;
