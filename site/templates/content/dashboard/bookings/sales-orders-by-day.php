<?php 
	$bookingspanel = new Dplus\Dpluso\Bookings\BookingsPanel(session_id(), $page->fullURL, '#ajax-modal'); 
	$date = $input->get->text('date');
	$salesorders = $bookingspanel->get_daybookingordernumbers($date);
	$count = $bookingspanel->count_daybookingordernumbers($date);
?>
<div class="table-responsive">
	<table class="table table-bordered table-condensed table-striped">
		<thead> 
			<tr> <th>Date</th> <th>Sales Order #</th> <th>Customer</th> <th>Shipto ID</th> <th>View</th> </tr> 
		</thead>
		<tbody>
			<?php if ($count) : ?>
				<?php foreach ($salesorders as $salesorder) : ?>
					<?php $customer = Customer::load($salesorder['custid'], $salesorder['shiptoid']); ?>
					<tr>
						<td><?= Dplus\Base\DplusDateTime::format_date($salesorder['bookdate']); ?></td>
						<td class="text-right"><?= $salesorder['salesordernbr']; ?></td>
						<?php if ($customer) : ?>
							<td><a href="<?= $customer->generate_customerURL(); ?>"><?= $customer->get_customername(); ?></a> <span class="glyphicon glyphicon-share"></span></td>
							<td><?= $customer->shiptoid; ?></td>
						<?php else : ?>
							<td><?= $salesorder['custid']; ?></td>
							<td><?= $salesorder['shiptoid']; ?></td>
						<?php endif; ?>
						<td class="text-right"><?= $bookingspanel->generate_viewsalesorderdaylink($salesorder['salesordernbr'], Dplus\Base\DplusDateTime::format_date($salesorder['bookdate'])); ?></td>
					</tr>
				<?php endforeach; ?>
			<?php else : ?>
				<tr>
					<td colspan="5" class="text-center">
						No Bookings found
					</td>
				</tr>
			<?php endif; ?>
		</tbody>
	</table>
</div>
