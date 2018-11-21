<form action="<?= $orderpanel->pageurl->getUrl(); ?>" method="get" data-ordertype="sales-orders" data-loadinto="#orders-panel" data-focus="#orders-panel" data-modal="#ajax-modal" class="orders-search-form allow-enterkey-submit">
	<input type="hidden" name="filter" value="filter">

	<div class="row">
		<div class="col-sm-2">
			<h4>Order Status :</h4>
			<label>New</label>
			<input class="pull-right" type="checkbox" name="status[]" value="N" <?= ($orderpanel->has_filtervalue('status', 'N')) ? 'checked' : ''; ?>></br>

			<label>Invoice</label>
			<input class="pull-right" type="checkbox" name="status[]" value="I" <?= ($orderpanel->has_filtervalue('status', 'I')) ? 'checked' : ''; ?>></br>

			<label>Pick</label>
			<input class="pull-right" type="checkbox" name="status[]" value="P" <?= ($orderpanel->has_filtervalue('status', 'P')) ? 'checked' : ''; ?>></br>

			<label>Verify</label>
			<input class="pull-right" type="checkbox" name="status[]" value="V" <?= ($orderpanel->has_filtervalue('status', 'V')) ? 'checked' : ''; ?>>
		</div>
		<div class="col-sm-2">
			<h4>Order #</h4>
			<input class="form-control form-group inline input-sm" type="text" name="ordernumber[]" value="<?= $orderpanel->get_filtervalue('ordernumber'); ?>" placeholder="From Order #">
			<input class="form-control form-group inline input-sm" type="text" name="ordernumber[]" value="<?= $orderpanel->get_filtervalue('ordernumber', 1); ?>" placeholder="Through Order #">
		</div>
		<div class="col-sm-2">
			<h4>Cust ID</h4>
			<div class="input-group form-group">
				<input class="form-control form-group inline input-sm" type="text" name="custid[]" id="sales-order-cust-from" value="<?= $orderpanel->get_filtervalue('custid'); ?>" placeholder="From CustID">
				<span class="input-group-btn">
					<button type="button" class="btn btn-default btn-sm not-round get-custid-search" data-field="#sales-order-cust-from"> <span class="glyphicon glyphicon-search" aria-hidden="true"></span> <span class="sr-only">Search</span> </button>
				</span>
			</div>
			<div class="input-group form-group">
				<input class="form-control form-group inline input-sm" type="text" name="custid[]" id="sales-order-cust-to" value="<?= $orderpanel->get_filtervalue('custid', 1); ?>" placeholder="Through CustID">
				<span class="input-group-btn">
					<button type="button" class="btn btn-default btn-sm not-round get-custid-search" data-field="#sales-order-cust-to"> <span class="glyphicon glyphicon-search" aria-hidden="true"></span> <span class="sr-only">Search</span> </button>
				</span>
			</div>
		</div>
		<div class="col-sm-2">
			<h4>Cust PO</h4>
			<input class="form-control inline input-sm" type="text" name="custpo[]" value="<?= $orderpanel->get_filtervalue('custpo'); ?>" placeholder="Cust PO">
		</div>
		<div class="col-sm-2">
			<h4>Order Total</h4>
			<div class="input-group form-group">
				<input class="form-control form-group inline input-sm" type="text" name="total_order[]" id="order-total-min" value="<?= $orderpanel->get_filtervalue('total_order'); ?>" placeholder="From Order Total">
				<span class="input-group-btn">
					<button type="button" class="btn btn-default btn-sm not-round" onclick="$('#order-total-min').val('<?= $orderpanel->get_minsalesordertotal(); ?>')"> <span class="fa fa-angle-double-down" aria-hidden="true"></span> <span class="sr-only">Min</span> </button>
				</span>
			</div>
			<div class="input-group form-group">
				<input class="form-control form-group inline input-sm" type="text" name="total_order[]" id="order-total-max" value="<?= $orderpanel->get_filtervalue('total_order', 1); ?>" placeholder="Through Order Total">
				<span class="input-group-btn">
					<button type="button" class="btn btn-default btn-sm not-round" onclick="$('#order-total-max').val('<?= $orderpanel->get_maxsalesordertotal(); ?>')"> <span class="fa fa-angle-double-up" aria-hidden="true"></span> <span class="sr-only">Max</span> </button>
				</span>
			</div>
		</div>
		<div class="col-sm-2">
			<h4>Order Date</h4>
			<?php $name = 'order_date[]'; $value = $orderpanel->get_filtervalue('order_date'); ?>
			<?php include $config->paths->content."common/date-picker.php"; ?>
			<label class="small text-muted">From Date </label>

			<?php $name = 'order_date[]'; $value = $orderpanel->get_filtervalue('order_date', 1); ?>
			<?php include $config->paths->content."common/date-picker.php"; ?>
			<label class="small text-muted">Through Date </label>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-sm-12 form-group">
			<button class="btn btn-success btn-block" type="submit">Search <i class="fa fa-search" aria-hidden="true"></i></button>
		</div>
		<div class="col-sm-12 form-group">
			<?php if ($input->get->filter) : ?>
				<div>
					<a href="<?= $orderpanel->generate_loadurl(); ?>" class="load-link btn btn-warning btn-block" data-loadinto="<?= $orderpanel->loadinto; ?>" data-focus="<?= $orderpanel->focus; ?>">
						Clear Search <i class="fa fa-search-minus" aria-hidden="true"></i>
					</a>
				</div>
			<?php endif; ?>
		</div>
	</div>
</form>
