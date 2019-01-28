<?php 
    use Dplus\Base\DplusDateTime;
    $details = $orderpanel->get_orderdetails($order);
?>
<tr class="detail item-header">
    <th></th>
    <th colspan="3" class="text-center">Item ID/Description</th>
    <th class="text-right">Ordered</th>
    <th class="text-right" width="100">Total</th>
    <th class="text-right">Back Order</th>
    <th class="text-right">Shipped</th>
    <th>Notes</th>
    <th>Reorder</th>
    <th>Documents</th>
</tr>
<?php foreach ($details as $detail) : ?>
    <tr class="detail">
        <td></td>
        <td colspan="3">
            <a href="<?= $orderpanel->generate_vieweditdetailURL($order, $detail); ?>" class="update-line" data-kit="<?= $detail->kititemflag; ?>" data-itemid="<?= $detail->itemid; ?>" data-custid="<?= $order->custid; ?>" aria-label="View Detail Line">
				<?= $detail->itemid; ?>
			</a>
            <?= strlen($detail->vendoritemid) ? "($detail->vendoritemid)" : ''; ?> <br>
            <?= $detail->desc1. ' ' . $detail->desc2 ; ?>
        </td>
        <td class="text-right"><?= intval($detail->qty); ?></td>
        <td class="text-right">
            <span class="has-hover" data-toggle="tooltip" data-placement="top" title="<?= 'Price / UoM: $'.$page->stringerbell->format_money($detail->price); ?>">
				$ <?= $page->stringerbell->format_money($detail->totalprice); ?>
			</span>
        </td>
        <td class="text-right"><?= intval($detail->qtybackord); ?></td>
        <td class="text-right"><?= intval($detail->qtyshipped); ?></td>
        <td>
            <?php if ($detail->has_notes()) : ?>
				<a href="<?= $orderpanel->generate_request_dplusnotesURL($order, $detail->linenbr); ?>" class="load-notes" title="View and Create Order Notes" data-modal="<?= $quotepanel->modal; ?>">
					<i class="material-icons md-36" aria-hidden="true">&#xE0B9;</i>
				</a>
			<?php else : ?>
				<a href="<?= $orderpanel->generate_request_dplusnotesURL($order, $detail->linenbr); ?>" class="load-notes text-muted" title="Create Order Notes" data-modal="<?= $quotepanel->modal; ?>">
					<i class="material-icons md-36" aria-hidden="true">&#xE0B9;</i>
				</a>
			<?php endif; ?>
        </td>
        <td><?= $orderpanel->generate_detailreorderform($order, $detail); ?></td>
        <td>
            <!--  Documents Link -->
            <?php if ($detail->has_documents()) : ?>
                <a href="<?= $orderpanel->generate_request_documentsURL($order, $detail); ?>" class="h3 generate-load-link" title="View Documents" data-loadinto="#orders-panel" data-focus="#orders-panel">
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
                        <b><a href="<?= $config->pathtofiles.$itemdoc['pathname'];; ?>" title="Click to View Document" target="_blank" ><?php echo $itemdoc['title']; ?></a></b>
                    </td>
                    <td align="right"><?= $itemdoc['createdate']; ?></td>
                    <td align="right"><?= DplusDateTime::format_dplustime($itemdoc['createtime']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php endif; ?>
<?php endforeach; ?>
