<?php
    $q = $input->get->text('q');
    $items = get_itemsearchresults(session_id(), $config->showonpage, $input->pageNum());
    $itemcount = count_itemsearchresults(session_id());
    $paginator = new Dplus\Content\Paginator($input->pageNum, $itemcount, $page->fullURL, 'quick-entry-search', 'data-loadinto=".results" data-focus=".results"');
?>
<div class="qe-results">
    <h3>Item Results for "<?= $q; ?>"</h3>

    <?php if (!$itemcount) : ?>
        <p>No items found.</p>
    <?php else : ?>
        <table class="table table-striped table-excel">
            <thead>
                <th class="col-md-6">Item / Description</th> <th class="col-md-4">Unit of Measure</th> <th class="col-md-2">Price</th>
            </thead>
            <tbody>
                <?php foreach ($items as $item) : ?>
                    <tr class="qe-results-row">
                        <td class="col-md-6">
                            <a href="#" class="qe-item-results" data-itemid="<?= $item->itemID; ?>"><?= $item->itemID; ?></a></br>
                            <small><?= $item->name1; ?></small></br>
                            <small><?= $item->name2; ?></small>
                        </td>
                        <td class="col-md-4"><?= $item->unit; ?></td>
                        <td class="col-md-2"><?= $item->price; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
