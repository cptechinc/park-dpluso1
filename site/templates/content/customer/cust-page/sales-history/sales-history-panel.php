<?php
	use Dplus\Dpluso\OrderDisplays\CustomerSalesOrderHistoryPanel;
	use Dplus\Content\Paginator;
	
	$orderpanel = new CustomerSalesOrderHistoryPanel(session_id(), $page->fullURL, '#ajax-modal', '#cust-sales-history-panel', $config->ajax);
	$orderpanel->set_customer($customer->custID, $customer->shipID);
	$orderpanel->set('pagenbr', $input->pageNum);
	$orderpanel->set('activeID', !empty($input->get->ordn) ? $input->get->text('ordn') : false);
	$orderpanel->generate_filter($input);
	$orderpanel->get_ordercount();

	$paginator = new Paginator($orderpanel->pagenbr, $orderpanel->count, $orderpanel->pageurl->getUrl(), $orderpanel->paginationinsertafter, $orderpanel->ajaxdata);
?>
<div class="panel panel-primary not-round" id="cust-sales-history-panel">
	<div class="panel-heading not-round" id="cust-sales-history-panel-heading">
		<?php if (!empty($orderpanel->filters)) : ?>
			<a href="#cust-sales-history-div" data-parent="#cust-sales-history-panel" data-toggle="collapse">
				Shipped Orders <?= $orderpanel->generate_filterdescription(); ?> <span class="caret"></span>
			</a>
			<span class="badge pull-right"><?= $orderpanel->count; ?></span>
		<?php elseif ($orderpanel->count > 0) : ?>
			<a href="#cust-sales-history-div" data-parent="#cust-sales-history-panel" data-toggle="collapse">
				Shipped Orders <span class="caret"></span>
			</a> 
			<span class="badge pull-right"> <?= $orderpanel->count; ?></span>
		<?php else : ?>
			<a href="#cust-sales-history-div" data-parent="#cust-sales-history-panel" data-toggle="collapse">
				Shipped Orders Shipped Orders<span class="caret"></span>
			</a> 
			<span class="badge"> <?= $orderpanel->count; ?></span>
		<?php endif; ?>
		<span class="pull-right"><?= $orderpanel->generate_pagenumberdescription(); ?> &nbsp; </span>
	</div>
	 <div id="cust-sales-history-div" class="<?= $orderpanel->collapse; ?>">
		<div class="panel-body">
			<div class="row">
				<div class="col-sm-6">
					<?= $paginator->generate_showonpage(); ?>
				</div>
				<div class="col-sm-6">
					<button class="btn btn-primary toggle-order-search pull-right" type="button" data-toggle="collapse" data-target="#cust-sales-history-search-div" aria-expanded="false" aria-controls="sales-history-search-div">Toggle Search <i class="fa fa-search" aria-hidden="true"></i></button>
				</div>
			</div>
			<div id="cust-sales-history-search-div" class="<?= (empty($orderpanel->filters) || empty($input->get->filter)) ? 'collapse' : ''; ?>">
				<?php
					if ($modules->isInstalled('CaseQtyBottle')) {
						include $config->paths->siteModules.'CaseQtyBottle/content/customer/sales-history/search-form.php';
					} else {
						include $config->paths->content.'customer/cust-page/sales-history/search-form.php';
					}
				?>
			</div>
		</div>
		<div class="table-responsive">
			<?php include $config->paths->content.'customer/cust-page/sales-history/table.php'; ?>
			<?= $paginator; ?>
		</div>
	 </div>
</div>
