<?php use Dplus\Dpluso\ScreenFormatters\TableScreenMaker; ?>

<?php $trackings = get_ordertracking(session_id(), $order->ordernumber); ?>
<?php foreach($trackings as $tracking) : ?>
	<?php $carrier = $tracking['servtype']; $link = ""; $link = TableScreenMaker::generate_trackingurl($tracking['servtype'], $tracking['tracknbr'], $order->ordernumber); ?>
    <tr class="detail tracking">
        <td colspan="3"><b>Shipped:</b>  <?= $carrier; ?></td>
		<td colspan="2"><b>Tracking No.:</b>
            <?php if ($link == "#$order->ordernumber" ): ?>
                <?php echo $tracking['tracknbr']; ?>
            <?php else : ?>
                <b><a href="<?= $link; ?>"target="_blank" title="Click To Track"><?= $tracking['tracknbr']; ?></a></b>
            <?php endif; ?>
        </td>
       	<td></td>
		<td colspan="2"><b>Weight: </b><?= $tracking['weight']; ?></td>
       	<td colspan="2"><b>Ship Date: </b><?= $tracking['shipdate']; ?> </td>
       	<td></td>
    </tr>
<?php endforeach; ?>
