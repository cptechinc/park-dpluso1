<div class="alert alert-warning alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>Error!</strong> Order # <?= $input->get->text('ordn'); ?> is invalid
</div>
<?php include $config->paths->content."warehouse/picking/choose-sales-order-form.php"; ?>
