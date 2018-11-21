<table class="table table-striped table-bordered table-condensed" id="quotes-table">
	<thead>
		<?php include $config->paths->content.'dashboard/quotes/thead-rows.php'; ?>
	</thead>
	<tbody>
		<?php if (isset($input->get->qnbr)) : ?>
			<?php if ($quotepanel->count == 0 && $input->get->text('qnbr') == '') : ?>
				<tr> <td colspan="9" class="text-center">No Quotes found! Try using a date range to find the quotes(s) you are looking for.</td> </tr>
			<?php endif; ?>
		<?php endif; ?>

		<?php $quotepanel->get_quotes(); ?>
		<?php foreach ($quotepanel->quotes as $quote) : ?>
			<tr class="<?= $quote->quotnbr == $input->get->text('qnbr') ? 'selected' : ''; ?>" id="<?= $quote->quotnbr; ?>">
				<td class="text-center">
					<?php if ($quote->quotnbr == $input->get->text('qnbr')) : ?>
						<a href="<?= $quotepanel->generate_closedetailsurl($quote); ?>" class="btn btn-sm btn-primary load-link" <?= $quotepanel->ajaxdata; ?>>
							<i class="fa fa-minus" aria-hidden="true"></i> <span class="sr-only">Close <?= $quote->quotnbr; ?> Details</span>
						</a>
					<?php else : ?>
						<a href="<?= $quotepanel->generate_loaddetailsurl($quote); ?>" class="btn btn-sm btn-primary generate-load-link" <?= $quotepanel->ajaxdata; ?>>
							<i class="fa fa-plus" aria-hidden="true"></i> <span class="sr-only">Load <?= $quote->quotnbr; ?> Details</span>
						</a>
					<?php endif; ?>
				</td>
				<td><?= $quote->quotnbr; ?></td>
				<td><a href="<?= $quotepanel->generate_customerurl($quote); ?>"><?= $quote->custid; ?></a> <span class="glyphicon glyphicon-share" aria-hidden="true"></span><br><?= Customer::get_customernamefromid($quote->custid); ?></td>
				<td><?= $quote->shiptoid; ?></td>
				<td><?= $quote->quotdate; ?></td>
				<td><?= $quote->revdate; ?></td>
				<td><?= $quote->expdate; ?></td>
				<td class="text-right">$ <?= $page->stringerbell->format_money($quote->subtotal); ?></td>
				<td><?= $quotepanel->generate_loaddplusnoteslink($quote, '0'); ?></td>
				<td><?= $quotepanel->generate_editlink($quote); ?></td>
			</tr>

			<?php if ($quote->quotnbr == $input->get->text('qnbr')) : ?>
				<?php if ($quote->error == 'Y') : ?>
					<tr class="detail bg-danger" >
						<td></td>
						<td></td>
						<td colspan="3"><b>Error: </b><?= $quote->errormsg; ?></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
				<?php endif; ?>
				<?php include $config->paths->content."dashboard/quotes/detail-rows.php"; ?>
				<?php include $config->paths->content."dashboard/quotes/totals-rows.php"; ?>
				<tr class="detail last-detail">
					<td></td>
					<td></td>
					<td> <?= $quotepanel->generate_viewprintlink($quote); ?> </td>
					<td> <?= $quotepanel->generate_orderquotelink($quote); ?> </td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td><a href="<?= $quotepanel->generate_closedetailsurl(); ?>" class="btn btn-sm btn-danger load-link" <?= $quotepanel->ajaxdata; ?>>Close</a></td>
					<td></td>
				</tr>
			<?php endif; ?>
		<?php endforeach; ?>
	</tbody>
</table>
