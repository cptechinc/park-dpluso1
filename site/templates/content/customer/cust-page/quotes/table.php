<?php
	use Dplus\ProcessWire\DplusWire;
	$quotepanel->get_quotes();
?>
<table class="table table-striped table-bordered table-condensed" id="quotes-table">
	<thead>
       <?php include $config->paths->content.'customer/cust-page/quotes/thead-rows.php'; ?>
    </thead>
	<tbody>
		<?php if (isset($input->get->qnbr)) : ?>
			<?php if ($quotepanel->count == 0 && $input->get->text('qnbr') == '') : ?>
				<tr> <td colspan="9" class="text-center">No Quotes found! Try using a date range to find the quotes(s) you are looking for.</td> </tr>
			<?php endif; ?>
		<?php endif; ?>
		<?php foreach ($quotepanel->quotes as $quote) : ?>
			<tr class="<?= $quote->quotnbr == $input->get->text('qnbr') ? 'selected' : ''; ?>" id="<?= $quote->quotnbr; ?>">
				<td class="text-center">
					<?php if ($quote->quotnbr == $input->get->text('qnbr')) : ?>
						<a href="<?= $quotepanel->generate_closedetailsURL($quote); ?>" class="btn btn-sm btn-primary load-link" <?= $quotepanel->ajaxdata; ?>>
							<i class="fa fa-minus" aria-hidden="true"></i> <span class="sr-only">Close <?= $quote->quotnbr; ?> Details</span>
						</a>
					<?php else : ?>
						<a href="<?= $quotepanel->generate_request_detailsURL($quote); ?>" class="btn btn-sm btn-primary generate-load-link" <?= $quotepanel->ajaxdata; ?>>
							<i class="fa fa-plus" aria-hidden="true"></i> <span class="sr-only">Load <?= $quote->quotnbr; ?> Details</span>
						</a>
					<?php endif; ?>
				</td>
				<td><?= $quote->quotnbr; ?></td>
				<td><?= $quote->shiptoid; ?></td>
				<td><?= $quote->sp1name; ?></td>
				<td><?= $quote->quotdate; ?></td>
				<td><?= $quote->revdate; ?></td>
				<td><?= $quote->expdate; ?></td>
				<td class="text-right">$ <?= $quote->subtotal; ?></td>
				<td>
					<!-- Notes Link -->
					<?php if ($quote->has_notes()) : ?>
						<?php $title = ($quote->can_edit()) ? "View and Create Quote Notes" : "View Quote Notes"; ?>
						<a href="<?= $quotepanel->generate_request_dplusnotesURL($quote, 0); ?>" class="load-notes" title="<?= $title; ?>" data-modal="<?= $quotepanel->modal; ?>">
							<i class="material-icons md-36" aria-hidden="true">&#xE0B9;</i>
						</a>
					<?php else : ?>
						<?php $title = ($quote->can_edit()) ? "Create Quote Notes" : "View Quote Notes"; ?>
						<a href="<?= $quotepanel->generate_request_dplusnotesURL($quote, 0); ?>" class="load-notes text-muted" title="<?= $title; ?>" data-modal="<?= $quotepanel->modal; ?>">
							<i class="material-icons md-36" aria-hidden="true">&#xE0B9;</i>
						</a>
					<?php endif; ?>
				</td>
				<td>
					<!-- Edit Link -->
					<?php if (DplusWire::wire('user')->hasquotelocked) : ?>
						<a href="<?= $quotepanel->generate_editURL($quote); ?>" class="edit-order h3" title="Continue Editing">
							<i class="fa fa-wrench" aria-hidden="true"></i>
						</a>
					<?php else : ?>
						<a href="<?= $quotepanel->generate_editURL($quote); ?>" class="edit-order h3" title="Edit Quote">
							<i class="fa fa-pencil" aria-hidden="true"></i>
						</a>
					<?php endif; ?>
				</td>
			</tr>

			<?php if ($quote->quotnbr == $input->get->text('qnbr')) : ?>
				<?php if ($quote->has_error()) : ?>
	                <tr class="detail bg-danger" >
	                    <td></td>
	                    <td colspan="3"><b>Error: </b><?= $quote->errormsg; ?></td>
	                    <td></td>
	                    <td></td>
						<td></td>
						<td></td>
	                </tr>
	            <?php endif; ?>
				<?php include $config->paths->content."customer/cust-page/quotes/detail-rows.php"; ?>
				<?php include $config->paths->content."customer/cust-page/quotes/totals-rows.php"; ?>
				<tr class="detail last-detail">
					<td></td>
					<td>
						<a href="<?= $quotepanel->generate_printURL($quote); ?>" target="_blank">
							<i class="fa fa-print" aria-hidden="true"></i> View Printable Quote
						</a>
					</td>
					<td>
						<a href="<?= $quotepanel->generate_orderquoteURL($quote); ?>"class="btn btn-default">
							<i class="fa fa-paper-plane-o" aria-hidden="true"></i> Send To Order
						</a>
					</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td>
						<a href="<?= $quotepanel->generate_closedetailsURL(); ?>" class="btn btn-sm btn-danger load-link" <?= $quotepanel->ajaxdata; ?>>
							Close
						</a>
					</td>
					<td></td>
					<td></td>
				</tr>
			<?php endif; ?>
		<?php endforeach; ?>
	</tbody>
</table>
