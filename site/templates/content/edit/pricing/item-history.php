<?php $historyfile = $config->jsonfilepath.session_id()."-prichist.json"; ?>
<?php if (file_exists($historyfile)) : ?>
    <?php $jsonhistory = json_decode(file_get_contents($historyfile), true); $columns = array(); ?>

    <?php if ($jsonhistory['error']) : ?>
        <div class="alert alert-warning" role="alert"><?php echo $jsonhistory['errormsg']; ?></div>
    <?php else : ?>
    <table class="table table-striped table-condensed table-bordered">
        <thead>
            <tr>
                <?php foreach($jsonhistory['columns'] as $column => $name) : ?>
                    <?php $columns[] = $column; ?> <th><?= $name; ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($jsonhistory['data'] as $warehouse) : ?>
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

<?php else : ?>
    <div class="alert alert-warning" role="alert">Information Not Available</div>
<?php endif ; ?>
