<?php
	header('Content-Type: application/json'); 
	
	$key1 = $input->get->text('key1');
	$key2 = $input->get->text('key2');
	$type = $input->get->text('type');

	if ($input->get->recnbr) {
		$recnbr = $input->get->text('recnbr');
		$dplusnotes = get_qnote(session_id(), $key1, $key2, $type, $recnbr) ;
		$response = array('note' => $dplusnotes);
	} else {
		$dplusnotes = get_qnotes(session_id(), $key1, $key2, $type);
		$response = array('notes' => $dplusnotes);
	}
	
	echo json_encode($response);
