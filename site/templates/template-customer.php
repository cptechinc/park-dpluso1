<?php
	$page->title = ($input->get->q) ? "Searching for '".$input->get->text('q')."'" : "Customer Index";
	$page->body = $config->paths->content."customer/ajax/load/cust-index/search-form.php";

	if ($config->ajax) {
		if ($config->modal) {
			include $config->paths->content."common/modals/include-ajax-modal.php";
		} else {
			include $page->body;
		}
	} else {
		include $config->paths->content."common/include-page.php";
	}
