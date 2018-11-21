<?php
    $addtype = $input->urlSegment(2); // CART || ORDER | QUOTE
    $qnbr = $ordn = '';
    $custID = $input->get->text('custID');
    switch ($addtype) {
        case 'cart':
            $page->title = 'Add multiple items for your Cart';
            $formaction = $config->pages->cart."redir/";
            break;
        case 'order':
            $ordn = $input->get->text('ordn');
            $page->title = 'Add multiple items for Order #'. $ordn;
            $custID = SalesOrder::find_custid($ordn);
            $formaction = $config->pages->orders."redir/";
            break;
		case 'quote':
			$qnbr = $input->get->text('qnbr');
            $page->title = 'Add multiple items for Quote #'. $qnbr;
			$custID = get_custidfromquote(session_id(), $qnbr);
			$formaction = $config->pages->quotes."redir/";
            break;
    }

    if ($modules->isInstalled('QtyPerCase')) {
        $page->body = $config->paths->siteModules.'QtyPerCase/content/item-search/add-detail/add-multiple-form.php';
    } else {
        $page->body = $config->paths->content."products/ajax/load/add-multiple/add-multiple-item-form.php";
    }

	if ($config->ajax) {
        if ($config->modal) {
            include $config->paths->content."common/modals/include-ajax-modal.php";
        }
	} else {
		include $config->paths->content."common/include-blank-page.php";
	}
