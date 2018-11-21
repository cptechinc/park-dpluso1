<tr class="detail item-header">
	<th colspan="2" class="text-center">Item ID/Cust Item ID</th>
	<th colspan="2">Description</th>
	<th class="text-right">Ordered</th>
	<th class="text-right" width="100">Price</th>
	<th class="text-right">Back Order</th>
	<th class="text-right">Shipped</th>
	<th>Notes</th>
	<th>Reorder</th> 
	<th>Documents</th>
</tr>
<?php $details = $orderpanel->get_orderdetails($order); ?>
<?php foreach ($details as $detail) : ?>
	<tr class="detail">
		<td colspan="2" class="text-center">
			<?= $orderpanel->generate_detailvieweditlink($order, $detail); ?>
		</td>
		<td colspan="2">
			<?php if (strlen($detail->vendoritemid)) { echo ' '.$detail->vendoritemid."<br>";} ?>
			<?= $detail->desc1. ' ' . $detail->desc2 ; ?>
		</td>
		<td class="text-right"><?= intval($detail->qty); ?></td>
		<td class="text-right">$ <?= $page->stringerbell->format_money($detail->price); ?></td>
		<td class="text-right"><?= intval($detail->qtybackord); ?></td> 
		<td class="text-right"><?= intval($detail->qtyshipped); ?></td>
		<td><?= $orderpanel->generate_loaddplusnoteslink($order, $detail->linenbr); ?></td> 
		<td><?= $orderpanel->generate_detailreorderform($order, $detail); ?></td> 
		<td><div><?= $orderpanel->generate_loaddocumentslink($order, $detail); ?></div></td>
	</tr>
	<?php if ($input->get->text('item-document')) : ?>
		<?php if ($input->get->text('item-document') == $detail->itemid) : ?>
			<?php $itemdocs = get_item_docs(session_id(), $order->ordernumber, $detail->itemid, false); ?>
			<?php foreach ($itemdocs->fetchAll() as $itemdoc) : ?>
				<tr class="docs">
					<td colspan="2"></td>
					<td>
						<b><a href="<?= $config->pathtofiles.$itemdoc['pathname']; ?>" title="Click to View Document" target="_blank" ><?php echo $itemdoc['title']; ?></a></b>
					</td>
					<td class="text-right"><?= $itemdoc['createdate']; ?></td>
					<td class="text-right"><?= Dplus\Base\DplusDateTime::format_dplustime($itemdoc['createtime']) ?></td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
	<?php endif; ?>
<?php endforeach; ?>
