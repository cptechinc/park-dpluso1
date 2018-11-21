<?php
	$customers = get_topxsellingcustomers(25);
	$data = array();
	$page->has_salesdata = sizeof($customers);
?>
<div class="panel panel-primary not-round" id="customer-sales-panel">
	<div class="panel-heading not-round" id="customer-sale-panel-heading">
		<a href="#salesdata-div" class="panel-link" data-parent="#tasks-panel" data-toggle="collapse" aria-expanded="true">
			<span class="glyphicon glyphicon-book"></span> &nbsp; Top 25 customers <span class="caret"></span>
		</a>
	</div>
	<div id="salesdata-div" class="" aria-expanded="true">
		<?php if (sizeof($customers)) : ?>
			<div>
				<div class="row">
					<div class="col-sm-4">
						<div id="cust-sales-graph">

						</div>
					</div>
					<div class="col-sm-8">
						<div class="table-responsive">
							<table class="table table-bordered table-condensed table-striped" id="cust-sales">
								<thead>
									<tr> <th>Color</th> <th>CustID</th> <th>Name</th> <th>Amount Sold</th> <th>Times Sold</th> <th>Last Sale Date</th> </tr>
								</thead>
								<tbody>
									<?php foreach ($customers as $customer) : ?>
										<?php $cust = Customer::load($customer['custid']); ?>
										<?php $data[] = $cust->generate_piesalesdata($customer['amountsold']); ?>
										<tr>
											<td id="<?= $customer['custid'].'-cust'; ?>"></td>
											<td>
												<a href="<?= $cust->generate_ciloadurl(); ?>" class="btn btn-primary btn-block btn-sm"><?= $customer['custid']; ?></a>
											</td>
											<td><?= $cust->get_name(); ?></td>
											<td class="text-right">$ <?= $page->stringerbell->format_money($customer['amountsold']); ?></td>
											<td class="text-right"><?= $customer['timesold']; ?></td>
											<td class="text-right"><?= $customer['lastsaledate'] == 0 ? '' : Dplus\Base\DplusDateTime::format_date($customer['lastsaledate']); ?></td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		<?php else : ?>
			<div>
				<p class="text-center">
					No Customer Sales Data found
				</p>
			</div>
		<?php endif; ?>
	</div>
</div>
