<?php 
	include "{$config->paths->content}warehouse/session.js.php"; 
	$itemuoms = BarcodedItem::find_distinct_unitofmeasure($item->itemid);
	$imitem = ItemMasterItem::load($item->itemid);
?>
<div>
	<form action="<?= $config->pages->menu_inventory."redir/"; ?>" method="POST" class="physical-count-form">
		<input type="hidden" name="action" value="physical-count">
		<input type="hidden" name="page" value="<?= $page->fullURL->getUrl(); ?>">
		<input type="hidden" name="itemID" value="<?= $item->itemid; ?>">
		<input type="hidden" name="<?= $item->get_itemtypeproperty(); ?>" value="<?= $item->get_itemidentifier(); ?>">
		<input type="hidden" name="binID" value="<?= $binID; ?>">
		
		<table class="table table-striped">
			<tr>
				<td>Bin</td>
				<td><?= $binID; ?></td>
			</tr>
			<tr>
				<td>Item</td>
				<td><?= $item->get_itemidentifier(); ?></td>
			</tr>
			<tr>
				<td>Item ID</td>
				<td colspan="2"><?= $item->itemid; ?></td>
			</tr>
			<tr>
				<td>Item Description</td>
				<td><?= $item->desc1; ?></td>
			</tr>
			<?php if ($item->is_lotted() || $item->is_serialized()) : ?>
				<tr>
					<td><?= strtoupper($item->get_itemtypepropertydesc()); ?></td>
					<td><?= $item->get_itemidentifier(); ?></td>
				</tr>
			<?php endif; ?>
		</table>
		<h3>Inventory</h3>
		<table class="table table-striped">
			<tr>
				<th>Pack Type</th>
				<th>Qty in Pack</th>
				<th>Qty Found</th>
				<th>Total Qty</th>
			</tr>
			<tr class="uom-row">
				<td>Outer</td>
				<td data-unitqty="<?= $imitem->outerpackqty; ?>"><?= $imitem->outerpackqty; ?></td>
				<td><input type="number" class="form-control input-sm text-right uom-value" name="outer-pack-qty" value="0"></td>
				<td class="uom-total-qty text-right">0</td>
			</tr>
			<tr class="uom-row">
				<td>Inner</td>
				<td data-unitqty="<?= $imitem->innerpackqty; ?>"><?= $imitem->innerpackqty; ?></td>
				<td><input type="number" class="form-control input-sm text-right uom-value" name="inner-pack-qty" value="0"></td>
				<td class="uom-total-qty text-right">0</td>
			</tr>
			<tr class="uom-row">
				<td>Each</td>
				<td data-unitqty="1">1</td>
				<td><input type="number" class="form-control input-sm text-right uom-value" name="each-qty" value="0"></td>
				<td class="uom-total-qty text-right">0</td>
			</tr>
			<tr class="bg-info">
				<td></td>
				<td></td>
				<td class="text-center">Total</td>
				<td class="text-right physical-count-total">0</td>
			</tr>
		</table>
		<div class="row">
			<div class="col-xs-6 form-group">
				<button class="btn not-round btn-emerald"><i class="fa fa-floppy-o" aria-hidden="true"></i> Submit</button>
			</div>
			<div class="col-xs-6 form-group">
				<a href="<?= $physicalcounter->get_cancel_itemURL(); ?>" class="btn not-round btn-warning">
					<i class="fa fa-trash" aria-hidden="true"></i> Cancel
				</a>
			</div>
		</div>
	</form>
</div>
