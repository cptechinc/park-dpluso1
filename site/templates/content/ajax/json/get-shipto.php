<?php
	header('Content-Type: application/json');
	$custID = $input->get->text('custID');
	$shipID = $input->get->text('shipID');

	$shipto = Customer::load($custID, $shipID, false);
	echo json_encode(array("response" => array("shipto" => $shipto->_toArray())));
