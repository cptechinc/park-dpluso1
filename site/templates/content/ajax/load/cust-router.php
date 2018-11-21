<?php
    switch ($input->urlSegment(2)) {
        case 'cust-index':
            include $config->paths->content.'customer/ajax/load/cust-index/content-router.php';
            break;
		case 'contacts':
			include $config->paths->content.'customer/ajax/load/contacts/content-router.php';
			break;
    }

	if ($config->ajax) {
		if ($config->modal) {
			include $config->paths->content."common/modals/include-ajax-modal.php";
		} else {
			include $page->body;
		}
	} else {
		include $config->paths->content."common/include-blank-page.php";
	}




 ?>
