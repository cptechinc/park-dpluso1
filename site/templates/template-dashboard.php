<?php
	$config->scripts->append(hashtemplatefile('scripts/libs/datatables.js'));
	$config->scripts->append(hashtemplatefile('scripts/pages/dashboard.js'));
	$config->scripts->append(hashtemplatefile('scripts/libs/raphael.js'));
	$config->scripts->append(hashtemplatefile('scripts/libs/morris.js'));
	
	switch ($user->role) {
		default:
			$page->body = $config->paths->content.'dashboard/dashboard-page-outline.php'; 
			break;
	}
	
	include $config->paths->content."common/include-page.php";
