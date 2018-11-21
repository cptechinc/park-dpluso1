<?php 
	$bookingspanel = new Dplus\Dpluso\Bookings\CustomerBookingsPanel(session_id(), $page->fullURL, '#ajax-modal'); 
	$bookingspanel->set_customer($customer->custid, $customer->shiptoid);
	$date = $input->get->text('date');
	$salesorders = $bookingspanel->get_daybookingordernumbers($date);
	$count = $bookingspanel->count_daybookingordernumbers($date);
?>
<div class="table-responsive">
	<table class="table table-bordered table-condensed table-striped">
		<thead> 
			<tr> <th>Date</th> <th>Sales Order #</th> <th>View</th> </tr> 
		</thead>
		<tbody>
			<?php if ($count) : ?>
				<?php foreach ($salesorders as $salesorder) : ?>
					<tr>
						<td><?= Dplus\Base\DplusDateTime::format_date($salesorder['bookdate']); ?></td>
						<td class="text-right"><?= $salesorder['salesordernbr']; ?></td>
						<td class="text-right"><?= $bookingspanel->generate_viewsalesorderdaylink($salesorder['salesordernbr'], Dplus\Base\DplusDateTime::format_date($salesorder['bookdate'])); ?></td>
					</tr>
				<?php endforeach; ?>
			<?php else : ?>
				<tr>
					<td colspan="3" class="text-center">
						No Bookings found
					</td>
				</tr>
			<?php endif; ?>
		</tbody>
	</table>
</div>
