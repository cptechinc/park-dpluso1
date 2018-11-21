<?php
    $vendjson = json_decode(file_get_contents($config->jsonfilepath.session_id()."-vivendor.json"), true);
// $vendjson = json_decode(file_get_contents($config->jsonfilepath."vitest-vivendor.json"), true);
?>

<div class="row">
    <div class="col-sm-6">
        <table class="table table-striped table-bordered table-condensed table-excel">
        <?php $topcolumns = array_keys($vendjson['columns']['top']); ?>
        <?php foreach ($topcolumns as $column ) : ?>
            <?php if ($vendjson['columns']['top'][$column]['heading'] == '' && $vendjson['data']['top'][$column] == '') : ?>
            <?php else : ?>
                <tr>
                    <td class="<?= $config->textjustify[$vendjson['columns']['left'][$column]['headingjustify']]; ?>">
                        <?php echo $vendjson['columns']['top'][$column]['heading']; ?>
                    </td>
                    <td>
                        <?php
                            if ($column == 'vendorid') {
                                include $config->paths->content."vend-information/forms/vend-page-form.php";
                            } else {
                                echo $vendjson['data']['top'][$column];
                            }
                        ?>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
        </table>
    </div>
</div>
