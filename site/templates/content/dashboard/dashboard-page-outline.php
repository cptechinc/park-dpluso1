<?php if ($appconfig->child('name=dplus')->has_crm) : ?>
	<div class="row">
		<div class="col-sm-12">
			<?php $actionpanel = new Dplus\Dpluso\UserActions\ActionsPanel(session_id(), $page->fullURL, $input); ?>
			<?php include $config->paths->content."user-actions/user-actions-panel.php"; ?>
		</div>
	</div>
<?php endif; ?>
<?php if ($pages->get('/config/dashboard/')->show_salespanel) : ?>
	<div class="row">
		<div class="col-sm-12">
			<?php include $config->paths->content.'dashboard/sales-panel/sales-panel.php'; ?>
		</div>
	</div>
<?php endif; ?>
<?php if ($pages->get('/config/dashboard/')->show_bookingspanel) : ?>
	<div class="row">
		<div class="col-sm-12">
			<?php include $config->paths->content.'dashboard/bookings/bookings-panel.php'; ?>
		</div>
	</div>
<?php endif; ?>
<div class="row">
	<div class="col-sm-12">
		<?php include $config->paths->content.'dashboard/sales-orders/sales-orders-panel.php'; ?>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<?php include $config->paths->content.'dashboard/quotes/quotes-panel.php'; ?>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<?php include $config->paths->content.'dashboard/sales-history/sales-history-panel.php'; ?>
	</div>
</div>
<?php
	if ($pages->get('/config/dashboard/')->show_salespanel) {
		include "{$config->paths->content}/dashboard/sales-panel/sales-panel.js.php";
	}

	if ($page->has_bookings && $pages->get('/config/dashboard/')->show_bookingspanel) {
		include $config->paths->content."dashboard/bookings/bookings-line-chart.js.php";
	}
?>
