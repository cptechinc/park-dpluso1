<?php
	$custID = ($input->get->custID) ? $input->get->text('custID') : '';
	$itemlink = $config->pages->products."redir/?action=ci-pricing";
	$itemlink .=  (!empty($custID)) ? "&custID=".urlencode($custID) : '';
	
	$q = ($input->get->q) ? $input->get->text('q') : '';
	$pageurl = ($input->get->q) ? $page->fullURL->getUrl() : $config->pages->ajaxload."ii/search-results/";
	$paneltitle = ($input->get->q) ? " Searching for '$q'" : 'Items';
	$items = search_items($q, $custID, $session->display, $input->pageNum);
	$resultscount = count_searchitems($q, $custID);
	$insertafter = 'item-search-results';
	$paginator = new Dplus\Content\Paginator($input->pageNum, $resultscount, $pageurl, $insertafter, "data-loadinto='#item-results' data-focus='#item-results'");
	
?>

<div class="list-group" id="item-results">
	<div class="form-group"></div>
	<div class="panel panel-primary">
		<div class="panel-heading">
			<span class="h4">
				<?= $paneltitle; ?> <span class="badge"><?= $resultscount; ?></span>
			</span>
			<span class="pull-right"><?= $input->pageNum > 1 ? 'Page '.$input->pageNum : ''; ?></span>
		</div>
		<div class="list-group">
			<?php if ($resultscount) : ?>
				<?php foreach ($items as $item) : ?>
					<a href="#<?= $item->itemid; ?>" class="list-group-item item-master-result" onclick="<?= $item->generate_cionclick($input->get->text('action')); ?>">
						<div class="row">
							<div class="col-xs-2"><img src="<?= $item->generate_imagesrc(); ?>" alt=""></div>
							<div class="col-xs-10"><h4 class="list-group-item-heading"><?= $item->itemid; ?></h4>
							<p class="list-group-item-text"><?= $item->desc1; ?></p></div>
						</div>
					</a>
				<?php endforeach; ?>
			<?php else : ?>
				<a href="#" class="list-group-item item-master-result">
					<div class="row">
						<div class="col-xs-2"></div>
						<div class="col-xs-10"><h4 class="list-group-item-heading">No Items Match your query.</h4>
						<p class="list-group-item-text"></p></div>
					</div>
				</a>
			<?php endif; ?>
		</div>
	</div>
	<?= $resultscount ? $paginator : ''; ?>
</div>
