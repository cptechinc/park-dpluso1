<?php 
	use Dplus\Base\DplusDateTime;
	$details = $orderpanel->get_orderdetails($order);
?>
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
<?php foreach ($details as $detail) : ?>
	<tr class="detail">
		<td colspan="2" class="text-center">
			<a href="<?= $orderpanel->generate_vieweditdetailURL($order, $detail); ?>" class="update-line" data-kit="<?= $detail->kititemflag; ?>" data-itemid="<?= $detail->itemid; ?>" data-custid="<?= $order->custid; ?>" aria-label="View Detail Line">
				<?= $detail->itemid; ?>
			</a>
		</td>
		<td colspan="2">
			<?php if (strlen($detail->vendoritemid)) { echo ' '.$detail->vendoritemid."<br>";} ?>
			<?= $detail->desc1. ' ' . $detail->desc2 ; ?>
		</td>
		<td class="text-right"><?= intval($detail->qty); ?></td>
		<td class="text-right">$ <?= $page->stringerbell->format_money($detail->price); ?></td>
		<td class="text-right"><?= intval($detail->qtybackord); ?></td> 
		<td class="text-right"><?= intval($detail->qtyshipped); ?></td>
		<td>
			<?php if ($detail->has_notes()) : ?>
				<a href="<?= $orderpanel->generate_request_dplusnotesURL($order, $detail->linenbr); ?>" class="load-notes" title="View Order Notes" data-modal="<?= $orderpanel->modal; ?>">
					<i class="material-icons md-36" aria-hidden="true">&#xE0B9;</i>
				</a>
			<?php else : ?>
				<a href="<?= $orderpanel->generate_request_dplusnotesURL($order, $detail->linenbr); ?>" class="load-notes text-muted" title="View Order Notes" data-modal="<?= $orderpanel->modal; ?>">
					<i class="material-icons md-36" aria-hidden="true">&#xE0B9;</i>
				</a>
			<?php endif; ?>
		</td> 
		<td><?= $orderpanel->generate_detailreorderform($order, $detail); ?></td> 
		<td>
			<!--  Documents Link -->
            <?php if ($detail->has_documents()) : ?>
                <a href="<?= $orderpanel->generate_request_documentsURL($order, $detail); ?>" class="h3 generate-load-link" title="View Documents" data-loadinto="#sales-history-panel" data-focus="#sales-history-panel">
                    <i class="fa fa-file-text" aria-hidden="true"></i>
                </a>
            <?php else : ?>
                <a href="#" class="h3 text-muted" title="No Documents Found">
                    <i class="fa fa-file-text" aria-hidden="true"></i>
                </a>
            <?php endif; ?>
		</td>
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
					<td class="text-right"><?= DplusDateTime::format_dplustime($itemdoc['createtime']) ?></td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
	<?php endif; ?>
<?php endforeach; ?>
