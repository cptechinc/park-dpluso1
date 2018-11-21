<?php
	if ($input->get->ordn) { $ordn = $input->get->text('ordn'); } else { $ordn = NULL; }
	if ($input->get->qnbr) { $qnbr = $input->get->text('qnbr'); } else { $qnbr = NULL; }

    $filteron = $input->urlSegment(2);
    switch ($filteron) {
        case 'dplus':
			$notetype = $sanitizer->text($input->urlSegment(3));
			$linenbr = $input->get->text('linenbr');
			switch ($notetype) {
				case 'order':
					$ordn = $input->get->text('ordn');
					$page->title = 'Reviewing Sales Order Notes for Order #' . $ordn . ' Line #' . $linenbr;
					$page->body = $config->paths->content.'notes/dplus/sales-order-notes.php';
					break;
				case 'quote':
					$qnbr = $input->get->text('qnbr');
					$page->title = 'Reviewing Quote Notes for Quote #' . $qnbr . ' Line #' . $linenbr;
					$page->body = $config->paths->content.'notes/dplus/quote-notes.php';
					break;
				case 'cart':
					$page->title = 'Reviewing Cart Notes for Line #' . $linenbr;
					$page->body = $config->paths->content.'notes/dplus/cart-notes.php';
					break;
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
		include $config->paths->content.'common/include-blank-page.php';
	}

?>
