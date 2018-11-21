<?php 
    $orderpanel = new RepSalesOrderPanel(session_id(), $page->fullURL, '#ajax-modal', '#orders-table', $config->ajax);
    $orderpanel->pagenbr = $input->pageNum;
    $orderpanel->activeID = !empty($input->get->ordn) ? $input->get->text('ordn') : false;
    $orderpanel->generate_filter($input);
    $orderpanel->get_ordercount();
    $paginator = new Dplus\Content\Paginator($orderpanel->pagenbr, $orderpanel->count, $orderpanel->pageurl->getUrl(), $orderpanel->paginationinsertafter, $orderpanel->ajaxdata);
    echo var_dump($orderpanel->filters);
    echo $orderpanel->get_ordercount(true);
	echo var_dump($orderpanel->filters['orderdate']);
?>

<div class="row">
    <div class="col-sm-2">
        <form action="<?php echo $page->fullURL->getUrl(); ?>" method="get" data-loadinto="#orders-panel" data-focus="#orders-panel" data-modal="#ajax-modal" class="fuelux">
            <input type="hidden" name="filter" value="filter">
            
            <h4>Order Status :</h4>
            <label for="">New</label>
            <input class="pull-right" type="checkbox" name="status[]" value="New" <?= ($orderpanel->has_filtervalue('status', 'New')) ? 'checked' : ''; ?>></br>
            <label for="">Invoice</label>
            <input class="pull-right" type="checkbox" name="status[]" value="Invoice" <?= ($orderpanel->has_filtervalue('status', 'Invoice')) ? 'checked' : ''; ?>></br>
            <label for="">Pick</label>
            <input class="pull-right" type="checkbox" name="status[]" value="Pick" <?= ($orderpanel->has_filtervalue('status', 'Pick')) ? 'checked' : ''; ?>></br>
            <label for="">Verify</label>
            <input class="pull-right" type="checkbox" name="status[]" value="Verify" <?= ($orderpanel->has_filtervalue('status', 'Verify')) ? 'checked' : ''; ?>>
            
            <h4>Cust PO :</h4>
            <input class="form-control inline input-sm" type="text" name="custpo[]" value="<?= $orderpanel->get_filtervalue('custpo'); ?>" placeholder="Cust PO">
            
            <h4>Cust ID :</h4>
            <input class="form-control form-group inline input-sm" type="text" name="custid[]" value="<?= $orderpanel->get_filtervalue('custid'); ?>" placeholder="From CustID">
            <input class="form-control form-group inline input-sm" type="text" name="custid[]" value="<?= $orderpanel->get_filtervalue('custid', 1); ?>" placeholder="Through CustID">
            
            <h4>Order # :</h4>
            <input class="form-control form-group inline input-sm" type="text" name="orderno[]" value="<?= $orderpanel->get_filtervalue('orderno'); ?>" placeholder="From Order #">
            <input class="form-control form-group inline input-sm" type="text" name="orderno[]" value="<?= $orderpanel->get_filtervalue('orderno', 1); ?>" placeholder="Through Order #">
        
            <h4>Order Date :</h4>
            <label class="control-label">From Date </label>
            <?php $name = 'orderdate[]'; $value = $orderpanel->get_filtervalue('orderdate'); ?>
            <?php include $config->paths->content."common/date-picker.php"; ?>
            <label class="control-label">Through Date </label>
            <?php $name = 'orderdate[]'; $value = $orderpanel->get_filtervalue('orderdate', 1); ?>
            <?php include $config->paths->content."common/date-picker.php"; ?></br>
            
            <div class="form-group">
                <button class="btn btn-success btn-block" type="submit">Search</button>
            </div>
        </form>
    </div>
    <div class="col-sm-10">
		<?php include $config->paths->content.'salesrep/orders/orders-panel.php'; ?>
    </div>
</div>
