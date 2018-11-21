<?php
	// $task is loaded by Crud Controller
	$taskdisplay = new Dplus\Dpluso\UserActions\UserActionDisplay($page->fullURL);

	$contact = Contact::load($task->customerlink, $task->shiptolink, $task->contactlink);

	if ($task->is_rescheduled()) {
		$rescheduledtask = UserAction::load($task->rescheduledlink);
	}

	$task->get_actionlineage();
?>

<div>
	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#task" aria-controls="task" role="tab" data-toggle="tab">Task ID: <?= $task->id; ?></a></li>
		<?php if (!empty($task->actionlineage)) : ?>
			<li role="presentation"><a href="#history" aria-controls="history" role="tab" data-toggle="tab">Task History</a></li>
		<?php endif; ?>
	</ul>
	<br>
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="task">
			<?php if ($config->ajax) : ?>
				<?= $page->bootstrap->create_element('p', '', $page->bootstrap->generate_printlink($config->filename, 'View Printable Version')); ?>
			<?php endif; ?>
			<?php include $config->paths->content."user-actions/crud/read/task-details.php"; ?>
		</div>
		<?php if (!empty($task->actionlineage)) : ?>
			<div role="tabpanel" class="tab-pane" id="history"><?php include $config->paths->content."user-actions/crud/read/task-history.php"; ?></div>
		<?php endif; ?>
	</div>
</div>
