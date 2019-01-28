<?php
	$config->scripts->append(hash_templatefile('scripts/libs/datatables.js'));
	$config->scripts->append(hash_templatefile('scripts/pages/dashboard.js'));
	$config->scripts->append(hash_templatefile('scripts/libs/raphael.js'));
	$config->scripts->append(hash_templatefile('scripts/libs/morris.js'));

	switch ($user->role) {
		default:
			$page->body = $config->paths->content.'dashboard/dashboard-page-outline.php';
			break;
	}
	include $config->paths->content."common/include-page.php";
