<?php
	if ($input->get->itemID) {
		$itemID = $input->get->text('itemID');
		$custID = $input->get->text('custID');
		
		// Check if Item Exists
		$item_exists = XRefItem::exists($itemID, $custID);
		$item = XRefItem::load($itemID, $custID);
		
		// Then check if the item is active because for now if the item is inactive we show it as undiscoverable.
		if ($item) {
			$item_exists = $item->is_active() ? true : false;
		} else {
			$item_exists = false;
		}
		
		if ($item_exists) {
			$response = array (
				'error' => false,
				'exists' => true,
				'itemID' => $item->itemid
			);
		} else {
			if (empty($custID)) {
				$msg = 'No item with the itemID ' . $itemID . ' has been found';
			} else {
				$msg = 'No item with the itemID ' . $itemID . ' has been found with also using customer X-ref '.$custID.'';
			}
			$response = array (
				'error' => false,
				'exists' => false,
				'msg' => $msg
			);
		}
	} else {
		$response = array (
			'error' => true,
			'errortype' => 'client',
			'msg' => 'No itemID was provided'
		);
	}

	echo json_encode($response);
