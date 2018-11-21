<?php
	$filteron = $input->urlSegment(2);
	$ordn = ($input->get->ordn) ? $input->get->text('ordn') : NULL;
	
	switch ($filteron) {
		case 'customer':
			$custID = $input->urlSegment(3);
			$shipID = ($input->urlSegment(4)) ? urldecode(str_replace('shipto-', '', $input->urlSegment(4))) : '';
			$customer = Customer::load($custID, $shipID);
			$page->body = $config->paths->content.'customer/cust-page/sales-history/sales-history-panel.php';
			break;
		default:
			$page->body = $config->paths->content.'dashboard/sales-history/sales-history-panel.php';
			break;
	}

	if ($config->ajax) {
		if ($config->modal) {
			include $config->paths->content.'common/modals/include-ajax-modal.php';
		} else {
			include $page->body;
		}
	} else {
		include $config->paths->content."common/include-blank-page.php";
	}
