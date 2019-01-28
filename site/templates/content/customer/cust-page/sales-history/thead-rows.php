<tr>
	<th>Detail</th>
	<th>
		<a href="<?= $orderpanel->generate_sortbyURL("ordernumber") ; ?>" class="load-link" <?= $orderpanel->ajaxdata; ?>>
				Order # <?= $orderpanel->tablesorter->generate_sortsymbol('ordernumber'); ?>
		</a>
	</th>
	<th colspan="2">
		<a href="<?= $orderpanel->generate_sortbyURL("custpo") ; ?>" class="load-link" <?= $orderpanel->ajaxdata; ?>>
			Customer PO: <?= $orderpanel->tablesorter->generate_sortsymbol('custpo'); ?>
		</a>
	</th>
	<th>Ship-To</th>
	<th>
		<a href="<?= $orderpanel->generate_sortbyURL("total_order") ; ?>" class="load-link" <?= $orderpanel->ajaxdata; ?>>
			Order Totals <?= $orderpanel->tablesorter->generate_sortsymbol('total_order'); ?>
		</a>
	</th>
	<th>
		<a href="<?= $orderpanel->generate_sortbyURL("order_date") ; ?>" class="load-link" <?= $orderpanel->ajaxdata; ?>>
			Order Date: <?= $orderpanel->tablesorter->generate_sortsymbol('order_date'); ?>
		</a>
	</th>
	<th>
		<a href="<?= $orderpanel->generate_sortbyURL("invoice_date") ; ?>" class="load-link" <?= $orderpanel->ajaxdata; ?>>
			Invoice Date: <?= $orderpanel->tablesorter->generate_sortsymbol('invoice_date'); ?>
		</a>
	</th>
	<th colspan="3">
		<?= $orderpanel->generate_iconlegend(); ?>
		<?php if (isset($input->get->orderby)) : ?>
			<a href="<?= $orderpanel->generate_clearsortURL(); ?>" class="btn btn-warning btn-sm load-link" data-loadinto="<?= $orderpanel->loadinto; ?>" data-focus="<?= $orderpanel->focus; ?>">
				Clear Sorting
			</a>
		<?php endif; ?>
	</th>
</tr>
