<?php 
	$custID = $input->get->text('custID');
	$shipID = $input->get->text('shipID');
	$customer = Customer::load($custID, $shipID);
	$primarycontact = Contact::load_primarycontact($custID, $shipID);
	
	$page->title = 'Adding Contact for ' . $customer->get_customername();
	$page->body = $config->paths->content.'customer/contact/add-contact.php';
	include $config->paths->content."common/include-page.php";
