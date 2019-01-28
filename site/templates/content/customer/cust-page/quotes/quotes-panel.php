<?php
	use Dplus\Dpluso\OrderDisplays\CustomerQuotePanel;
	use Dplus\Content\Paginator;

	$quotepanel = new CustomerQuotePanel(session_id(), $page->fullURL, '#ajax-modal', "#quotes-panel", $config->ajax);
	$quotepanel->set_customer($custID, $shipID);
	$quotepanel->set('pagenbr', $input->pageNum);
	$quotepanel->set('activeID', !empty($input->get->qnbr) ? $input->get->text('qnbr') : false);
	$quotepanel->generate_filter($input);
	$quotepanel->get_quotecount();

	if ($session->panelorigin == 'quotes' && $session->panelcustomer == $quotepanel->custID) {
		$url = new Purl\Url($session->paneloriginpage);
		// $quotepanel->set('pagenbr', Paginator::generate_pagenbr($url));
		$session->remove('panelorigin');
	}

	$paginator = new Paginator($quotepanel->pagenbr, $quotepanel->count, $quotepanel->pageurl->getUrl(), $quotepanel->paginationinsertafter, $quotepanel->ajaxdata);
?>
<div class="panel panel-primary not-round" id="quotes-panel">
	<div class="panel-heading not-round" id="quotes-panel-heading">
		<?php if ($input->get->filter) : ?>
			<a href="#quotes-div" data-parent="#quotes-panel" data-toggle="collapse">
				<?= $quotepanel->generate_filterdescription(); ?> <span class="caret"></span>
			</a>
			<span class="badge pull-right"><?= $quotepanel->count; ?></span>
			<a href="<?= $quotepanel->generate_loadurl(); ?>" class="generate-load-link" data-loadinto="<?= $quotepanel->loadinto; ?>" data-focus="<?= $quotepanel->focus; ?>">
				<i class="fa fa-refresh" aria-hidden="true"></i> Refresh Quotes
			</a>
		<?php elseif ($quotepanel->count > 0) : ?>
			<a href="#quotes-div" data-parent="#quotes-panel" data-toggle="collapse">
				Customer Quotes <span class="caret"></span>
			</a>
			<span class="badge pull-right"><?= $quotepanel->count; ?></span>
			<a href="<?= $quotepanel->generate_loadurl(); ?>" class="generate-load-link" data-loadinto="<?= $quotepanel->loadinto; ?>" data-focus="<?= $quotepanel->focus; ?>">
				<i class="fa fa-refresh" aria-hidden="true"></i> Refresh Quotes
			</a>
		<?php else : ?>
			<a href="<?= $quotepanel->generate_loadurl(); ?>" class="generate-load-link" data-loadinto="<?= $quotepanel->loadinto; ?>" data-focus="<?= $quotepanel->focus; ?>">
				Load Quotes
			</a>
		<?php endif; ?>
		&nbsp; &nbsp;
		<?= $quotepanel->generate_lastloadeddescription(); ?>
		<span class="pull-right"><?= $quotepanel->generate_pagenumberdescription(); ?> &nbsp; </span>
	</div>
	<div id="quotes-div" class="<?= $quotepanel->collapse; ?>">
		<div class="panel-body">
			<div class="row">
				<div class="col-sm-6">
					<?= $paginator->generate_showonpage(); ?>
				</div>
				<div class="col-sm-6">
					<button class="btn btn-primary toggle-order-search pull-right" type="button" data-toggle="collapse" data-target="#cust-quotes-search-div" aria-expanded="false" aria-controls="orders-search-div">Toggle Search <i class="fa fa-search" aria-hidden="true"></i></button>
				</div>
			</div>
			<div id="cust-quotes-search-div" class="<?= (empty($orderpanel->filters) || empty($input->get->filter)) ? 'collapse' : ''; ?>">
				<?php include $config->paths->content.'customer/cust-page/quotes/search-form.php'; ?>
			</div>
		</div>
		<div class="table-responsive">
			<?php
				if ($modules->isInstalled('CaseQtyBottle')) {
					include $config->paths->siteModules.'CaseQtyBottle/content/customer/quotes/table.php';
				} else {
					include $config->paths->content.'customer/cust-page/quotes/table.php';
				}
				echo $paginator;
			?>
		</div>
	</div>
</div>
