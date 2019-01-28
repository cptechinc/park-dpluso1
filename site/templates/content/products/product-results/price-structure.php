<table class="table-condensed table-bordered table">
    <?php if ($item->priceqty2 != "" && $item->priceqty2 != "0") : ?>
        <tr> <th>Qty</th> <th class="text-right">Break</th> </tr>
        <tr> <td><?= $item->priceqty1; ?></td> <td class="text-right">$ <?= $item->priceprice1; ?></td> </tr>
        <tr> <td><?= $item->priceqty2; ?></td> <td class="text-right">$ <?= $item->priceprice2; ?></td> </tr>
        <?php if ($item->priceqty3 != "" && $item->priceqty3 != "0") : ?>
            <tr> <td><?= $item->priceqty3; ?></td> <td class="text-right">$ <?= $item->priceprice3; ?></td> </tr>
        <?php endif; ?>
        <?php if ($item->priceqty4 != "" && $item->priceqty4 != "0") : ?>
            <tr> <td><?= $item->priceqty4; ?></td> <td class="text-right">$ <?= $item->priceprice4; ?></td> </tr>
        <?php endif; ?>
        <?php if ($item->priceqty5 != "" && $item->priceqty5 != "0") : ?>
            <tr> <td><?= $item->priceqty5; ?></td> <td class="text-right">$ <?= $item->priceprice5; ?></td> </tr>
        <?php endif; ?>
        <?php if ($item->priceqty6 != "" && $item->priceqty6 != "0") : ?>
            <tr> <td><?= $item->priceqty6; ?></td> <td class="text-right">$ <?= $item->priceprice6; ?></td> </tr>
        <?php endif; ?>
    <?php else : ?>
        No data to display
    <?php endif; ?>
</table>
