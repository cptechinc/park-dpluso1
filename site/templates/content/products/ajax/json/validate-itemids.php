<?php
	$invalidcount = 0;
	$itemarray = array();
	
	if ($input->get->itemID) {
		$items = $input->get->itemID;
		$custID = $input->get->text('custID');
		$itemarray = array('valid' => array(), 'invalid' => array());
		
		foreach ($items as $itemID) {
			$itemID = $sanitizer->text($itemID);
			$item = XRefItem::load($itemID, $custID);
			
			if ($item) {
				$itemarray['valid'][$itemID] = $itemID;
			} else {
				$itemarray['invalid'][$itemID] = $itemID;
			}
		}
		
		if (sizeof($itemarray['invalid'])) {
			if (empty($custID)) {
				$msg = 'No items with the itemIDs ' . implode($itemarray['invalid'], ', ') . ' have been found';
			} else {
				$msg = 'No items with the itemIDs ' . implode($itemarray['invalid'], ', ') . ' have been found with also using customer X-ref '.$custID.'';
			}
			
			$response = array (
				'error' => false,
				'invalid' => sizeof($itemarray['invalid']),
				'msg' => $msg,
				'items' => $itemarray
			);
		} else {
			$response = array (
				'error' => false,
				'invalid' => $invalidcount,
				'items' => $itemarray
			);
		}
	} else {
		$response = array (
			'error' => true,
			'errortype' => 'client',
			'msg' => 'No itemIDs were provided'
		);
	}
	echo json_encode($response);
