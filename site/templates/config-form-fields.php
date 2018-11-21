<?php 

	if ($input->requestMethod() == "POST") {
		$formtype = $input->post->text('formtype');
		$action = $input->post->text('action');
		$formconfig = new FormFieldsConfig($formtype);
		$formconfig->generate_configfrominput($input);
		
		switch ($action) {
			case 'save':
				$page->body = $formconfig->save_andrespond();
				include $config->paths->content.'common/include-json-page.php';
				break;
		}
	} else {
		$page->body = $config->paths->content."configs/form-fields-config.php";
		include $config->paths->content.'common/include-page.php';
	}
