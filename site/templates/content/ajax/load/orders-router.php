<?php
	$filteron = $input->urlSegment(2);
	$ordn = ($input->get->ordn) ? $input->get->text('ordn') : NULL;

	switch ($filteron) {
		case 'cust':
			$custID = $sanitizer->text($input->urlSegment(3));
			$shipID = '';
			if ($input->urlSegment(4)) {
				if (strpos($input->urlSegment(4), 'shipto') !== false) {
					$shipID = str_replace('shipto-', '', $input->urlSegment(4));
				}
			}
			$page->body = $config->paths->content.'customer/cust-page/sales-orders/orders-panel.php';
			break;
		case 'customer':
			$custID = $sanitizer->text($input->urlSegment(3));
			$shipID = '';
			if ($input->urlSegment(4)) {
				if (strpos($input->urlSegment(4), 'shipto') !== false) {
					$shipID = str_replace('shipto-', '', $input->urlSegment(4));
				}
			}
			$page->body = $config->paths->content.'customer/cust-page/sales-orders/orders-panel.php';
			break;
		default:
			$page->body = $config->paths->content.'dashboard/sales-orders/sales-orders-panel.php';
			break;
	}


	if ($config->ajax) {
		if ($config->modal) {
			include $config->paths->content.'common/modals/include-ajax-modal.php';
		} else {
			include($page->body);
		}
	} else {
		include $config->paths->content."common/include-blank-page.php";
	}
