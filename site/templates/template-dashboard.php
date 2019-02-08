<?php
	$config->scripts->append(get_hashedtemplatefileURL('scripts/pages/dashboard.js'));
	$config->scripts->append(get_hashedtemplatefileURL('scripts/libs/raphael.js'));
	$config->scripts->append(get_hashedtemplatefileURL('scripts/libs/morris.js'));

	switch ($user->role) {
		default:
			$page->body = $config->paths->content.'dashboard/dashboard-page-outline.php';
			break;
	}
	include $config->paths->content."common/include-page.php";
