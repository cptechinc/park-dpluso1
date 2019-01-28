<div class="form-group hidden-print">
	<a href="<?= $orderdisplay->generate_printURL($order); ?>" target="_blank">
		<span class="h3"><i class="fa fa-print" aria-hidden="true"></i></span> View Printable Order
	</a>
</div>
<div class="row">
	<div class="col-sm-6">
		<img src="<?= $appconfig->companylogo->url; ?>" class="img-responsive" alt="<?= $appconfig->companydisplayname.' logo'; ?>">
	</div>
	<div class="col-sm-6 text-right">
		<h1>Order # <?= $order->ordernumber; ?></h1>
	</div>
</div>
<div class="row">
	<div class="col-sm-6"></div>

	<div class="col-sm-6">
		<table class="table table-bordered table-striped table-condensed">
			<tr> <td>Order Date</td> <td><?= $order->orderdate; ?></td> </tr>
			<tr> <td>Request Date</td> <td><?= $order->rqstdate; ?></td> </tr>
			<tr> <td>Status</td> <td><?= $order->status; ?></td> </tr>
			<tr> <td>CustID</td> <td><?= $order->custid; ?></td> </tr>
			<tr> <td>Customer PO</td> <td><?= $order->custpo; ?></td> </tr>
		</table>
	</div>
</div>
<div class="row">
	<div class="col-xs-4">
		<div class="address-header"><h3>Bill-to</h3></div>
		<address>
			<?= $order->custname; ?><br>
			<?= $order->billaddress; ?><br>
			<?php if (strlen($order->billaddress2) > 0) : ?>
				<?= $order->billaddress2; ?><br>
			<?php endif; ?>
			<?= $order->billcity.", ".$order->billstate." ".$order->billzip; ?>
		</address>
	</div>
	<div class="col-xs-4">
		<div class="address-header"><h3>Ship-to</h3></div>
		<address>
			<?= $order->shipname; ?><br>
			<?= $order->shipaddress; ?><br>
			<?php if (strlen($order->shipaddress2) > 0) : ?>
				<?= $order->shipaddress2; ?><br>
			<?php endif; ?>
			<?= $order->shipcity.", ".$order->shipstate." ".$order->shipzip; ?>
		</address>
	</div>
	<div class="col-xs-4">
		<div class="address-header"><h3>Contact</h3></div>
		<address>
			<?= $order->contact; ?><br>
			<?= $page->stringerbell->format_phone($order->phone); ?><br>
			<?= $order->email; ?>
		</address>
	</div>
</div>
<table class="table table-bordered table-striped">
	 <tr class="detail item-header">
		<th class="text-center">Item ID/Cust Item ID</th>
		<th class="text-right">Qty</th>
		<th class="text-right" width="100">Price</th>
		<th class="text-right">Line Total</th>
	</tr>
	<?php $details = $orderdisplay->get_orderdetails($order); ?>
	<?php foreach ($details as $detail) : ?>
		<tr class="detail">
			<td>
				<?= $detail->itemid; ?>
				<?php if (strlen($detail->vendoritemid)) { echo ' '.$detail->vendoritemid;} ?>
				<br>
				<small><?= $detail->desc1. ' ' . $detail->desc2 ; ?></small>
			</td>
			<td class="text-right"> <?= intval($detail->qty) ; ?> </td>
			<td class="text-right">$ <?= $page->stringerbell->format_money($detail->price); ?></td>
			<td class="text-right">$ <?= $page->stringerbell->format_money($detail->price * intval($detail->qty)) ?> </td>
		</tr>
	<?php endforeach; ?>
	<tr>
		<td></td> <td><b>Subtotal</b></td> <td colspan="2" class="text-right">$ <?= $page->stringerbell->format_money($order->subtotal); ?></td>
	</tr>
	<tr>
		<td></td><td><b>Tax</b></td> <td colspan="2" class="text-right">$ <?= $page->stringerbell->format_money($order->salestax); ?></td>
	</tr>
	<tr>
		<td></td><td><b>Freight</b></td> <td colspan="2" class="text-right">$ <?= $page->stringerbell->format_money($order->freight); ?></td>
	</tr>
	<tr>
		<td></td><td><b>Misc.</b></td> <td colspan="2" class="text-right">$ <?= $page->stringerbell->format_money($order->misccost); ?></td>
	</tr>
	<tr>
		<td></td><td><b>Total</b></td> <td colspan="2" class="text-right">$ <?= $page->stringerbell->format_money($order->ordertotal); ?></td>
	</tr>
</table>
<hr>
<div class="row">
	<div class="col-sm-6 form-group">
		<?php if ($order->can_edit()) : ?>
			<a href="<?= $orderdisplay->generate_editURL($order); ?>" class="btn btn-block btn-warning">
				<i class="fa fa-pencil" aria-hidden="true"></i> Edit Sales Order
			</a>
		<?php else :?>
			<a href="<?= $orderdisplay->generate_editURL($order); ?>" class="btn btn-block btn-warning">
				<i class="fa fa-eye" aria-hidden="true"></i> View Sales Order
			</a>
		<?php endif; ?>
	</div>
	<div class="col-sm-6 form-group">
		<a href="<?= $orderdisplay->generate_customershiptoURL($order); ?>" class="btn btn-block btn-primary">
			<i class="fa fa-user" aria-hidden="true"></i> Go To Customer Page
		</a>
	</div>
</div>
<?php if ($session->panelorigin == 'orders') :  ?>
	<?php $url = $session->panelcustomer ? $orderdisplay->generate_customershiptoURL($order) : $config->pages->dashboard; ?>
	<a href="<?= $url; ?>" class="btn btn-block btn-info">
		<span class="fa fa-arrow-circle-left" aria-hidden="true"></span> Back to Panel
	</a>
<?php endif; ?>
