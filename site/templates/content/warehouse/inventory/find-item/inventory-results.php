<?php
	/**
	 * Find Item Results
	 * 1. List Out all the distinct items found
	 * 2. If item is Lotted Or Serialized DON'T list bin ID, but show total quantity,
	 *   1. Do a show / hide for theses individual items.
	 */

	if ($input->get->scan) {
		$title = "$resultscount Item";
		$title .= ($resultscount == 1 ) ? '' : 's';
	}
?>
<div class="form-group">
	<?php include __DIR__."/item-form.php"; ?>
</div>

<?php if ($input->get->scan) : ?>
	<h3><?= $title; ?></h3>
	<div class="list-group">
		<?php if ($resultscount) : ?>
			<?php foreach ($items as $item) : ?>
				<div class="list-group-item">
					<div class="row">
						<div class="col-xs-12">
							<h4 class="list-group-item-heading">ITEMID: <?= $item->itemid; ?></h4>
							<p class="list-group-item-text"><?= $item->desc1; ?></p>

							<?php if ($item->is_serialized() || $item->is_lotted()) : ?>
								<p class="list-group-item-text bg-light"><strong>Bin:</strong> (MULTIPLE) <strong>Qty:</strong> <?= InventorySearchItem::get_total_qty_itemid(session_id(), $item->itemid); ?></p>
								<p></p>
								<button class="btn btn-primary btn-sm" data-toggle="collapse" href="#<?= $item->itemid; ?>-lotserial" aria-expanded="false" aria-controls="<?= $item->itemid; ?>-lotserial">
									Show / Hide <?= strtoupper($item->get_itemtypepropertydesc()) . "S"; ?>
								</button>
								<div id="<?= $item->itemid; ?>-lotserial" class="collapse">
									<div class="list-group">
										<?php $lotserials = InventorySearchItem::get_all_items_lotserial(session_id(), $item->itemid); ?>
										<?php foreach ($lotserials as $lotserial) : ?>
											<div class="list-group-item">
												<div class="row">
													<div class="col-xs-12">
														<h4 class="list-group-item-heading"><?= strtoupper($lotserial->get_itemtypepropertydesc()) . ": " . $lotserial->get_itemidentifier(); ?></h4>
														<p class="list-group-item-text bg-light"><strong>Bin:</strong> <?= $lotserial->bin; ?> <strong>Qty:</strong> <?= $lotserial->qty; ?></p>
														<?php if (!$whseconfig->validate_bin($lotserial->bin)) : ?>
															<p class="list-group-item-text"><span class="label label-danger">Invalid Bin</span></p>
														<?php endif; ?>
													</div>
												</div>
											</div>
										<?php endforeach; ?>
									</div>
								</div>
							<?php else : ?>
								<p class="list-group-item-text bg-light"><strong>Bin:</strong> <?= $item->bin; ?> <strong>Qty:</strong> <?= $item->qty; ?></p>
								<?php if (!$whseconfig->validate_bin($item->bin)) : ?>
									<p class="list-group-item-text"><span class="label label-danger">Invalid Bin</span></p>
								<?php endif; ?>
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
<?php endif; ?>
