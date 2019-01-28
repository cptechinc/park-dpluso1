<?php
    $activetab = (empty($input->get->show)) ? 'orderhead' : $input->get->text('show');
    $tabs = array(
        'orderhead' => array('href' => 'orderhead', "id" => 'orderhead-link', 'text' => 'Sales Order Header', 'tabcontent' => $config->paths->content.'edit/orders/orderhead-form.php'),
        'details' => array('href' => 'details', "id" => 'salesdetail-link', 'text' => 'Sales Order Details', 'tabcontent' => $config->paths->content.'edit/orders/order-details/details-page.php'),
        'documents' => array('href' => 'documents', "id" => 'documents-link', 'text' => 'View Documents', 'tabcontent' => $config->paths->content.'edit/orders/documents-page.php'),
        'tracking' => array('href' => 'tracking', "id" => 'tracking-tab-link', 'text' => 'View Tracking', 'tabcontent' => $config->paths->content.'edit/orders/tracking-page.php'),
        'actions' => array('href' => 'actions', "id" => 'actions-tab-link', 'text' => 'View Actions', 'tabcontent' => $config->paths->content.'edit/orders/actions-page.php')
    );
    
    if ($modules->isInstalled('CaseQtyBottle')) {
        $tabs['details']['tabcontent'] = $config->paths->siteModules.'CaseQtyBottle/content/edit/sales-order/details/details-page.php';
    }
?>

<?php if (!$order->can_edit()) : ?>
    <div class="alert alert-danger" role="alert">
        <b>Attention!</b> 
        This order will open in read-only mode, you will not be able to save changes.
    </div>
<?php endif; ?>

<?php if (!empty($order->errormsg)) : ?>
    <div class="alert alert-danger" role="alert">
        <b>Error!</b> 
        <?= $order->errormsg; ?>
    </div>
<?php endif; ?>

<ul id="order-tab" class="nav nav-tabs nav_tabs">
    <?php foreach ($tabs as $tab) : ?>
        <?php if ($tab == $tabs[$activetab]) : ?>
            <li class="active"><a href="<?= '#'.$tab['href']; ?>" id="<?=$tab['id']; ?>" data-toggle="tab"><?=$tab['text']; ?></a></li>
        <?php else : ?>
            <li><a href="<?= '#'.$tab['href']; ?>" id="<?=$tab['id']; ?>" data-toggle="tab"><?=$tab['text']; ?></a></li>
        <?php endif; ?>
    <?php endforeach; ?>
</ul>

<div id="order-tabs" class="tab-content">
    <?php foreach ($tabs as $tab) : ?>
        <?php if ($tab == $tabs[$activetab]) : ?>
            <div class="tab-pane fade in active" id="<?= $tab['href']; ?>">
                <br>
                <?php include $tab['tabcontent']; ?>
            </div>
        <?php else : ?>
            <div class="tab-pane fade" id="<?= $tab['href']; ?>">
                <br>
                <?php include $tab['tabcontent']; ?>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>

<?php if ($session->editdetail) : ?>
    <script>
        $(function() {
            $('#salesdetail-link').click();
        })
    </script>
    <?php $session->remove('editdetail'); ?>
<?php endif; ?>
