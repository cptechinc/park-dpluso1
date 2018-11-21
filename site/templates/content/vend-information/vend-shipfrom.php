<?php
    $shipfromjson = json_decode(file_get_contents($config->jsonfilepath.session_id()."-vishipfrominfo.json"), true);
    // $shipfromjson = json_decode(file_get_contents($config->jsonfilepath."visftest-vishipfrominfo.json"), true);
    
?>
<div class="row">
    <div class="col-sm-2">
        <?php include $config->paths->content.'vend-information/vi-buttons.php'; ?>
    </div>
    <div class="col-sm-10">
        <?php include $config->paths->content."vend-information/vend-info-top.php"; ?>
        <div class="row">
            <div class="col-sm-6">
                <h3>Shipfrom <?= $vendor->shipfrom; ?> <a href="<?= $vendor->generate_viurl(false); ?>" class="btn btn-warning">View without Shipfrom</a></h3>
                
                <table class="table table-striped table-bordered table-condensed table-excel">
                    <?php $topcolumns = array_keys($shipfromjson['columns']['top']); ?>
                    <?php foreach ($topcolumns as $column ) : ?>
                        <?php if ($shipfromjson['columns']['top'][$column]['heading'] == '' && $shipfromjson['data']['top'][$column] == '') : ?>
                        <?php else : ?>
                            <tr>
                                <td class="<?= $config->textjustify[$shipfromjson['columns']['left'][$column]['headingjustify']]; ?>">
                                    <?php echo $shipfromjson['columns']['top'][$column]['heading']; ?>
                                </td>
                                <td>
                                    <?php
                                        echo $shipfromjson['data']['top'][$column];
                                    ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </table>
                <table class="table table-striped table-bordered table-condensed table-excel">
                    <?php $leftcolumns = array_keys($shipfromjson['columns']['left']); ?>
                    <?php foreach ($leftcolumns as $column) : ?>
                        <?php if ($shipfromjson['columns']['left'][$column]['heading'] == '' && $shipfromjson['data']['left'][$column] == '') : ?>
                        <?php else : ?>
                            <tr>
                                <td class="<?= $config->textjustify[$shipfromjson['columns']['left'][$column]['headingjustify']]; ?>">
                                    <?php echo $shipfromjson['columns']['left'][$column]['heading']; ?>
                                </td>
                                <td>
                                    <?php echo $shipfromjson['data']['left'][$column]; ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </table>
            </div>
            <div class="col-sm-6">
                <table class="table table-striped table-bordered table-condensed table-excel">
                    <?php $rightsection = array_keys($shipfromjson['columns']['right']); ?>
                    <?php foreach ($rightsection as $section) : ?>
                        <?php if ($section != 'misc') : ?>
                            <tr>
                                <?php foreach ($shipfromjson['columns']['right'][$section] as $column) : ?>
                                    <th class="<?= $config->textjustify[$column['headingjustify']]; ?>">
                                        <?php echo $column['heading']; ?>
                                    </th>
                                <?php endforeach; ?>
                            </tr>

                            <?php $rows = array_keys($shipfromjson['data']['right'][$section] ); ?>
                            <?php foreach ($rows as $row) : ?>
                                <tr>
                                    <?php $columns = array_keys($shipfromjson['data']['right'][$section][$row]); ?>
                                    <?php foreach ($columns as $column) : ?>
                                        <td class="<?= $config->textjustify[$shipfromjson['columns']['right'][$section][$column]['datajustify']]; ?>">
                                            <?php echo $shipfromjson['data']['right'][$section][$row][$column]; ?>
                                        </td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                            <tr class="last-section-row"> <td>&nbsp;</td> <td>&nbsp;</td> <td>&nbsp;</td> </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    
                    <?php $misccolumns = array_keys($shipfromjson['data']['right']['misc']); ?>
                    <?php foreach ($misccolumns as $misc) : ?>
                        <?php if ($misc != 'rfml') : ?>
                            <tr>
                                <td class="<?= $config->textjustify[$shipfromjson['columns']['right']['misc'][$misc]['headingjustify']]; ?>">
                                    <?php echo $shipfromjson['columns']['right']['misc'][$misc]['heading']; ?>
                                </td>
                                <td class="<?= $config->textjustify[$shipfromjson['columns']['right']['misc'][$misc]['datajustify']]; ?>">
                                    <?php echo $shipfromjson['data']['right']['misc'][$misc]; ?>
                                </td>
                                <td></td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>

    </div>
</div>
