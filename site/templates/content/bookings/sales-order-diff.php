<?php 
	use Dplus\Dpluso\Bookings\BookingsPanel;
	
	$bookingspanel = new BookingsPanel(session_id(), $page->fullURL); 
	$date = $input->get->text('date');
	$details = $bookingspanel->get_bookingdayorderdetails($ordn, $date);
?>
<?= $bookingspanel->generate_viewsalesordersbydaybacklink($date); ?>
<div class="table-responsive">
	<table class="table table-bordered table-condensed table-striped">
		<thead> 
			<tr> <th>Item ID</th> <th>Before Qty</th> <th>After Qty</th> <th>Before Price</th> <th>After Price</th> <th>Net Amount</th> </tr> 
		</thead>
		<tbody>
			<?php foreach ($details as $detail) : ?>
				<tr>
					<td><?= $detail['itemid']; ?></td>
					<td class="text-right <?= ($detail['b4qty'] > 0 && $detail['b4qty'] != $detail['afterqty']) ? 'bg-danger' : ''; ?>"><?= $detail['b4qty']; ?></td>
					<td class="text-right <?= ($detail['b4qty'] > 0 && $detail['b4qty'] != $detail['afterqty']) ? 'bg-success' : ''; ?>"><?= $detail['afterqty']; ?></td>
					<td class="text-right <?= ($detail['b4price'] > 0 && $detail['b4price'] != $detail['afterprice']) ? 'bg-danger' : ''; ?>"><?= $detail['b4price']; ?></td>
					<td class="text-right <?= ($detail['b4price'] > 0 && $detail['b4price'] != $detail['afterprice']) ? 'bg-success' : ''; ?>"><?= $detail['afterprice']; ?></td>
					<td class="text-right <?= $detail['netamount'] > 0 ? 'bg-success' : 'bg-danger'; ?>"><?= $detail['netamount']; ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
