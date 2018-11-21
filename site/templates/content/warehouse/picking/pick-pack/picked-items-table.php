<?php $pickedbarcodes = $whsesession->get_orderpickeditems($pickitem->itemid); ?>
<table class="table table-condensed table-striped">
    <tr>
        <th>Barcode</th>
        <th>Qty</th>
        <th>Pallet</th>
        <?php if (100 == 1) : ?>
            <th class="text-center">Duplicate</th>
        <?php endif; ?>
        <th class="text-center">Remove</th>
    </tr>
    <?php foreach ($pickedbarcodes as $pickedbarcode) : ?>
        <tr>
            <td><?= $pickedbarcode['barcode']; ?></td>
            <td class="text-right"><?= $pickedbarcode['qty']; ?></td>
            <td class="text-right"><?= $pickedbarcode['palletnbr']; ?></td>
            <?php if (100 == 1) : ?>
                <td class="text-center">
                    <a href="<?= $pickorder->generate_addbarcodeurl($pickitem, $pickedbarcode['barcode'], $pickedbarcode['palletnbr']); ?>" class="btn btn-sm btn-emerald">
                        <i class="fa fa-repeat" aria-hidden="true"></i> Duplicate
                    </a>
                </td>
            <?php endif; ?>
            <td class="text-center">
                <a href="<?= $pickorder->generate_removebarcodeurl($pickitem, $pickedbarcode['barcode'], $pickedbarcode['palletnbr']); ?>" class="btn btn-sm btn-danger">
                    <i class="fa fa-trash" aria-hidden="true"></i> Remove
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
