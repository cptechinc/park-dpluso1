<div>
	<h2>Take your Picked Items to the Shipping area</h2>
	<table class="table table-condensed table-striped">
		<tr>
			<td class="control-label">Order #</td> <td class="text-right"><?= $pickorder->order->ordn; ?></td>
		</tr>
		<tr>
			<td class="control-label">Customer</td> <td class="text-right"><?= $pickorder->order->custID.' - '.$pickorder->order->customername; ?></td>
		</tr>
	</table>
	<a href="<?= $pickorder->generate_finishorderurl(); ?>" class="btn btn-emerald">
		<i class="fa fa-check-square" aria-hidden="true"></i> Finish Order
	</a>
	<a href="<?= $pickorder->generate_exitorderurl(); ?>" class="btn btn-danger exit-order">Exit Order</a>
</div>
