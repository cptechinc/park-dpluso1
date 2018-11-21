<?php $shiptobookings = $bookingspanel->get_bookingtotalsbyshipto(); ?>
<table class="table table-bordered table-condensed table-striped" id="bookings-by-shipto">
	<thead> 
		<tr><th>Customer</th> <th>Amount</th> </tr> 
	</thead>
	<tbody>
		<?php foreach ($shiptobookings as $shiptobooking) : ?>
			<?php $shipto = Customer::load($shiptobooking['custid']); ?>
			<tr>
				<td><?= Customer::get_customernamefromid($shiptobooking['custid'], $shiptobooking['shiptoid']); ?></td>
				<td class="text-right">$ <?= $page->stringerbell->format_money($shiptobooking['amount']); ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
