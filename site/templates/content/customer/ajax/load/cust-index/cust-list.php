<?php
	include $config->paths->content."customer/ajax/load/index/search-index-form.php";
	$custID = '';
	$custlink = $config->pages->customer."redir/?action=ci-select";

	if ($input->get->q) {
		$custresults = search_custindexpaged($input->get->text('q'), $config->showonpage, $input->pageNum);
		$resultscount = count_searchcustindex($input->get->text('q'));
	}
?>
<div class="list-group" id="cust-results">
	<?php if ($input->get->q) : ?>
		<table id="cust-index" class="table table-striped table-bordered">
			<thead>
				<tr>
					<th width="100">CustID</th> <th>Customer Name</th> <th>Ship-To</th> <th>Location</th><th width="100">Phone</th>
				</tr>
			</thead>
			<tbody>
				<?php if ($resultscount > 0) : ?>
					<?php foreach ($custresults as $cust) : ?>
					   <tr>
						   <td>
							<a href="<?= $cust->generate_ciloadurl(); ?>">
								<?= $page->bootstrap->highlight($cust->custid, $input->get->text('q'));?>
							</a> &nbsp; <span class="glyphicon glyphicon-share"></span>
						</td>
						   <td><?= $page->bootstrap->highlight($cust->name, $input->get->q); ?></td>
						<td><?= $page->bootstrap->highlight($cust->shiptoid, $input->get->q); ?></td>
						<td><?= $page->bootstrap->highlight($cust->generate_address(), $input->get->q); ?></td>
						   <td><a href="tel:<?= $cust->phone; ?>" title="Click To Call"><?= $page->bootstrap->highlight($cust->phone, $input->get->q); ?></a></td>
					   </tr>
					<?php endforeach; ?>
				<?php else : ?>
					<td colspan="5">
						<h4 class="list-group-item-heading">No Customer Matches your query.</h4>
					</td>
				<?php endif; ?>
			</tbody>
		</table>
	<?php endif; ?>
</div>
