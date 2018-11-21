<?php
    if ($input->get->q) {
        $function = $input->get->text('function');
        $dplusfunction = substr($input->get->text('function'), 0, 2);
        $page->title = "Searching for '".$input->get->text('q')."'";
    } else {
		$page->title = 'Search for a customer';
    }
    
    if ($input->get->function) {
        $function = $input->get->text('function');
        $dplusfunction = substr($input->get->text('function'), 0, 2);
    }

    $page->body = $config->paths->content."customer/ajax/load/cust-index/search-form.php";
?>
