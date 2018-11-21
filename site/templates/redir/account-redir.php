<?php
	/**
	* ACCOUNT REDIRECT
	* @param string $action
	*
	*/
	$action = ($input->post->action ? $input->post->text('action') : $input->get->text('action'));

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

	/**
	* ACCOUNT REDIRECT
	*
	*
	*
	*
	* switch ($action) {
	*	case 'login':
	*		DBNAME=$config->DBNAME
	*		LOGPERM
	*		LOGINID=$username
	*		PSWD=$password
	*		break;
	*	case 'logout':
	*		DBNAME=$config->DBNAME
	*		LOGOUT
	*		break;
	* }
	*
	**/

	switch ($action) {
		case 'login':
			if ($input->post->username) {
				$username = $input->post->text('username');
				$password = $input->post->text('password');
				$data = array('DBNAME' => $config->dplusdbname, 'LOGPERM' => false, 'LOGINID' => $username, "PSWD" => $password);
				$session->loggingin = true;
				$session->loc = $config->pages->index.'redir/';
			}
			break;
		case 'permissions':
			$data = array('DBNAME' => $config->dplusdbname, 'FUNCPERM' => false);
			break;
		case 'logout':
			$data = array('DBNAME' => $config->dplusdbname, 'LOGOUT' => false);
			$session->loc = $config->pages->login;
			$session->remove('shipID');
			$session->remove('custID');
			$session->remove('locked-ordernumber');
			
			if (WhseSession::does_sessionexist(session_id())) {
				$whsesession = WhseSession::load(session_id());
				$whsesession->end_session();
			}
			break;
		case 'store-document':
			$folder = $input->get->text('filetype');
			$file = $input->get->text('file');
			$field1 = $input->get->text('field1');
			$field2 = $input->get->text('field2');
			$field3 = $input->get->text('field3');
			$data = array(
				'DBNAME' => $config->dplusdbname,
				'DOCFILEFLDS' => $folder,
				'DOCFILENAME' => $config->documentstoragedirectory.$file,
				'DOCFLD1' => $field1,
				'DOCFLD2' => $field2,
				'DOCFLD3' => $field3
			);
			break;
	}

	writedplusfile($data, $filename);
	curl_redir("127.0.0.1/cgi-bin/".$config->cgis['default']."?fname=$filename");
	if (!empty($session->get('loc')) && !$config->ajax) {
		header("Location: $session->loc");
	}
	exit;
