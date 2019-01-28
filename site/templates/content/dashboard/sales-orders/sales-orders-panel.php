<?php
	use Dplus\Dpluso\OrderDisplays\SalesOrderPanel;
	use Dplus\Content\Paginator;

	$orderpanel = new SalesOrderPanel(session_id(), $page->fullURL, '#ajax-modal', '#orders-panel', $config->ajax);
	$orderpanel->set('pagenbr', $input->pageNum);
	$orderpanel->set('activeID', !empty($input->get->ordn) ? $input->get->text('ordn') : false);
	$orderpanel->generate_filter($input);
	$orderpanel->get_ordercount();


	if ($session->panelorigin == 'orders' && !$session->panelcustomer) {
		$url = new Purl\Url($session->paneloriginpage);
		$orderpanel->set('pagenbr', Paginator::generate_pagenbr($url));
		$session->remove('panelorigin');
	}

	$paginator = new Paginator($orderpanel->pagenbr, $orderpanel->count, $orderpanel->pageurl->getUrl(), $orderpanel->paginationinsertafter, $orderpanel->ajaxdata);
?>
<div class="panel panel-primary not-round" id="orders-panel">
	<div class="panel-heading not-round" id="order-panel-heading">
		<?php if (!empty($orderpanel->filters)) : ?>
			<a href="#orders-div" data-parent="#orders-panel" data-toggle="collapse">
				Sales Orders <?= $orderpanel->generate_filterdescription(); ?> <span class="caret"></span>
			</a>
			<span class="badge pull-right"><?= $orderpanel->count; ?></span>
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
		<br>
		<div class="panel-body">
			<div class="row">
				<div class="col-sm-6">
					<?= $paginator->generate_showonpage(); ?>
				</div>
				<div class="col-sm-6">
					<button class="btn btn-primary toggle-order-search pull-right" type="button" data-toggle="collapse" data-target="#orders-search-div" aria-expanded="false" aria-controls="orders-search-div">Toggle Search <i class="fa fa-search" aria-hidden="true"></i></button>
				</div>
			</div>
			<div id="orders-search-div" class="<?= (empty($orderpanel->filters) || empty($input->get->filter)) ? 'collapse' : ''; ?>">
				<?php include $config->paths->content.'dashboard/sales-orders/search-form.php'; ?>
			</div>
		</div>
		<div class="table-responsive">
			<?php
				if ($modules->isInstalled('CaseQtyBottle')) {
					include $config->paths->siteModules.'CaseQtyBottle/content/dashboard/sales-orders/table.php';
				} else {
					include $config->paths->content.'dashboard/sales-orders/table.php';
				}
				echo $paginator;
			?>
		</div>
	</div>
</div>
