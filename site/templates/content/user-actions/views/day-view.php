<?php
	$day = $input->get->day ? $input->get->text('day') : date('m/d/Y');
?>
<div class="panel-body">
	<h3><?= date('l, M jS Y', strtotime($day)); ?></h3>
	<div class="row">
		<div class="col-sm-6">
			<?php if (date('m/d/Y', strtotime($day)) != date('m/d/Y')) : ?>
				<a href="<?= $actionpanel->generate_dayviewurl(date('m/d/Y')); ?>" class="load-link" data-loadinto="#actions-panel" data-focus="#actions-panel">
					<b>Go to Today</b> <i class="fa fa-calendar-o" aria-hidden="true"></i>
				</a>
				&nbsp;
			<?php endif; ?>
			<a href="<?= $actionpanel->generate_calendarviewurl(); ?>" class="load-link" data-loadinto="#actions-panel" data-focus="#actions-panel"><b>View Calendar</b></a> <i class="fa fa-calendar" aria-hidden="true"></i>
		</div>
		<div class="col-sm-6">
			<form action="<?= $actionpanel->generate_refreshurl(); ?>" class="form-ajax form-inline display-inline-block" data-loadinto="<?= $actionpanel->loadinto; ?>" data-focus="<?= $actionpanel->focus; ?>">
				<input type="hidden" name="filter" value="filter">
				<label class="control-label">Go to Date</label> &nbsp; &nbsp;
				<div class="input-group date" style="width: 180px;">
					<?php $name = 'day'; $value = $input->get->day ? $input->get->text('day') : ''; ?>
					<?php include $config->paths->content."common/date-picker.php"; ?>
				</div>
				<button type="submit" class="btn btn-sm btn-success">Go</button>
			</form>
			<button type="button" class="btn btn-sm btn-primary pull-right" data-toggle="collapse" data-target="#<?= $actionpanel->panelID.'-filter'; ?>" aria-expanded="false" aria-controls="<?= $actionpanel->panelID.'-filter'; ?>">
				Toggle Filter
			</button>
		</div>
	</div>
	<div class="<?= $input->get->filter ? '' : 'collapse'; ?> form-group" id="<?= $actionpanel->panelID.'-filter'; ?>">
		<?php include $config->paths->content."user-actions/views/$actionpanel->paneltype/day/search-form.php"; ?>
	</div>
	<div class="row">
		<div class="col-sm-4">
			<h3>Overview</h3>
			<table class="table table-condensed table-striped table-bordered">
				<tr>
					<td>Notes Created <a href="<?= $actionpanel->generate_daynotescreatedurl($day); ?>" class="load-link" data-loadinto="#actions-panel" data-focus="#actions-panel">View</a> <i class="fa fa-binoculars" aria-hidden="true"></i> </td>
					<td><?= $actionpanel->count_daynotes($day); ?></td>
				</tr>
				<tr>
					<td>Tasks Scheduled for <?= date('m/d/Y', strtotime($day)); ?> <a href="<?= $actionpanel->generate_dayviewscheduledtasksurl($day); ?>" class="load-link" data-loadinto="#actions-panel" data-focus="#actions-panel">View</a> <i class="fa fa-binoculars" aria-hidden="true"></i> </td>
					<td><?= $actionpanel->count_dayscheduledtasks($day); ?> </td>
				</tr>
				<tr>
					<td>Tasks Completed</td> <td><?= $actionpanel->count_daycompletedtasks($day); ?></td>
				</tr>
				<tr>
					<td>Tasks Rescheduled on <?= date('m/d/Y', strtotime($day)); ?></td> <td><?= $actionpanel->count_dayrescheduledtasks($day); ?></td>
				</tr>
			</table>
		</div>
		<div class="col-sm-8">
			<h3 aria-hidden="true">&nbsp;</h3>
			<div class="actions-table-div">
				<?php include $config->paths->content."user-actions/views/$actionpanel->paneltype/day/tables/$actionpanel->actiontype.php"; ?>
			</div>
		</div>
	</div>
</div>
