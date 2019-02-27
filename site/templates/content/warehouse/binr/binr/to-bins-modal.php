<?php
	$bins = ItemBinInfo::find_by_item(session_id(), $item);
	$currentbins = array();

	foreach ($bins as $bin) {
		$currentbins[$bin->bin] = $bin->qty;
	}
?>
<div class="modal fade" id="choose-to-bins-modal" tabindex="-1" role="dialog" aria-labelledby="choose-to-bins-modal-label">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="choose-to-bins-modal-label">Choose To bin for <?= strtoupper($item->get_itemtypepropertydesc()) . ': '. $item->get_itemidentifier(); ?></h4>
			</div>
			<div class="modal-body">
				<div>
					<div class="form-group">
						<ul class="nav nav-tabs" role="tablist">
							<li role="presentation" class="active"><a href="#current" aria-controls="current" role="tab" data-toggle="tab">Current Bins</a></li>
							<li role="presentation"><a href="#all-bins" aria-controls="all-bins" role="tab" data-toggle="tab">All Bins</a></li>
						</ul>
					</div>
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="current">
							<h4>Bins That Contain <?= strtoupper($item->get_itemtypepropertydesc()) . ': '. $item->get_itemidentifier(); ?> </h4>
							<div class="list-group">
								<?php foreach ($currentbins as $currentbin => $qty) : ?>
									<a href="#" class="list-group-item choose-tobin" data-bin="<?= $currentbin; ?>">
										<div class="row">
											<div class="col-xs-6">
												<h5 class="list-group-item-heading"><?= $currentbin; ?></h5>
											</div>
											<div class="col-xs-6">
												<h5 class="list-group-item-heading">Qty: <?= $qty; ?></h5>
											</div>
										</div>
										<?php if (!$whseconfig->validate_bin($currentbin)) : ?>
											<p class="list-group-item-text"><span class="label label-danger">Invalid Bin</span></p>
										<?php endif; ?>
									</a>
								<?php endforeach; ?>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane" id="all-bins">
							<h4>All Bins</h4>
							<?php if ($whseconfig->are_binslisted()) : ?>
								<div class="list-group">
									<?php $list = $whseconfig->get_binlist(); ?>
									<?php foreach ($list as $listedbin) : ?>
										<a href="#" class="list-group-item choose-tobin" data-bin="<?= $currentbin; ?>">
											<div class="row">
												<div class="col-xs-6">
													<h5 class="list-group-item-heading"><?= $listedbin->from; ?></h5>
												</div>
												<div class="col-xs-6">
													<?php if (array_key_exists($listedbin->from, $currentbins)) : ?>
														<h5 class="list-group-item-heading">Qty: <?= $currentbins[$listedbin->from]; ?></h5>
													<?php endif; ?>
												</div>
											</div>
											<p class="list-group-item-text"><?= $listedbin->bindesc;; ?></p>
										</a>
									<?php endforeach; ?>
								</div>
							<?php else : ?>
								<?php $binranges = $whseconfig->get_binranges(); ?>
								<table class="table table-condensed table-striped table-bordered">
									<tr>
										<th>Range From</th>
										<th>Range Through</th>
									</tr>
									<?php foreach ($binranges as $binrange) : ?>
										<tr>
											<td><?= $binrange->from; ?></td>
											<td><?= $binrange->through; ?></td>
										</tr>
									<?php endforeach; ?>
								</table>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
