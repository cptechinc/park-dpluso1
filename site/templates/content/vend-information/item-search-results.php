<?php
	$vendorID = ($input->get->vendorID) ? $vendorID = $input->get->text('vendorID') : '';
	
	if ($input->get->q) {
		$q = $input->get->text('q');
		$items = search_items($q, $vendorID, $session->display, $input->pageNum); 
		$resultscount = count_searchitems($q, $vendorID);
	}
?>

<div class="list-group" id="item-results">
	<?php if ($input->get->q) : ?>
		<?php if ($resultscount) : ?>
			<?php foreach ($items as $item) : ?>
				<a href="#<?= $item->itemid; ?>" class="list-group-item item-master-result" onclick="<?= $item->generate_vionclick('vi-costing'); ?>">
					<div class="row">
						<div class="col-xs-2"><img src="<?= $item->generate_imagesrc() ; ?>" alt=""></div>
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
	<?php endif; ?>
</div>
