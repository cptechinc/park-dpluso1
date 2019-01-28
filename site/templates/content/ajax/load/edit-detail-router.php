<?php
    $edittype = $input->urlSegment(2); // CART || SALE
    $linenbr = $sanitizer->text($input->get->line);
    if ($input->get->vendorID) {
        $vendorID = $input->get->text('vendorID');
    }

    switch ($edittype) {
        case 'cart':
            $linedetail = CartDetail::load(session_id(), $linenbr);
            $page->title = 'Edit Pricing for '. $linedetail->itemid;
			$page->title .= (strlen($linedetail->vendoritemid)) ? ' &nbsp;'.$linedetail->vendoritemid : '';
            $custID = get_custidfromcart(session_id());
            $formaction = $config->pages->cart."redir/";
            $ordn = '';
			$page->body = $config->paths->content."edit/pricing/sales-orders/edit-pricing-form.php";
            break;
        case 'order':
            $ordn = $input->get->text('ordn');
            $order = SalesOrderHistory::is_saleshistory($ordn) ? SalesOrderHistory::load($ordn) : SalesOrder::load($ordn);
            $custID = $order->custid;
            $linedetail = SalesOrderDetail::load(session_id(), $ordn, $linenbr);

            if ($order->can_edit()) {
                $formaction = $config->pages->orders."redir/";
                $page->title = 'Edit Pricing for '. $linedetail->itemid;
				$page->title .= (strlen($linedetail->vendoritemid)) ? ' &nbsp;'.$linedetail->vendoritemid : '';
            } else {
                $formaction = '';
                $page->title = 'Viewing Details for '. $linedetail->itemid;
				$page->title .= (strlen($linedetail->vendoritemid)) ? ' &nbsp;'.$linedetail->vendoritemid : '';
            }
			$page->body = $config->paths->content."edit/pricing/sales-orders/edit-pricing-form.php";
            break;
		case 'quote':
			$qnbr = $input->get->text('qnbr');
			$custID = get_custidfromquote(session_id(), $qnbr);
			$linedetail = QuoteDetail::load(session_id(), $qnbr, $linenbr);
			$formaction = $config->pages->quotes."redir/";
            $page->title = 'Edit Pricing for '. $linedetail->itemid;
			$page->title .= (strlen($linedetail->vendoritemid)) ? ' &nbsp;'.$linedetail->vendoritemid : '';
			$page->body = $config->paths->content."edit/pricing/quotes/edit-pricing-form.php";
            break;
    }

	if ($config->ajax) {
        if ($config->modal) {
            include $config->paths->content."common/modals/include-ajax-modal.php";
        }
	} else {
		include $config->paths->content."common/include-blank-page.php";
	}


?>
