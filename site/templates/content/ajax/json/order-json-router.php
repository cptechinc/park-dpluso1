<?php
	header('Content-Type: application/json');
    $ordn = $input->get->text('ordn');


	switch ($input->urlSegment(2)) {
		case 'orderhead':
			$order = SalesOrderEdit::load(session_id(), $ordn);
			echo json_encode(array("response" => array("order" => $order->_toArray())));
			break;
		case 'details':
			$orderdetails = get_orderdetails(session_id(), $ordn, $useclass = false);
            $editurl = $config->pages->ajax.'load/edit-detail/order/?ordn='.$ordn.'&line=';
    		echo json_encode(array("response" => array("orderdetails" => $orderdetails, "editurl" => $editurl)));
			break;
	}
