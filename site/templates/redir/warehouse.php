<?php
	// Figure out page request method, then grab needed inputs
	$requestmethod = $input->requestMethod('POST') ? 'post' : 'get';
	$action = $input->$requestmethod->text('action');

	// Set up filename and sessionID in case this was made through cURL
	$filename = ($input->$requestmethod->sessionID) ? $input->$requestmethod->text('sessionID') : session_id();
	$sessionID = ($input->$requestmethod->sessionID) ? $input->$requestmethod->text('sessionID') : session_id();

	$session->fromredirect = $page->url;
	
	


	/**
	* WAREHOUSE REDIRECT
	* USES the whseman.log
	*
	*
	*
	*
	* switch ($action) {
	* 	case 'initiate-whse':
	* 		- Logs into warehouse management creates whsesession record
	*		DBNAME=$config->dplusdbname
	*		LOGIN=$loginID
	*		break;
	*	case 'logout':
	*		- Logs out of warehouse management clears whsesession record
	*		DBNAME=$config->dplusdbname
	*		LOGOUT
	*		break;
	* }
	*
	**/
	switch ($action) {
		case 'initiate-whse':
			$login = get_loginrecord($sessionID);
			$loginID = $login['loginid'];
			$data = array("DBNAME=$config->dplusdbname", "LOGIN=$loginID");
			break;
		case 'logout':
			$data = array("DBNAME=$config->dplusdbname", 'LOGOUT');
			$session->loc = $config->pages->salesorderpicking;
			break;
	}
	
	write_dplusfile($data, $filename);
	$page->curl->get("127.0.0.1/cgi-bin/".$config->cgis['whse']."?fname=$filename");
	
	if (!empty($session->get('loc'))) {
		header("Location: $session->loc");
	}
	exit;
