<?php 
	$permission = (!empty($page->dplusfunction)) ? has_dpluspermission($user->loginid, $page->dplusfunction) : true;

	if ($permission) {
		if (!WhseSession::does_sessionexist(session_id())) {
			WhseSession::start_session(session_id());
		}
		include ($config->paths->content."{$page->path}page-logic.php"); 
	} else {
		include $config->paths->content."common/permission-denied-page.php";
	}
