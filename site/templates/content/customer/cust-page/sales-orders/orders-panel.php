<?php
	use Dplus\Dpluso\OrderDisplays\CustomerSalesOrderPanel;
	use Dplus\Content\Paginator;

	$orderpanel = new CustomerSalesOrderPanel(session_id(), $page->fullURL, '#ajax-modal', '#orders-panel', $config->ajax);
	$orderpanel->set_customer($custID, $shipID);
	$orderpanel->set('pagenbr', $input->pageNum);
	$orderpanel->set('activeID', !empty($input->get->ordn) ? $input->get->text('ordn') : false);
	$orderpanel->generate_filter($input);
	$orderpanel->get_ordercount();

	if ($session->panelorigin == 'orders' && $session->panelcustomer == $orderpanel->custID) {
		$url = new Purl\Url($session->paneloriginpage);
		$orderpanel->set('pagenbr', Paginator::generate_pagenbr($url));
		$session->remove('panelorigin');
	}

	$paginator = new Paginator($orderpanel->pagenbr, $orderpanel->count, $orderpanel->pageurl->getUrl(), $orderpanel->paginationinsertafter, $orderpanel->ajaxdata);
?>
<div class="panel panel-primary not-round" id="orders-panel">
	<div class="panel-heading not-round" id="orders-panel-heading">
		<?php if ($input->get->filter) : ?>
			<a href="#orders-div" data-parent="#orders-panel" data-toggle="collapse">
				Sales Orders <?= $orderpanel->generate_filterdescription(); ?> <span class="caret"></span>
			</a>
			<span class="badge"><?= $orderpanel->count; ?> &nbsp; </span>
		<?php elseif ($orderpanel->count > 0) : ?>
			<a href="#orders-div" data-parent="#orders-panel" data-toggle="collapse">
				Sales Orders <span class="caret"></span>
			</a>
			<span class="badge pull-right"> <?= $orderpanel->count; ?></span>
		<?php else : ?>
			<a href="#orders-div" data-parent="#orders-panel" data-toggle="collapse">
				Sales Orders <span class="caret"></span>
			</a>
			<span class="badge pull-right"> <?= $orderpanel->count; ?></span>
		<?php endif; ?>
		<span class="pull-right"><?= $orderpanel->generate_pagenumberdescription(); ?> &nbsp; </span>
	</div>
	<div id="orders-div" class="<?= $orderpanel->collapse; ?>">
		<div class="panel-body">
			<div class="row">
				<div class="col-sm-6">
					<?= $paginator->generate_showonpage(); ?>
				</div>
				<div class="col-sm-6">
					<button class="btn btn-primary toggle-order-search pull-right" type="button" data-toggle="collapse" data-target="#cust-orders-search-div" aria-expanded="false" aria-controls="cust-orders-search-div">
						Toggle Search <i class="fa fa-search" aria-hidden="true"></i>
					</button>
				</div>
			</div>
			<div id="cust-orders-search-div" class="<?= (empty($orderpanel->filters) || empty($input->get->filter)) ? 'collapse' : ''; ?>">
				<?php include $config->paths->content.'customer/cust-page/sales-orders/search-form.php'; ?>
			</div>
		</div>
		<div class="table-responsive">
			<?php
				if ($modules->isInstalled('CaseQtyBottle')) {
					include $config->paths->siteModules.'CaseQtyBottle/content/customer/sales-orders/table.php';
				} else {
					include $config->paths->content.'customer/cust-page/sales-orders/table.php';
				}
				echo $paginator;
			?>
		</div>
	</div>
</div>
