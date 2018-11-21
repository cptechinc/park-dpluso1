<?php
	$custindex = new Dplus\Dpluso\Customer\CustomerIndex($page->fullURL, $loadinto, $focus);
	$contactscount = $custindex->count_distinctcustindex();
	
	if ($input->get->q) {
		$searchcount = $custindex->count_searchcustindex($input->get->text('q'));
	}
?>

<div class="row form-group">
	<div class="col-xs-12">
		<a href="<?php echo $config->pages->customer.'add/'; ?>" class="btn btn-primary"><i class="fa fa-user-plus" aria-hidden="true"></i> Add new Customer</a>
	</div>
</div>

<div class="panel panel-primary not-round">
    <div class="panel-heading not-round">
    	<?php if (isset($input->get->q)) : ?>
            <h3 class="panel-title">Customer Contacts (<?= number_format($searchcount); ?> matches out of <?= $contactscount; ?> Customers)</h3>
        <?php else : ?>
            <h3 class="panel-title">Customers (<?= number_format($contactscount); ?>)</h3>
        <?php endif; ?>
    </div>
    <div class="panel-body">
    	<div class="row">
    		<div class="col-sm-3">
            	<?php include $config->paths->content.'pagination/pw/pagination-start.php'; ?>
            </div>
           	<div class="col-sm-7">
            	<?php include $config->paths->content.'customer/cust-index/customer-index-form.php'; ?>
            </div>
            <div class="col-xs-2">
            	<?php if (isset($input->get->q)) : ?>
            		<a href="<?= $config->pages->customer; ?>" class="btn btn-warning">Clear Search</a>
                <?php endif; ?>
            </div>
    	</div>
    </div>
    <?php include $config->paths->content.'customer/cust-index/customer-index-table.php'; ?>
</div>
