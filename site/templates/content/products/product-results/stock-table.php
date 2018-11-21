<?php $warehouses = $item->get_availability(); ?>
<table class="table-condensed table-bordered table">
    <thead>
        <tr><th>Whse</th> <th>Name</th> <th>Available</th> <th>On-Order</th> <th>ETA</th></tr>
    </thead>
    <tbody>
        <?php foreach ($warehouses as $whse) : ?>
            <tr class="warehouse-tr <?= $whse['whsecd']; ?>-row">
                <td>
                    <button type="button" class="btn btn-primary btn-xs" onclick="choose_itemwhse('<?= cleanforjs($item->itemid); ?>', '<?= $whse['whsecd']; ?>')">
                        <?= $whse['whsecd']; ?>
                    </button>
                </td>
                <td><?= $whse['whsename']; ?></td>
                <td><?= $whse['itemavail']; ?></td>
                <td><?= $whse['itemonord']; ?></td>
                <td><?= $whse['itemetadt']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
