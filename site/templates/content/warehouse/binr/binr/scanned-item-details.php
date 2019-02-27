<table class="table table-condensed table-striped">
	<tr>
		<td><b>Derived From:</b> <?= strtoupper($item->xorigin); ?></td>
		<td><?= $item->xitemid; ?></td>
	</tr>
	<?php if ($item->is_lotted() || $item->is_serialized()) : ?>
		<tr>
			<td><?= strtoupper($item->get_itemtypepropertydesc()); ?></td>
			<td><?= $item->get_itemidentifier(); ?></td>
		</tr>
	<?php endif; ?>
	<tr>
		<td>Item ID</td>
		<td><?= $item->itemid; ?></td>
	</tr>
	<tr>
		<td>Description</td>
		<td><?= $item->desc1; ?></td>
	</tr>
	<?php if (!empty($item->desc2)) : ?>
		<tr>
			<td></td>
			<td><?= $item->desc2; ?></td>
		</tr>
	<?php endif; ?>
	<tr>
		<td>Primary Bin</td>
		<td><?= $item->primarybin; ?></td>
	</tr>
	<tr>
		<td>Current Bin</td>
		<td><?= $item->bin; ?></td>
	</tr>
</table>
