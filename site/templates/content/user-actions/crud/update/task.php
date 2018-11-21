<?php
	header('Content-Type: application/json');
	$taskID = $input->get->text('id');
	$task = UserAction::load($taskID);

	if ($input->get->text('complete') == 'true') {
		$task->set('datecompleted', date(UserAction::$dateformat));
		$task->set('completed', 'Y');
	} else {
		$task->set('datecompleted', '0000-00-00 00:00:00');
		$task->set('completed', ' ');
	}

	if (!empty($input->post->reflectnote)) {
		$task->set('reflectnote', $input->post->text('reflectnote'));
	}

	$task->set('dateupdated', date(UserAction::$dateformat));

	$response = $task->update();
	$session->sql = $response['sql'];

	if ($response['error']) {
		$json = array (
				'response' => array (
					'error' => true,
					'notifytype' => 'warning',
					'message' => 'Your task was not able to be updated',
					'icon' => 'glyphicon glyphicon-floppy-remove',
					'taskid' => $taskID,
				)
			);
	} else {
		$json = array (
			'response' => array (
				'error' => false,
				'notifytype' => 'success',
				'message' => 'Your task has been marked as complete',
				'icon' => 'glyphicon glyphicon-floppy-saved',
				'taskid' => $taskID,
			)
		);
	}

	echo json_encode($json);
