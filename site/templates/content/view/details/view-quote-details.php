<div class="row">
	<div class="col-sm-6">
		<h3>Item Details</h3>
		<table class="table table-bordered table-condensed">
			<tr> <td>Item ID</td> <td><?= $linedetail->itemid; ?></td> </tr>
			<tr> <td>Warehouse</td> <td><?= $linedetail->whse; ?></td> </tr>
			<tr> <td>Unit of Measurement</td> <td><?= $linedetail->uom; ?></td> </tr>
			<tr> <td>Requested Ship Date</td> <td><?= $linedetail->rshipdate; ?></td> </tr>
			<tr> <td>Kit Item</td> <td><?= $linedetail->kititemflag; ?></td> </tr>
			<tr> <td>Special Order</td> <td><?= $linedetail->spcord; ?></td> </tr>
			<tr> <td>Quantity</td> <td><?= $page->stringerbell->format_money($linedetail->ordrqty, 0); ?></td> </tr>
			<tr> <td>Price</td> <td>$ <?= $page->stringerbell->format_money($linedetail->ordrprice, 2); ?></td> </tr>
			<tr> <td>Total</td> <td>$ <?= $linedetail->ordrtotalprice; ?></td> </tr>
			<tr> <td>Tax</td> <td><?= $linedetail->taxcode; ?></td> </tr>
		</table>
	</div>
	<div class="col-sm-6">
		<?php if ($linedetail->is_kititem()) : ?>
			<h3>Kit Components</h3>
			<?php $tableformatter= $page->screenformatterfactory->generate_screenformatter('item-kitcomponents'); ?>
			<?php include $config->paths->content.'common/include-tableformatter-display.php'; ?>
		<?php endif; ?>
	</div>
</div>
