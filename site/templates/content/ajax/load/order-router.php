<?php
	$ordn = $input->get->text('ordn');

    switch ($input->urlSegment(2)) { //Parts of order to load
        case 'documents':
            include $config->paths->content.'edit/orders/documents-page.php';
            break;
		case 'tracking':
			include $config->paths->content.'edit/orders/tracking-page.php';
			break;
    }
