<?php 
	$whsesession = WhseSession::load(session_id());
	$whsesession->init();
	$whseconfig = WhseConfig::load($whsesession->whseid);
	$tobin = $whseconfig->validate_bin($input->get->text('tobin')) ? $input->get->text('tobin') : '';
	
	if (!empty($tobin)) {	
		include __DIR__ . "/../binr/page-logic.php";
	} else {
		$page->body =  __DIR__ . "/bin-form.php";
		$toolbar = false;
		$config->scripts->append(get_hashedtemplatefileURL('scripts/warehouse/_shared-functions.js'));
		$config->scripts->append(get_hashedtemplatefileURL('scripts/warehouse/_validate-to-bin.js'));
		$config->scripts->append(get_hashedtemplatefileURL('scripts/warehouse/move-to.js'));
		include $config->paths->content."common/include-toolbar-page.php";
	}
