<?php
	switch ($input->get->text('edit')) {
		case 'reschedule':
			$message = "Rescheduling task for {replace} ";
			$page->body = $config->paths->content."user-actions/crud/update/task-reschedule-form.php";
			break;
		default: //TODO
			$message = "Editing task for {replace} ";
			$page->body = $config->paths->content."user-actions/crud/update/task-edit-form.php";
			break;
	}
	$page->title = $task->generate_message($message);
