<?php
    $activetab = 'quotehead';
    
    if ($input->get->show) { $activetab = $input->get->text('show'); }
    $tabs = array(
        'quotehead' => array('href' => 'quotehead', "id" => 'quotehead-link', 'text' => 'Quote Header', 'tabcontent' => $config->paths->content.'edit/quotes/quotehead-form.php'),
        'details' => array('href' => 'details', "id" => 'quotedetail-link', 'text' => 'Quote Details', 'tabcontent' => $config->paths->content.'edit/quotes/quote-details/details-page.php'),
        //'documents' => array('href' => 'documents', "id" => 'documents-link', 'text' => 'View Documents', 'tabcontent' => 'edit/quotes/documents-page.php'),
        'actions' => array('href' => 'actions', "id" => 'actions-link', 'text' => 'Actions', 'tabcontent' => $config->paths->content.'edit/quotes/actions-page.php')
    );

    if ($modules->isInstalled('CaseQtyBottle')) {
        $tabs['details']['tabcontent'] = $config->paths->siteModules.'CaseQtyBottle/content/edit/quote/details/details-page.php';
    }
?>
<?php if (!$quote->can_edit()) : ?>
   <div class="row">
       <div class="col-xs-12"><?php include $config->paths->content.'edit/quotes/read-only-msg.php'; ?></div>
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
<div id="quote-tabs" class="tab-content">
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
<?php if ($session->editdetail && !$config->ajax) : ?>
    <script>
        $(function() {
            $('#quotedetail-link').click();
        })
    </script>
    <?php $session->remove('editdetail'); ?>
<?php endif; ?>
