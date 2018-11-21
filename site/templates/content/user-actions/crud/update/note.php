<?php
	header('Content-Type: application/json');

	if (isset($input->post)) {
		$action = $input->post->text('action');

		$note = new UserAction();
		$note->set('actiontype', 'note');
		$note->set('id', $input->post->text('id'));
		$note->set('actionsubtype', $input->post->text('subtype'));
		$note->set('customerlink', $input->post->text('customerlink'));
		$note->set('shiptolink', $input->post->text('shiptolink'));
		$note->set('contactlink', $input->post->text('contactlink'));
		$note->set('salesorderlink', $input->post->text('salesorderlink'));
		$note->set('quotelink', $input->post->text('quotelink'));
		$note->set('title', $input->post->text('title'));
		$note->set('textbody', $input->post->purify('textbody'));
		$note->set('datecreated', date("Y-m-d H:i:s"));
		$note->set('assignedto', $input->post->text('assignedto'));
		$note->set('createdby', $user->loginid);
		$note->set('assignedby', $user->loginid);
		$note->set('dateupdated', date("Y-m-d H:i:s"));
		
		if (empty($note->customerlink)) {
			if (!empty($note->salesorderlink)) {
				$note->set('customerlink', SalesOrder::find_custid($note->salesorderlink));
				$note->set('shiptolink', SalesOrder::find_shiptoid($note->salesorderlink));
			} elseif (!empty($note->quotelink)) {
				$note->set('customerlink', get_custidfromquote(session_id(), $note->quotelink));
				$note->set('shiptolink', get_shiptoidfromquote(session_id(), $note->quotelink));
			}
		}

		$results = $note->save();
		$session->sql = $results['sql'];

		if (!$results['error']) {
			$error = false;
			$notifytype = 'success';
			$message = "<strong>Success!</strong><br> Your note for {replace} has been updated";
			$icon = "glyphicon glyphicon-floppy-saved";
			$message = $note->generate_message($message);
		} else {
			$error = true;
			$notifytype = 'danger';
			$message = "<strong>Error!</strong><br> Your note could not be updated";
			$icon = "glyphicon glyphicon-warning-sign";
		}

		$json = array (
			'response' => array (
				'error' => $error,
				'notifytype' => $notifytype,
				'message' => $message,
				'icon' => $icon,
				'actionid' => $note->id,
				'actiontype' => $note->actiontype
			)
		);
	} else {
		$json = array (
			'response' => array (
				'error' => true,
				'notifytype' => 'danger',
				'message' => '<strong>Error!</strong><br> Your note could not be updated because data was not sent',
				'icon' => 'glyphicon glyphicon-warning-sign',
			)
		);
	}
	echo json_encode($json);
