<div class="row">
	<div class="col-xs-6"></div>
	<div class="col-xs-6 text-right">
		<h3><img src="data:image/png;base64, <?= base64_encode($generator->getBarcode($order->ordernumber, $generator::TYPE_CODE_128)); ?>" alt="Barcode for Sales Order <?= $order->ordernumber; ?>"></h3>
	</div>
</div>
<div class="row">
	<div class="col-xs-5">
		<img src="<?= $appconfig->companylogo->url; ?>" alt="<?= $appconfig->companydisplayname.' logo'; ?>" style="max-width: 100%;">
	</div>
	<div class="col-xs-7 text-right">
		<h1>Order # <?= $order->ordernumber; ?></h1>
		</br>
	</div>
</div>
<div class="row">
	<div class="col-xs-6">
		<?php if ((!$input->get->text('view') == 'pdf')) : ?>
			<a href="<?= $emailurl->getUrl(); ?>" class="btn btn-primary load-into-modal hidden-print" data-modal="#ajax-modal"><i class="glyphicon glyphicon-envelope" aria-hidden="true"></i> Send as Email</a>
			&nbsp;&nbsp;
			<a href="<?= $config->documentstorage.$pdfmaker->filename; ?>" target="_blank" class="btn btn-primary hidden-print"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> View PDF</a>
		<?php endif; ?>
	</div>

	<div class="col-xs-6">
		<div class="row">
			<table class="pull-right">
				<tr> <td class="col-xs-6"><label>Order Date:</label></td> <td class="col-xs-6 text-right"><?= Dplus\Base\DplusDateTime::format_date($order->orderdate); ?></td> </tr>
				<tr> <td class="col-xs-6"><label>Request Date:</label></td> <td class="col-xs-6 text-right"><?= Dplus\Base\DplusDateTime::format_date($order->request_date); ?></td> </tr>
				<tr> <td class="col-xs-6"><label>Status:</label></td> <td class="col-xs-6 text-right"><?= $order->status; ?></td> </tr>
				<tr> <td class="col-xs-6"><label>Customer ID:</label></td> <td class="col-xs-6 text-right"><?= $order->custid; ?></td> </tr>
				<tr> <td class="col-xs-6"><label>Customer PO:</label></td> <td class="col-xs-6 text-right"><?= $order->custpo; ?></td> </tr>
				<tr> <td class="col-xs-6"><label>Shipping Method:</label></td> <td class="col-xs-6 text-right"><?= $order->shipviadesc; ?></td></tr>
				<tr> <td class="col-xs-6"><label>Payment Terms:</label></td> <td class="col-xs-6 text-right"><?= $order->termcodedesc; ?></td></tr>
				<tr> <td class="col-xs-6"><label>Salesperson:</label></td> <td class="col-xs-6 text-right"><?= $order->salesperson_1; ?></td></tr>
				<tr> <td class="col-xs-6"><label>Salesperson Email:</label></td> <td class="col-xs-6 text-right"><?= $salespersonjson['data'][$order->salesperson_1]['spemail']; ?></td></tr>
			</table>
		</div>
	</div>
</div>
</br>

<div class="row">
	<div class="col-xs-4">
		<div class="address-header"><h3>Bill-to</h3></div>
		<?php $customer = Customer::load($order->custid); ?>
		<address>
			<?= $customer->name; ?><br>
			<?= $customer->addr1; ?><br>
			<?php if (strlen($customer->addr2) > 0) : ?>
				<?= $customer->addr2; ?><br>
			<?php endif; ?>
			<?= $customer->city.", ".$customer->state." ".$customer->zip; ?>
		</address>
	</div>
	<div class="col-xs-4">
		<div class="address-header"><h3>Ship-to</h3></div>
		<address>
			<?= $order->shipto_name; ?><br>
			<?= $order->shipto_address1; ?><br>
			<?php if (strlen($order->shipto_address2) > 0) : ?>
				<?= $order->shipto_address2; ?><br>
			<?php endif; ?>
			<?= $order->shipto_city.", ".$order->shipto_state." ".$order->shipto_zip; ?>
		</address>
	</div>
	<div class="col-xs-4">
		<div class="address-header"><h3>Contact</h3></div>
		<address>
			<?= $order->contact; ?><br>
			<?= $page->stringerbell->format_phone($order->phone); ?><br>
			<?= $order->contact_email; ?>
		</address>
	</div>
</div>
</br>
</br>

<table class="table table-bordered table-condensed">
	 <tr class="detail item-header active">
		<th class="text-center">Item ID/Cust Item ID</th>  <th class="text-right">Qty</th>
		<th class="text-right" width="100">Price</th>
		<th class="text-right">Line Total</th>
	</tr>
	<?php $details = $orderdisplay->get_orderdetails($order); ?>
	<?php foreach ($details as $detail) : ?>
		<tr class="detail table-bordered">
			<td>
				<?= $detail->itemid; ?>
				<?= (strlen($detail->vendoritemid)) ? ' '.$detail->vendoritemid : ''; ?>
				<br>
				<small><?= $detail->desc1. ' ' . $detail->desc2 ; ?></small>
			</td>
			<td class="text-right"><?= intval($detail->qty); ?></td>
			<td class="text-right">$ <?= $page->stringerbell->format_money($detail->price); ?></td>
			<td class="text-right">$ <?= $page->stringerbell->format_money($detail->price * $detail->qty); ?> </td>
		</tr>
	<?php endforeach; ?>
</table>

<div class="row">
	<div class="col-xs-9"></div>
	<div class="col-xs-3">
		<table class="table table-condensed pull-right">
			<tr>
				<td class="col-xs-6"><label>Subtotal</label></td>
				<td class="text-right col-xs-6">$ <?= $page->stringerbell->format_money($order->subtotal_nontax); ?></td>
			</tr>
			<tr>
				<td class="col-xs-6"><label>Tax</label></td>
				<td class="text-right col-xs-6">$ <?= $page->stringerbell->format_money($order->total_tax); ?></td>
			</tr>
			<tr>
				<td class="col-xs-6"><label>Freight</label></td>
				<td class="text-right col-xs-6">$ <?= $page->stringerbell->format_money($order->total_freight); ?></td>
			</tr>
			<tr>
				<td class="col-xs-6"><label>Misc.</label></td>
				<td class="text-right col-xs-6">$ <?= $page->stringerbell->format_money($order->total_misc); ?></td>
			</tr>
			<tr class="active">
				<td class="col-xs-6"><label>Total</label></td>
				<td class="text-right col-xs-6">$ <?= $page->stringerbell->format_money($order->total_order); ?></td>
			</tr>
		</table>
	</div>
</div>
