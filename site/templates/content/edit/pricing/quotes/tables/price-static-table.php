<table class="table table-bordered table-striped table-condensed">
    <tr> <td>Price </td> <td class="text-right">$ <?= $page->stringerbell->format_money($linedetail->quotprice); ?></td> </tr>
    <tr> <td>Unit of Measurement</td> <td> <?= $linedetail->uom ?></td> </tr>
    <tr> <td>Qty</td> <td><input type="text" class="form-control pull-right input-sm text-right qty" name="qty" value="<?= $linedetail->quotqty+0; ?>"></td> </tr>
    <tr> <td>Original Ext. Amt.</td> <td class="text-right">$ <?= $page->stringerbell->format_money($linedetail->quotprice * $linedetail->quotqty); ?></td> </tr>
    <?php if ($appconfig->child('name=sales-orders')->show_originalprice) : ?>
        <tr> <td>Original Price</td> <td class="text-right">$ <?= $page->stringerbell->format_money($linedetail->quotprice); ?></td> </tr>
    <?php endif; ?>
    <?php if ($appconfig->child('name=sales-orders')->show_listprice) : ?>
        <tr> <td>List Price</td> <td class="text-right">$ <?= $page->stringerbell->format_money($linedetail->listprice); ?></td> </tr>
    <?php endif; ?>
    <?php if ($appconfig->child('name=sales-orders')->show_cost) : ?>
        <tr> <td>Cost</td> <td class="text-right">$ <?= $page->stringerbell->format_money($linedetail->cost); ?></td> </tr>
    <?php endif; ?>
    <tr><td>Kit:</td><td><?php echo $linedetail->kititemflag; ?></td></tr>
</table>
