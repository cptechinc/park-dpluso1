<?php $pricingfile = $config->jsonfilepath.session_id()."-price.json"; ?>

<?php if (file_exists($pricingfile)) : ?>
    <?php $jsonpricing = json_decode(file_get_contents($pricingfile), true); $columns = array(); ?>
    <div style="height: 150px; overflow-y: auto;">
        <?php if ($jsonpricing['error']) : ?>
            <div class="alert alert-warning" role="alert"><?php echo $jsonpricing['errormsg']; ?></div>
        <?php else : ?>
            <table class="table item-pricing table-striped table-condensed table-bordered print-hidden">
                <thead>
                    <tr>
                        <?php foreach($jsonpricing['columns'] as $column => $name) : ?>
                            <?php $columns[] = $column; ?> <th><?= $name; ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($jsonpricing['data'] as $warehouse) : ?>
                        <tr>
                            <?php foreach ($columns as $column) : ?>
                                <?php if (is_numeric($warehouse[$column])) : ?>
                                    <td class="text-right"><?= $warehouse[$column]; ?></td>
                                <?php else : ?>
                                    <td><?= $warehouse[$column]; ?></td>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
<?php else : ?>
    <div class="alert alert-warning" role="alert">Information Not Available</div>
<?php endif; ?>
