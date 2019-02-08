<?php
	// Figure out page request method, then grab needed inputs
	$requestmethod = $input->requestMethod('POST') ? 'post' : 'get';
	$action = $input->$requestmethod->text('action');

	// Set up filename and sessionID in case this was made through cURL
	$filename = ($input->$requestmethod->sessionID) ? $input->$requestmethod->text('sessionID') : session_id();
	$sessionID = ($input->$requestmethod->sessionID) ? $input->$requestmethod->text('sessionID') : session_id();
	
	$session->fromredirect = $page->url;
	
	/**
	* ACCOUNT REDIRECT
	* @param string $action
	*
	*
	*
	* switch ($action) {
	*	case 'login':
	*		- Makes Login Request for user
	*		DBNAME=$config->DBNAME
	*		LOGPERM
	*		LOGINID=$username
	*		PSWD=$password
	*		break;
	*	case 'logout':
	*		- Makes Logout Request for user
	*		DBNAME=$config->DBNAME
	*		LOGOUT
	*		break;
	*	case 'permissions':
	*		- Makes Update funcperm Request for user
	*		DBNAME=$config->DBNAME
	*		FUNCPERM
	*		break;
	*	case 'store-document':
	*		- Makes a request to store Document (PDF) for document storage
	*		NOTE should be moved a different redir
	*		DBNAME=$config->DBNAME
	*		DOCFILEFLDS=$folder
	*		DOCFLD1=$field1
	*		DOCFLD2=$field2
	*		DOCFLD3=$field3
	*		break;
	* }
	*
	**/

	switch ($action) {
		case 'login':
			if ($input->post->username) {
				$username = $input->$requestmethod->text('username');
				$password = $input->$requestmethod->text('password');
				$data = array("DBNAME=$config->dplusdbname", 'LOGPERM', "LOGINID=$username", "PSWD=$password");
				$session->loggingin = true;
				$session->loc = $config->pages->index.'redir/';
			}
			break;
		case 'logout':
			$data = array("DBNAME=$config->dplusdbname", 'LOGOUT');
			$session->loc = $config->pages->login;
			$session->remove('shipID');
			$session->remove('custID');
			$session->remove('locked-ordernumber');
			
			if (WhseSession::does_sessionexist(session_id())) {
				$whsesession = WhseSession::load(session_id());
				$whsesession->end_session();
			}
			break;
		case 'permissions':
			$data = array("DBNAME=$config->dplusdbname", 'FUNCPERM');
			break;
		case 'store-document':
			$folder = $input->$requestmethod->text('filetype');
			$file = $input->$requestmethod->text('file');
			$field1 = $input->$requestmethod->text('field1');
			$field2 = $input->$requestmethod->text('field2');
			$field3 = $input->$requestmethod->text('field3');
			$data = array(
				"DBNAME=$config->dplusdbname",
				"DOCFILEFLDS=$folder",
				"DOCFILENAME=$config->documentstoragedirectory$file",
				"DOCFLD1=$field1",
				"DOCFLD2=$field2",
				"DOCFLD3=$field3"
			);
			break;
	}

	write_dplusfile($data, $filename);
	$page->curl->get("127.0.0.1/cgi-bin/".$config->cgis['default']."?fname=$filename");
	
	if (!empty($session->get('loc')) && !$config->ajax) {
		header("Location: $session->loc");
	}
	exit;
