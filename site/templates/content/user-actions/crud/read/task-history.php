<?php
	$count = 0;
	$tasklineage = $task->get_actionlineage();
	
	foreach ($tasklineage as $taskid) {
		$task = UserAction::load($taskid);
		$contact = Contact::load($task->customerlink, $task->shiptolink, $task->contactlink);

		if ($task->is_rescheduled()) {
			$rescheduledtask = UserAction::load($task->rescheduledlink);
		}

		include $config->paths->content."user-actions/crud/read/task-details.php";
		$count++;

		if ($count < sizeof($tasklineage)) {
			echo '<h3 class="text-center"><i class="fa fa-arrow-down" aria-hidden="true"></i></h3>';
		}
	}
