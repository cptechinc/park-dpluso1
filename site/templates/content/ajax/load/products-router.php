<?php
	$qnbr = $input->get->text('qnbr');
	$ordn = $input->get->text('ordn');
    $filteron = $input->urlSegment(2);
    switch ($filteron) {
        case 'item-search-results':
            $custID = $input->get->text('custID');
            $shipID = $input->get->text('shipID');
            $page->body = $config->paths->content.'products/ajax/load/product-results/product-results.php';
			switch($input->urlSegment(3)) {
				case 'cart':
					$page->title = 'Add item to the cart';
					break;
				case 'order':
					$page->title = 'Add item to order #'.$ordn;
					break;
				case 'quote':
					$page->title = 'Add item to quote # ' . $qnbr;
					break;
			}
            break;
        case 'non-stock':
            switch($input->urlSegment(3)) {
				default:
					$page->title = 'Add Non-stock Item';
					$addtype = $input->urlSegment(4);
					switch ($addtype) {
						case 'cart':
							$custID = CartQuote::get_cartcustid(session_id());
				            $formaction = $config->pages->cart."redir/";
				            $ordn = '';
				            break;
				        case 'sales-order':
				            $ordn = $input->get->text('ordn');
				            $custID = SalesOrder::find_custid($ordn);
							$formaction = $config->pages->orders."redir/";
				            break;
						case 'quote':
							$qnbr = $input->get->text('qnbr');
							$custID = get_custidfromquote(session_id(), $qnbr);
							$formaction = $config->pages->quotes."redir/";
					}
					$page->body = $config->paths->content.'products/non-stock/non-stock-item-form.php';
					break;
            }
            break;
		case 'choose-vendor':
			$page->title = 'Choose a Vendor';
			$page->body = $config->paths->content.'products/vendor/choose-vendor.php';
			break;
		case 'quick-entry-search':
			if ($modules->isInstalled('CaseQtyBottle')) {
				$page->body = $config->paths->siteModules.'CaseQtyBottle/content/item-search/quick-entry-search-results.php';
			} else {
				$page->body = $config->paths->content.'products/ajax/load/quick-entry-search-results.php';
			}
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
?>
