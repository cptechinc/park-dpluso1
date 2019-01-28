<?php
	header('Content-Type: application/json');

    if (isset($input->post)) {
        $action = $input->post->text('action');

        $task = new UserAction();
        $task->set('actiontype', 'task');
        $task->set('actionsubtype', $input->post->text('subtype'));
        $task->set('customerlink', $input->post->text('customerlink'));
        $task->set('shiptolink', $input->post->text('shiptolink'));
        $task->set('contactlink', $input->post->text('contactlink'));
        $task->set('salesorderlink', $input->post->text('salesorderlink'));
        $task->set('quotelink', $input->post->text('quotelink'));
        $task->set('title', $input->post->text('title'));
        $task->set('textbody', $input->post->purify('textbody'));
        $task->set('actionlink', $input->post->text('actionlink'));
        $task->set('datecreated', date(UserAction::$dateformat));
        $task->set('duedate', date(UserAction::$dateformat, strtotime($input->post->text('duedate'))));
		$task->set('assignedto', $input->post->text('assignedto'));
        $task->set('createdby', $user->loginid);
        $task->set('assignedby', $user->loginid);

		//FOR QUOTES AND orders
		if (empty($task->customerlink)) {
			if (!empty($task->salesorderlink)) {
				$task->set('customerlink', SalesOrder::find_custid($task->salesorderlink));
				$task->set('shiptolink', SalesOrder::find_shiptoid($task->salesorderlink));
			} elseif (!empty($task->quotelink)) {
				$task->set('customerlink', get_custidfromquote(session_id(), $task->quotelink));
				$task->set('shiptolink', get_shiptoidfromquote(session_id(), $task->quotelink));
			}
		}

        $maxrec = UserAction::get_maxid($user->loginid);

		$session->sql = $task->save(true);
        $success = $task->save();

        $session->insertedid = $task->id;


		if ($success) {
			switch ($action) {
				case 'reschedule-task':
					$originaltask = UserAction::load($task->actionlink);
					$originaltask->set('datecompleted', '0000-00-00 00:00:00');
					$originaltask->set('dateupdated', date("Y-m-d H:i:s"));
					$originaltask->set('completed', 'R');
					$originaltask->set('rescheduledlink', $task->id);
					$response = $originaltask->update();
					$session->sql .= '<br>'.$session->sql;
					$error = false;
					$message = "<strong>Success!</strong><br> Your task for {replace} has been rescheduled";
					$icon = "glyphicon glyphicon-floppy-saved";
					$message = $task->generate_message($message);
					break;
				default:
					$error = false;
					$message = "<strong>Success!</strong><br> Your task for {replace} has been created";
					$icon = "glyphicon glyphicon-floppy-saved";
					$message = $task->generate_message($message);
					break;
			}
		} else {
			$error = true;
			$message = "<strong>Error!</strong><br> Your task could not be created";
			$icon = "glyphicon glyphicon-warning-sign";
		}

		$json = array (
			'response' => array (
				'error' => $error,
				'notifytype' => 'success',
				'message' => $message,
				'icon' => $icon,
				'actionid' => $task->id,
				'actiontype' => $task->actiontype
			)
		);
	} else {
		$json = array (
			'response' => array (
				'error' => true,
				'notifytype' => 'danger',
				'message' => '<strong>Error!</strong><br> Your task could not be created',
				'icon' => 'glyphicon glyphicon-warning-sign',
			)
		);
	}
    echo json_encode($json);
