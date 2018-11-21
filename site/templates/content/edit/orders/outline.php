<?php
    $activetab = (empty($input->get->show)) ? 'orderhead' : $input->get->text('show');
    $tabs = array(
        'orderhead' => array('href' => 'orderhead', "id" => 'orderhead-link', 'text' => 'Sales Order Header', 'tabcontent' => $config->paths->content.'edit/orders/orderhead-form.php'),
        'details' => array('href' => 'details', "id" => 'salesdetail-link', 'text' => 'Sales Order Details', 'tabcontent' => $config->paths->content.'edit/orders/order-details/details-page.php'),
        'documents' => array('href' => 'documents', "id" => 'documents-link', 'text' => 'View Documents', 'tabcontent' => $config->paths->content.'edit/orders/documents-page.php'),
        'tracking' => array('href' => 'tracking', "id" => 'tracking-tab-link', 'text' => 'View Tracking', 'tabcontent' => $config->paths->content.'edit/orders/tracking-page.php'),
        'actions' => array('href' => 'actions', "id" => 'actions-tab-link', 'text' => 'View Actions', 'tabcontent' => $config->paths->content.'edit/orders/actions-page.php')
    );

    if (!$editorderdisplay->canedit) {
        echo $editorderdisplay->generate_readonlyalert();
    }

    if (!empty($order->errormsg)) {
        echo $editorderdisplay->generate_erroralert($order);
    }

    if ($modules->isInstalled('QtyPerCase')) {
        $tabs['details']['tabcontent'] = $config->paths->siteModules.'QtyPerCase/content/edit/sales-order/details/details-page.php';
    }
?>

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
