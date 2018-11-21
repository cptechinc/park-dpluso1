<?php $customer = Customer::load($quote->custid, $quote->shiptoid); ?>
<div class="form-group hidden-print">
	<?= $quotedisplay->generate_viewprintlink($quote); ?>
</div>
<div class="row">
	<div class="col-sm-6">
		<img src="<?= $appconfig->companylogo->url; ?>" class="img-responsive" alt="<?= $appconfig->companydisplayname.' logo'; ?>">
	</div>
	<div class="col-sm-6 text-right">
		<h1>Summary for Quote # <?= $qnbr; ?></h1>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">
		<table class="table table-bordered table-striped table-condensed">
			<tr> 
				<td>CustID</td> 
				<td>
					<?= $quote->custid; ?> - <a href="<?= $customer->generate_customerurl(); ?>"><?= $customer->get_customername(); ?></a> 
					<span class="glyphicon glyphicon-share"></span>
				</td> 
			</tr>
			<tr>
				<td>ShiptoID</td> <td><?= $quote->shiptoid; ?></td>
			</tr>
			<tr> <td>Quote Date</td> <td class="text-right"><?= $quote->quotdate; ?></td> </tr>
			<tr> <td>Review Date</td> <td class="text-right"><?= $quote->revdate; ?></td> </tr>
			<tr> <td>Expire Date</td> <td class="text-right"><?= $quote->expdate; ?></td> </tr>
			<tr> <td>Terms Code</td> <td><?= $quote->termcodedesc; ?></td> </tr>
			<tr> <td>Tax</td> <td><?= $quote->taxcodedesc; ?></td> </tr>
            <tr> <td>Sales Person</td> <td><?= $quote->sp1; ?></td> </tr>
		</table>
	</div>

	<div class="col-sm-6">
		<table class="table table-bordered table-striped table-condensed">
			<tr> <td>Customer PO</td> <td><?= $quote->custpo; ?></td> </tr>
            <tr> <td>Cust Ref</td> <td><?= $quote->custref; ?></td> </tr>
            <tr> <td>Ship Via</td> <td><?= $quote->shipviacd.' - '.$quote->shipviadesc; ?></td> </tr>
		</table>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">
		<div class="page-header"><h3>Bill-to</h3></div>
		<address>
			<?= $quote->billname; ?><br>
			<?= $quote->billaddress; ?><br>
			<?php if (strlen($quote->billaddress2) > 0) : ?>
				<?= $quote->billaddress2; ?><br>
			<?php endif; ?>
			<?= $quote->billcity.", ".$quote->billstate." ".$quote->billzip; ?>
		</address>
	</div>
	<div class="col-sm-6">
		<div class="page-header"><h3>Ship-to</h3></div>
		<address>
			<?= $quote->shipname; ?><br>
			<?= $quote->shipaddress; ?><br>
			<?php if (strlen($quote->shipaddress2) > 0) : ?>
				<?= $quote->shipaddress2; ?><br>
			<?php endif; ?>
			<?= $quote->shipcity.", ".$quote->shipstate." ".$quote->shipzip; ?>
		</address>
	</div>
</div>
<table class="table table-bordered table-striped">
	 <tr class="detail item-header">
		<th class="text-center">Item ID/Cust Item ID</th>
		<th class="text-center">Details</th>
		<th class="text-right">Qty</th>
		<th class="text-right" width="100">Price</th>
		<th class="text-right">Line Total</th>
	</tr>
	<?php $details = $quotedisplay->get_quotedetails($quote); ?>
	<?php foreach ($details as $detail) : ?>
		<tr class="detail">
			<td>
				<?= $detail->itemid; ?>
				<?php if (strlen($detail->vendoritemid)) { echo ' '.$detail->vendoritemid;} ?>
				<br>
				<small><?= $detail->desc1. ' ' . $detail->desc2 ; ?></small>
			</td>
			<td>
				<?= $quotedisplay->generate_detailvieweditlink($quote, $detail, $page->bootstrap->icon('glyphicon glyphicon-eye-open')); ?>
            </td>
			<td class="text-right"> <?= intval($detail->quotqty); ?> </td>
			<td class="text-right">$ <?= $page->stringerbell->format_money($detail->quotprice); ?></td>
			<td class="text-right">$ <?= $page->stringerbell->format_money($detail->quotprice * intval($detail->quotqty)) ?> </td>
		</tr>
	<?php endforeach; ?>
	<tr>
		<td></td> <td><b>Subtotal</b></td> <td colspan="3" class="text-right">$ <?= $page->stringerbell->format_money($quote->subtotal); ?></td>
	</tr>
	<tr>
		<td></td><td><b>Tax</b></td> <td colspan="3" class="text-right">$ <?= $page->stringerbell->format_money($quote->salestax); ?></td>
	</tr>
	<tr>
		<td></td><td><b>Freight</b></td> <td colspan="3" class="text-right">$ <?=$page->stringerbell->format_money($quote->freight); ?></td>
	</tr>
	<tr>
		<td></td><td><b>Misc.</b></td> <td colspan="3" class="text-right">$ <?= $page->stringerbell->format_money($quote->misccost); ?></td>
	</tr>
	<tr>
		<td></td><td><b>Total</b></td> <td colspan="3" class="text-right">$ <?= $page->stringerbell->format_money($quote->ordertotal); ?></td>
	</tr>
</table>
<div class="row">
	<div class="col-sm-6">
		<?= $quotedisplay->generate_customershiptolink($quote); ?>
	</div>
	<div class="col-sm-6">
		<?= $quotedisplay->generate_editlink($quote); ?>
	</div>
</div>
