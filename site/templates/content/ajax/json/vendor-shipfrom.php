<?php
	header('Content-Type: application/json');
    $vendorID = $input->get->text('vendorID');

    $shipFrom = getvendorshipfroms($vendorID, false);
    if (empty($shipFrom)) {
        echo json_encode(array("response" => array("error" => false, 'shipfroms' => array())));
    } else {
        echo json_encode(array("response" => array("error" => false, "shipfroms" => $shipFrom)));
    }
