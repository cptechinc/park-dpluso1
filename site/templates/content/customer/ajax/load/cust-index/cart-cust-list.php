<?php
    $pageurl = $page->fullURL;
    $pageurl->path = ($input->get->q) ? $pageurl->path : $config->pages->ajaxload."customers/cust-index/";
    $pageurl->query->set('function', 'cart');
    $custindex = new Dplus\Dpluso\Customer\CustomerIndex($pageurl, '#cust-index-search-form', '#cust-index-search-form');
    $custindex->set_pagenbr($input->pageNum);
    $resultscount = $custindex->count_searchcustindex($input->get->text('q'));
    $paginator = new Dplus\Content\Paginator($custindex->pagenbr, $resultscount, $custindex->pageurl, 'cust-index', $custindex->ajaxdata);
?>

<div id="cust-results">
    <table id="cust-index" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th width="100">CustID</th> <th>Customer Name</th> <th>Ship-To</th> <th>Location</th><th width="100">Phone</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($resultscount > 0) : ?>
                <?php $customers = $custindex->search_custindexpaged($input->get->text('q'), $input->pageNum); ?>
                <?php foreach ($customers as $cust) : ?>
                    <tr>
                        <td>
                            <a href="<?= $cust->generate_setcartcustomerurl(); ?>">
                                <?= $page->bootstrap->highlight($cust->custid, $input->get->text('q'));?>
                            </a> &nbsp; <span class="glyphicon glyphicon-share"></span>
                        </td>
                        <td><?= $page->bootstrap->highlight($cust->name, $input->get->q); ?></td>
                        <td><?= $page->bootstrap->highlight($cust->shiptoid, $input->get->q); ?></td>
                        <td><?= $page->bootstrap->highlight($cust->generate_address(), $input->get->q); ?></td>
                        <td><a href="tel:<?= $cust->phone; ?>" title="Click To Call"><?= $page->bootstrap->highlight($cust->phone, $input->get->q); ?></a></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <td colspan="5">
                    <h4 class="list-group-item-heading">No Customer Matches your query.</h4>
                </td>
            <?php endif; ?>
        </tbody>
    </table>
    <?= $resultscount ? $paginator : ''; ?>
</div>
