<table class="table table-striped table-bordered table-condensed order-listing-table">
	<thead>
		<?php include $config->paths->content.'customer/cust-page/sales-history/thead-rows.php'; ?>
	</thead>
	<tbody>
		<?php if ($orderpanel->count == 0 && $input->get->text('ordn') == '') : ?>
			<tr> <td colspan="12" class="text-center">No Orders found! Try using a date range to find the order(s) you are looking for.</td> </tr>
		<?php endif; ?>

		<?php $orderpanel->get_orders(); ?>
		<?php foreach($orderpanel->orders as $order) : ?>
			<tr class="<?= $order->ordernumber == $input->get->text('ordn') ? 'selected' : ''; ?>" id="<?= $order->ordernumber; ?>">
				<td class="text-center">
					<?php if ($order->ordernumber == $input->get->text('ordn')) : ?>
						<a href="<?= $orderpanel->generate_closedetailsurl($order); ?>" class="btn btn-sm btn-primary load-link" <?= $orderpanel->ajaxdata; ?>>
							<i class="fa fa-minus" aria-hidden="true"></i> <span class="sr-only">Close <?= $order->ordernumber; ?> Details</span>
						</a>
					<?php else : ?>
						<a href="<?= $orderpanel->generate_loaddetailsurl($order); ?>" class="btn btn-sm btn-primary generate-load-link" <?= $orderpanel->ajaxdata; ?>>
							<i class="fa fa-plus" aria-hidden="true"></i> <span class="sr-only">Load <?= $order->ordernumber; ?> Details</span>
						</a>
					<?php endif; ?>
				</td>
				<td><?= $order->ordernumber; ?></td>
				<td colspan="2"><?= $order->custpo; ?></td>
				<td>
					<a href="<?= $orderpanel->generate_customershiptourl($order); ?>"><?= $order->shiptoid; ?></a>
					<span class="pull-right"><?= $orderpanel->generate_shiptopopover($order); ?></span>
				</td>
				<td class="text-right">$ <?= $page->stringerbell->format_money($order->total_order); ?></td>
				<td class="text-right"><?= Dplus\Base\DplusDateTime::format_date($order->order_date); ?></td>
				<td class="text-right"><?= Dplus\Base\DplusDateTime::format_date($order->invoice_date); ?></td>
				<td colspan="3">
					<span class="col-xs-3"><?= $orderpanel->generate_loaddocumentslink($order); ?></span>
					<span class="col-xs-3"><?= $orderpanel->generate_loadtrackinglink($order); ?></span>
					<span class="col-xs-3"><?= $orderpanel->generate_loaddplusnoteslink($order, '0'); ?></span>
				</td>
			</tr>

			<?php if ($order->ordernumber == $input->get->text('ordn')) : ?>
				<?php if ($input->get->show == 'documents' && (!$input->get('item-documents'))) : ?>
					<?php include $config->paths->content.'customer/cust-page/sales-history/documents-rows.php'; ?>
				<?php endif; ?>

				<?php include $config->paths->content.'customer/cust-page/sales-history/detail-rows.php'; ?>

				<?php include $config->paths->content.'customer/cust-page/sales-history/totals-rows.php'; ?>

				<?php if ($input->get->text('show') == 'tracking') : ?>
					<?php include $config->paths->content.'customer/cust-page/sales-history/tracking-rows.php'; ?>
				<?php endif; ?>

				<?php if ($order->error == 'Y') : ?>
					 <tr class="detail bg-danger" >
						<td colspan="2" class="text-center"><b class="text-danger">Error:</b></td>
						<td colspan="2"><?= $order->errormsg; ?></td> <td></td> <td></td>
						<td colspan="2"> </td> <td></td> <td></td> <td></td>
					 </tr>
				<?php endif; ?>

				<tr class="detail last-detail">
					<td colspan="2">
						<?= $orderpanel->generate_viewprintlink($order); ?>
					</td>
					<td colspan="3">
						<?= $orderpanel->generate_viewlinkeduseractionslink($order); ?>
					</td>
					<td>
						<a class="btn btn-primary btn-sm" onClick="reorder('<?= $order->ordernumber; ?>')">
							<span class="glyphicon glyphicon-shopping-cart" title="re-order"></span> Reorder Order
						 </a>
					</td>
					<td></td>
					<td></td>
					<td colspan="2">
						<div class="pull-right"> <a class="btn btn-danger btn-sm load-link" href="<?= $orderpanel->generate_closedetailsurl($order); ?>" <?= $orderpanel->ajaxdata; ?>>Close</a> </div>
					</td>
					<td></td>
				</tr>
			<?php endif; ?>
		<?php endforeach; ?>
	 </tbody>
</table>
