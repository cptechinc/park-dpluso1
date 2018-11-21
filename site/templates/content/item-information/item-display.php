<?php
	$item = get_itemfrompricing($itemID); 
	$specs = $pricing = $item;
	if (!file_exists($config->imagefiledirectory.$item['image'])) {$item['image'] = 'notavailable.png'; }
?>
<div class="row item-result">
	<div class="col-md-3">
		<a href="#" data-toggle="modal" data-target="#lightbox-modal">
			<img src="<?= $config->imagedirectory.$item['image']; ?>" alt="" data-desc="<?php echo $item['itemid'].' image'; ?>">
		</a>
	</div>
	<div class="col-md-9">
		<h4><?= $item['itemid']; ?></h4> <h5><?= $item['name1']; ?></h5>
		<div class="product-info">
			<ul class="nav nav-tabs nav_tabs">
				<li class="active"><a href="#<?= $item['itemid']; ?>-desc-tab" data-toggle="tab" aria-expanded="true">Description</a></li>
				<li><a href="#<?= $item['itemid']; ?>-specs-tab" data-toggle="tab" aria-expanded="false">Specifications</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane fade active in" id="<?= $item['itemid']; ?>-desc-tab">
					<br><p><?= $item['shortdesc']; ?></p>
				</div>
				<div class="tab-pane fade" id="<?= $item['itemid']; ?>-specs-tab"><br><?php include $config->paths->content."products/product-results/product-features.php"; ?></div>
			</div>
		</div>
	</div>
</div>
