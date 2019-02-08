<?php
	use Dplus\Warehouse\Binr;
	$binr = new Binr();
?>
<div class="form-group">
	<a href="<?= $config->pages->binr; ?>" class="btn btn-primary not-round">
		<i class="fa fa-arrow-left" aria-hidden="true"></i> Back to Search
	</a>
</div>
<div class="list-group">
	<?php if ($resultscount) : ?>
		<?php foreach ($items as $item) : ?>
			<div class="list-group-item">
				<div class="row">
					<div class="col-xs-12">
						<h4 class="list-group-item-heading">ITEMID: <?= $item->itemid; ?></h4>
						<p class="list-group-item-text"><?= $item->desc1; ?></p>
						
						<?php if ($item->is_serialized() || $item->is_lotted()) : ?>
							<p class="list-group-item-text bg-info"><strong>Bin:</strong> (MULTIPLE) <strong>Qty:</strong> <?= InventorySearchItem::get_total_qty_itemid(session_id(), $item->itemid); ?></p>
							<p></p>
							<button class="btn btn-primary btn-sm" data-toggle="collapse" href="#<?= $item->itemid; ?>-lotserial" aria-expanded="false" aria-controls="<?= $item->itemid; ?>-lotserial">
								Show / Hide <?= strtoupper($item->get_itemtypepropertydesc()) . "S"; ?>
							</button>
							<div id="<?= $item->itemid; ?>-lotserial" class="collapse">
								<div class="list-group">
									<?php $lotserials = InventorySearchItem::get_all_items_lotserial(session_id(), $item->itemid); ?>
									<?php foreach ($lotserials as $lotserial) : ?>
										<a href="<?= $binr->get_item_binsURL($item); ?>" class="list-group-item binr-inventory-result" data-desc="<?= $item->get_itemtypepropertydesc(); ?>" data-item="<?= $item->get_itemidentifier(); ?>" data-qty="<?= $item->qty; ?>">
											<div class="row">
												<div class="col-xs-12">
													<h4 class="list-group-item-heading"><?= strtoupper($lotserial->get_itemtypepropertydesc()) . " " . $lotserial->get_itemidentifier(); ?></h4>
													<p class="list-group-item-text bg-info"><strong>Bin:</strong> <?= $lotserial->bin; ?> <strong>Qty:</strong> <?= $lotserial->qty; ?></p>
												</div>
											</div>
										</a>
									<?php endforeach; ?>
								</div>
							</div>
						<?php else : ?>
							<p class="list-group-item-text bg-info"><strong>Bin:</strong> <?= $item->bin; ?> <strong>Qty:</strong> <?= $item->qty; ?></p>
						<?php endif; ?>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	<?php else : ?>
		<a href="#" class="list-group-item">
			<div class="row">
				<div class="col-xs-12">
					<h3 class="list-group-item-heading">No items found for "<?= $input->get->text('scan'); ?>"</h3>
					<p class="list-group-item-text"></p>
				</div>
			</div>
		</a>
	<?php endif; ?>
</div>
