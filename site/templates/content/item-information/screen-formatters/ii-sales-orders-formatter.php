<?php 
	$tableformatter = $page->screenformatterfactory->generate_screenformatter('ii-sales-orders');
	
	if ($input->requestMethod() == "POST") {
		$tableformatter->generate_formatterfrominput($input);
		$action = $input->post->text('action');
		
		switch ($action) {
			case 'preview':
				$page->body = $config->paths->content."item-information/ii-formatted-screen.php";
				
				if ($config->ajax) {
					include $page->body;
				} else {
					include $config->paths->content.'common/include-blank-page.php';
				}
				break;
			case 'save-formatter':
				$maxid = get_maxtableformatterid($user->loginid, 'ii-sales-orders');
				$page->body = $tableformatter->save_andrespond();
				include $config->paths->content.'common/include-json-page.php';
				break;
		}
	} else {
		$page->body = $config->paths->content."item-information/screen-formatters/forms/ii-default.php";
		$config->scripts->append(hashtemplatefile('scripts/table-formatter.js'));
		include $config->paths->content.'common/include-page.php';
	}
