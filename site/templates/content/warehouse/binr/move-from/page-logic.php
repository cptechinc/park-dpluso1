<?php
	$whsesession = WhseSession::load(session_id());
	$whsesession->init();
	$whseconfig = WhseConfig::load($whsesession->whseid);
	$frombin = $whseconfig->validate_bin($input->get->text('frombin')) ? $input->get->text('frombin') : '';

	if (!empty($frombin)) {
		include __DIR__ . "/../binr/page-logic.php";
	} else {
		$page->body =  __DIR__ . "/bin-form.php";
		$toolbar = false;
		$config->scripts->append(get_hashedtemplatefileURL('scripts/warehouse/_shared-functions.js'));
		$config->scripts->append(get_hashedtemplatefileURL('scripts/warehouse/move-from.js'));
		include $config->paths->content."common/include-toolbar-page.php";
	}
