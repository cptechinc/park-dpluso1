<?php
    switch ($input->urlSegment(2)) {
        case 'vend-index':
            include $config->paths->content.'vendor/ajax/load/vend-index/content-router.php';
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
