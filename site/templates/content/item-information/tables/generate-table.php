<table class="table table-bordered table-striped table-condensed table-excel">
    <?php foreach ($columns as $column) : ?>
        <?php if (isset($itemjson['data'][$column])) : ?>
            <?php if (is_numeric($itemjson['data'][$column])) : ?>
                <tr>
                    <td class="control-label"><?php echo $itemjson['columns'][$column]; ?></td>
                    <td class="text-right"><?php echo $itemjson['data'][$column]; ?></td>
                </tr>
            <?php else : ?>
                <tr>
                    <td class="control-label"><?php echo $itemjson['columns'][$column]; ?></td>
                    <td><?php echo $itemjson['data'][$column]; ?></td>
                </tr>
            <?php endif; ?>
        <?php endif; ?>
    <?php endforeach; ?>
</table>
