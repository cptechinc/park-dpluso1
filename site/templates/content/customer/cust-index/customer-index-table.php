<div class="table-responsive">
	<table id="cust-index" class="table table-striped table-bordered">
		<thead>
			<tr>
            	<th width="100">CustID</th> <th>Customer Name</th> <th>Ship-To</th> <th>Location</th> <th>Contact</th> <th width="100">Phone</th>
                <th>Amount Sold</th> <th>Times Sold</th> <th>Last Sales Date</th>
            </tr>
		</thead>
		<tbody>
			<?php if ($resultscount > 0) : ?>
				<?php
					if ($input->get->q) {
						$customer_records = $custindex->search_custindexpaged($input->get->text('q'), $input->pageNum);
					} else {
						$customer_records = $custindex->get_distinctcustindexpaged($input->pageNum);
					}
				?>
				<?php foreach ($customer_records as $cust) : ?>
					<tr>
						<td>
							<a href="<?= $cust->generate_ciloadurl(); ?>">
								<?= $page->bootstrap->highlight($cust->custid, $input->get->q);?>
							</a> &nbsp; <span class="glyphicon glyphicon-share"></span>
						</td>
						<td><?= $page->bootstrap->highlight($cust->name, $input->get->q); ?></td>
						<td><?= $page->bootstrap->highlight($cust->shiptoid, $input->get->q); ?></td>
						<td><?= $page->bootstrap->highlight($cust->generate_address(), $input->get->q); ?></td>
						<td><a href="<?= $cust->generate_contacturl(); ?>"><?= $page->bootstrap->highlight($cust->contact, $input->get->q); ?></a></td>
						<td><a href="tel:<?= $cust->phone; ?>" title="Click To Call"><?= $page->bootstrap->highlight($cust->phone, $input->get->q); ?></a></td>
						<td class="text-right">$ <?= $page->stringerbell->format_money($cust->get_amountsold()); ?></td>
						<td class="text-right"> <?= $cust->get_timesold(); ?></td>
						<td> <?= Dplus\Base\DplusDateTime::format_date($cust->get_lastsaledate()); ?></td>
					</tr>
				<?php endforeach; ?>
			<?php else : ?>
				<td colspan="9" class="text-center"><b>No Customers match your query.</b></td>
			<?php endif; ?>
		</tbody>
		<tfoot>
			<tr>
            	<th width="100">CustID</th> <th>Customer Name</th> <th>Ship-To</th> <th>Location</th> <th>Contact</th> <th width="100">Phone</th>
                <th>Amount Sold</th> <th>Times Sold</th> <th>Last Sales Date</th>
            </tr>
		</tfoot>
	</table>
</div>
<?php $total_pages = ceil($resultscount / $config->showonpage); $pagination_link = $config->pages->customer.'page'; ?>
<?php $linkaddon = (isset($input->get->q)) ? '?q='.$input->get->q : ''; ?>
<?php $insertafter = '/customers'; ?>
<?php include $config->paths->content.'pagination/pw/pagination-links.php'; ?>
