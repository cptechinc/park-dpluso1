<?php 
	$tableformatter = $page->screenformatterfactory->generate_screenformatter('ci-open-invoices');
	
	if ($input->requestMethod() == "POST") {
		$tableformatter->generate_formatterfrominput($input);
		
		$action = $input->post->text('action');
		
		switch ($action) {
			case 'preview':
				$page->body = $config->paths->content."cust-information/ci-formatted-screen.php";
				
				if ($config->ajax) {
					include $page->body;
				} else {
					include $config->paths->content.'common/include-blank-page.php';
				}
				break;
			case 'save-formatter':
				$maxid = get_maxtableformatterid($user->loginid, 'ci-sales-history');
				$page->body = $tableformatter->save_andrespond();
				include $config->paths->content.'common/include-json-page.php';
				break;
		}
	} else {
		$page->body = $config->paths->content."cust-information/screen-formatters/forms/ci-default.php";
		$config->scripts->append(hashtemplatefile('scripts/table-formatter.js'));
		include $config->paths->content.'common/include-page.php';
	}
