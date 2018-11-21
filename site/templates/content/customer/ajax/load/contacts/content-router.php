<?php
	$custID = $input->get->text('custID');
	$shipID = $input->get->text('shipID');
	
    if (!empty($input->get->q)) {
        $page->title = "Searching for '".$input->get->text('q')."'";
    } else {
		$page->title = 'Searching Contacts  at ' . $custID;
    }
    
    if ($input->get->function) {
        $function = $input->get->text('function');
    }

    $page->body = $config->paths->content."customer/ajax/load/contacts/search-form.php";
