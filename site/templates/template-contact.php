<?php
	$custID = $input->get->text('custID');
	$shipID = $input->get->text('shipID');
	$contactID = $input->get->text('contactID');
	$page->body = $config->paths->content.'customer/contact/contact-page.php';
	$contact = Contact::load($custID, $shipID, $contactID);

    if ($contact) {
        if (Contact::can_useraccess($custID, $shipID, $contactID)) {
            $page->title = $contact->contact . ", ".$contact->get_customername();
            $page->body = $config->paths->content.'customer/contact/contact-page.php';

            if ($config->ajax) {
        		if ($config->modal) {
        			include $config->paths->content."common/modals/include-ajax-modal.php";
        		} else {
        			include $page->body;
        		}
        	} else {
        		include $config->paths->content."common/include-page.php";
        	}
        } else {
            $page->title = "Error";
            $page->body = "You don't have access to this contact";
            include $config->paths->templates."basic-page.php";
        }
    } else {
        $page->title = "Error";
        $page->body = "Contact $custID $shipID $contactID Not Found";
        include $config->paths->templates."basic-page.php";
    }
