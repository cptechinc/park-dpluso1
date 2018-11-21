<?php
	$filteron = $input->urlSegment(2);
	$qnbr = $input->get->text('qnbr');
	
	switch ($filteron) {
		case 'cust':
			$custID = $sanitizer->text($input->urlSegment(3));
			$shipID = '';
			if ($input->urlSegment(4)) {
				if (strpos($input->urlSegment(4), 'shipto') !== false) {
					$shipID = str_replace('shipto-', '', $input->urlSegment(4));
				}
			}
			$page->body = $config->paths->content.'customer/cust-page/quotes/quotes-panel.php';
			break;
		case 'customer':
			$custID = $sanitizer->text($input->urlSegment(3));
			$shipID = '';
			if ($input->urlSegment(4)) {
				if (strpos($input->urlSegment(4), 'shipto') !== false) {
					$shipID = str_replace('shipto-', '', $input->urlSegment(4));
				}
			}
			$page->body = $config->paths->content.'customer/cust-page/quotes/quotes-panel.php';
			break;
		case 'search':
            $searchtype = $sanitizer->text($input->urlSegment(3));
            switch ($searchtype) {
                case 'cust':
                    $custID = $input->get->text('custID');
                    $shipID = $input->get->text('shipID');
                    $page->body = $config->paths->content.'customer/cust-page/quotes/quote-search-form.php';
                    $page->title = "Searching through ".get_customername($custID)." Quotes";
                    break;
            }
			break;
		default:
			$page->body = $config->paths->content.'dashboard/quotes/quotes-panel.php';
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
