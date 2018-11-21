<?php $stockfile = $config->jsonfilepath.session_id()."-stock.json"; ?>

<?php if (file_exists($stockfile)) : ?>
    <?php $jsonstock = json_decode(file_get_contents($stockfile), true); $columns = array(); ?>
    <?php if ($jsonstock['error']) : ?>
        <div class="alert alert-warning" role="alert"><?php echo $jsonstock['errormsg']; ?></div>
    <?php else : ?>
        <div class="table-responsive">
            <table class="table table-striped table-condensed table-bordered">
                <thead>
                    <tr>
                        <?php foreach($jsonstock['columns'] as $column => $name) : ?>
                            <?php $columns[] = $column; ?> <th><?= $name; ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($jsonstock['data'] as $warehouse) : ?>
                        <tr class="warehouse-tr <?= $warehouse['Warehouse ID']."-row"; ?>">
                            <?php foreach ($columns as $column) : ?>
                                <?php if (is_numeric($warehouse[$column]) && $column != 'whse') : ?>
                                    <td class="text-right"><?= $warehouse[$column]; ?></td>
                                <?php else : ?>
                                    <?php if ($column == 'Warehouse ID') : ?>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-xs" onclick="chooseitemwhse('<?= $jsonstock['itemid']; ?>', '<?= $warehouse[$column]; ?>')"><?= $warehouse[$column]; ?></button>
                                        </td>
                                    <?php else : ?>
                                        <td><?= $warehouse[$column]; ?></td>
                                    <?php endif; ?>
                                <?php endif; ?>

                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
<?php else : ?>
    <div class="alert alert-warning" role="alert">Information Not Available</div>
<?php endif; ?>
