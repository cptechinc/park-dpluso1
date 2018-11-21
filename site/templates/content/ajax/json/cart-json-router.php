<?php
 	header('Content-Type: application/json');
    
	switch ($input->urlSegment(2)) {
		case 'get-added-items':
			$from = $input->get->text('from');
            switch ($from) {
                case 'salesorder':
                    $ordn = $input->get->text('ordn');
                    $details = get_orderdetails(session_id(), $ordn, true, false);
                    $msg = "The following items were added : <br>";
                    if ($details) {
                        foreach ($details as $detail) {
                            $msg .= $detail->itemid."<br>";
                        }
                        $response = array(
                            'error' => false,
                            'icon' => 'fa fa-shopping-cart',
                            'notifytype' => 'success',
                            'message' => $msg    
                        );
                    } else {
                        $response = array(
                            'error' => true,
                            'icon' => 'fa fa-exclamation-triangle',
                            'notifytype' => 'warning',
                            'message' => $ordn . ' Details were not able to be found'
                        );
                    }
                    echo json_encode(array('response' => $response));
                    break;
            }
			break;
        default: {
            echo json_encode(get_cartdetails(session_id(), false));
        }
	}
