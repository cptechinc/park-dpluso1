<form action="<?= $bookingspanel->pageurl->getUrl(); ?>" method="get" data-loadinto="#bookings-panel" data-focus="#bookings-panel" data-modal="#ajax-modal" class="orders-search-form allow-enterkey-submit">
	<input type="hidden" name="filter" value="filter">
	<div class="row">
		<div class="col-sm-2">
			<h4>Booking Dates</h4>
			<?php $name = 'bookdate[]'; $value = $bookingspanel->get_filtervalue('bookdate'); ?>
			<?php include $config->paths->content."common/date-picker.php"; ?>
			<label class="small text-muted">From Date </label>

			<?php $name = 'bookdate[]'; $value = $bookingspanel->get_filtervalue('bookdate', 1); ?>
			<?php include $config->paths->content."common/date-picker.php"; ?>
			<label class="small text-muted">Through Date </label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6 form-group">
			<button class="btn btn-success btn-block" type="submit">Search <i class="fa fa-search" aria-hidden="true"></i></button>
		</div>
		<div class="col-sm-6 form-group">
			<?php if ($input->get->filter) : ?>
				<?php //TODO $bookingspanel->generate_clearsearchlink(); ?>
			 <?php endif; ?>
		</div>
	</div>
</form>
