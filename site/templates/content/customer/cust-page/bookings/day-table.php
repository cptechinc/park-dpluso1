<table class="table table-bordered table-condensed table-striped">
	<thead> 
		<tr> <th>Date</th> <th>Amount</th> <th>View</th> </tr> 
	</thead>
	<tbody>
		<?php foreach ($bookings as $booking) : ?>
			<tr>
				<td>
					<?= Dplus\Base\DplusDateTime::format_date($booking['bookdate']); ?>
				</td>
				<td class="text-right">$ <?= $page->stringerbell->format_money($booking['amount']); ?></td>
				<td class="text-right"><?= $bookingspanel->generate_viewsalesordersbydaylink($booking['bookdate']); ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
