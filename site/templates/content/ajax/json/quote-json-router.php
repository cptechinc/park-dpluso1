<?php
 	header('Content-Type: application/json');
    $qnbr = $input->get->text('qnbr');

	switch ($input->urlSegment(2)) {
		case 'quotehead':
			$quote = get_quotehead(session_id(), $qnbr, false, false);
			echo json_encode(array("response" => array("quote" => $quote)));
			break;
		case 'details':
			$quotedetails = get_quotedetails(session_id(), $qnbr, false, false);
            $editurl = $config->pages->ajax.'load/edit-detail/quote/?qnbr='.$qnbr.'&line=';
    		echo json_encode(array("response" => array("quotedetails" => $quotedetails, "editurl" => $editurl)));
			break;
	}
