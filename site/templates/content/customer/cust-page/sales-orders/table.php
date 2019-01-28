<?php
	use Dplus\Base\DplusDateTime;
	$orderpanel->get_orders();
?>
<table class="table table-striped table-bordered table-condensed" id="orders-table">
	<thead>
       <?php include $config->paths->content.'customer/cust-page/sales-orders/thead-rows.php'; ?>
    </thead>
    <tbody>
		<?php if (isset($input->get->ordn)) : ?>
			<?php if ($orderpanel->count == 0 && $input->get->text('ordn') == '') : ?>
                <tr>
					<td colspan="12" class="text-center">No Orders found!</td>
				</tr>
            <?php endif; ?>
        <?php endif; ?>
        <?php foreach ($orderpanel->orders as $order) : ?>
            <tr class="<?= $order->ordernumber == $input->get->text('ordn') ? 'selected' : ''; ?>" id="<?= $order->ordernumber; ?>">
            	<td class="text-center">
					<?php if ($order->ordernumber == $input->get->text('ordn')) : ?>
						<a href="<?= $orderpanel->generate_closedetailsURL($order); ?>" class="btn btn-sm btn-primary load-link" <?= $orderpanel->ajaxdata; ?>>
							<i class="fa fa-minus" aria-hidden="true"></i> <span class="sr-only">Close <?= $order->ordernumber; ?> Details</span>
						</a>
					<?php else : ?>
						<a href="<?= $orderpanel->generate_request_detailsURL($order); ?>" class="btn btn-sm btn-primary generate-load-link" <?= $orderpanel->ajaxdata; ?>>
							<i class="fa fa-plus" aria-hidden="true"></i> <span class="sr-only">Load <?= $order->ordernumber; ?> Details</span>
						</a>
					<?php endif; ?>
            	</td>
                <td> <?= $order->ordernumber; ?></td>
                <td><?= $order->custpo; ?></td>
                <td>
                    <a href="<?= $orderpanel->generate_customershiptoURL($order); ?>"><?= $order->shiptoid; ?></a>
                    <span class="pull-right"><?= $orderpanel->generate_shiptopopover($order); ?></span>
                </td>
                <td align="right">$ <?= $page->stringerbell->format_money($order->total_order); ?></td> <td align="right" ><?= DplusDateTime::format_date($order->order_date); ?></td>
                <td align="right"><?= $order->get_statusdescription(); ?></td>
                <td colspan="4">
					<!--  Documents Link -->
                    <span class="col-xs-3">
						<?php if ($order->has_documents()) : ?>
							<a href="<?= $orderpanel->generate_request_documentsURL($order); ?>" class="h3 generate-load-link" title="View Documents" data-loadinto="#orders-panel" data-focus="#orders-panel">
			                    <i class="fa fa-file-text" aria-hidden="true"></i>
			                </a>
						<?php else : ?>
							<a href="#" class="h3 text-muted" title="No Documents Found">
								<i class="fa fa-file-text" aria-hidden="true"></i>
							</a>
						<?php endif; ?>
					</span>
					<!-- Notes Link -->
                    <span class="col-xs-3">
						<?php if ($order->has_notes()) : ?>
							<a href="<?= $orderpanel->generate_request_dplusnotesURL($order, 0); ?>" class="load-notes" title="View and Create Order Notes" data-modal="<?= $quotepanel->modal; ?>">
								<i class="material-icons md-36" aria-hidden="true">&#xE0B9;</i>
							</a>
						<?php else : ?>
							<a href="<?= $orderpanel->generate_request_dplusnotesURL($order, 0); ?>" class="load-notes text-muted" title="Create Order Notes" data-modal="<?= $quotepanel->modal; ?>">
								<i class="material-icons md-36" aria-hidden="true">&#xE0B9;</i>
							</a>
						<?php endif; ?>
                    </span>
					<!--  Order Tracking Link -->
                    <span class="col-xs-3">
						<?php if ($order->has_tracking()) : ?>
							<a href="<?= $orderpanel->generate_request_trackingURL($order); ?>" class="h3 generate-load-link" title="View Tracking" data-loadinto="#orders-panel" data-focus="#orders-panel">
								<i class="fa fa-plane hover" aria-hidden="true"></i>
							</a>
						<?php else : ?>
							<a href="#" class="h3 text-mutled" title="No Tracking info Available">
								<i class="fa fa-plane hover" aria-hidden="true"></i>
							</a>
						<?php endif; ?>
					</span>
					<!-- Edit Link -->
                    <span class="col-xs-3">
						<?php if ($order->can_edit()) : ?>
							<a href="<?= $orderpanel->generate_editURL($order); ?>" class="edit-order h3" title="Edit Order">
								<i class="fa fa-pencil" aria-hidden="true"></i>
							</a>
						<?php elseif ($order->is_lockedbyuser()) : ?>
							<a href="<?= $orderpanel->generate_editURL($order); ?>" class="edit-order h3" title="Continue Editing Order">
								<i class="fa fa-wrench" aria-hidden="true"></i>
							</a>
						<?php else : ?>
							<a href="<?= $orderpanel->generate_editURL($order); ?>" class="edit-order h3" title="Open in read-only mode">
								<i class="fa fa-eye" aria-hidden="true"></i>
							</a>
						<?php endif; ?>
					</span>
                </td>
            </tr>

            <?php if ($order->ordernumber == $input->get->text('ordn')) : ?>
				<?php
					if ($input->get->show == 'documents' && (!$input->get('item-documents')))  {
						include $config->paths->content.'customer/cust-page/sales-orders/documents-rows.php';
					}
					include $config->paths->content.'customer/cust-page/sales-orders/detail-rows.php';
					include $config->paths->content.'customer/cust-page/sales-orders/total-rows.php';

					if ($input->get->text('show') == 'tracking') {
						include $config->paths->content.'customer/cust-page/sales-orders/tracking-rows.php';
					}
				?>
		    	<?php if ($order->has_error()) : ?>
		            <tr class="detail bg-danger" >
		                <td colspan="2" class="text-center"><b class="text-danger">Error:</b></td>
		                <td colspan="2"><?= $order->errormsg; ?></td> <td></td> <td></td>
		                <td colspan="2"> </td> <td></td> <td></td> <td></td>
		            </tr>
		        <?php endif; ?>
	             <tr class="detail last-detail">
	             	<td colspan="2">
						<a href="<?= $orderpanel->generate_printURL($order); ?>" target="_blank">
							<span class="h4"><i class="fa fa-print" aria-hidden="true"></i></span> View Printable Order
						</a>
					</td>
					<td colspan="3">
						<a href="<?= $orderpanel->generate_linkeduseractionsURL($order); ?>" class="load-into-modal" data-modal="<?= $orderpanel->modal; ?>">
							<span class="h4"><i class="fa fa-check-square-o" aria-hidden="true"></i></span> View Associated Actions
						</a>
					</td>
	                <td>
	                	<a class="btn btn-primary btn-sm" onClick="reorder('<?= $order->ordernumber; ?>')">
	                    	<span class="glyphicon glyphicon-shopping-cart" title="re-order"></span> Reorder Order
	                    </a>
	                </td>
	                <td></td>
					<td></td>
	                <td colspan="2">
	                    <div class="pull-right">
							<a class="btn btn-danger btn-sm load-link" href="<?= $orderpanel->generate_closedetailsURL($order); ?>" <?= $orderpanel->ajaxdata; ?>>Close</a>
						</div>
	                </td>
	             	<td></td>
	             </tr>
        	<?php endif; ?>
        <?php endforeach; ?>
    </tbody>
</table>
