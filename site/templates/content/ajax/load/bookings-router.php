<?php

	$filteron = $input->urlSegment(2);

	switch ($filteron) {
		case 'customer':
			$custID = $sanitizer->text($input->urlSegment(3));
			$shipID = '';
			if ($input->urlSegment(4)) {
				if (strpos($input->urlSegment(4), 'shipto') !== false) {
					$shipID = str_replace('shipto-', '', $input->urlSegment(4));
				}
			}
			$customer = Customer::load($custID, $shipID);
			$page->title = $customer->get_customername() . " bookings";
			$page->body = $config->paths->content.'customer/cust-page/bookings/bookings-panel.php';
			break;
		case 'sales-orders':
			$date = Dplus\Base\DplusDateTime::format_date($input->get->text('date'));
			$custID = $input->get->text('custID');
			$shipID = $input->get->text('shipID');


			if (!empty($input->get->custID)) {
				$customer = Customer::load($custID, $shipID);
				$page->title = "Viewing bookings for {$customer->get_customername()} made on $date";
				$page->body = $config->paths->content.'customer/cust-page/bookings/sales-orders-by-day.php';
			} else {
				$page->title = "Viewing bookings made on $date";
				$page->body = $config->paths->content.'dashboard/bookings/sales-orders-by-day.php';
			}


			break;
		case 'sales-order':
			$ordn = $input->get->text('ordn');
			$date = Dplus\Base\DplusDateTime::format_date($input->get->text('date'));
			$page->title = "Viewing Sales Order # $ordn on $date";
			$page->body = $config->paths->content.'bookings/sales-order-diff.php';
			break;
		default:
			$page->body = $config->paths->content.'dashboard/bookings/bookings-panel.php';
			break;
	}

	if ($config->ajax) {
		if ($config->modal) {
			include $config->paths->content.'common/modals/include-ajax-modal.php';
		} else {
			include($page->body);
		}
	} else {
		$config->scripts->append(get_hashedtemplatefileURL('scripts/libs/raphael.js'));
		$config->scripts->append(get_hashedtemplatefileURL('scripts/libs/morris.js'));
		include $config->paths->content."common/include-blank-page.php";
	}
