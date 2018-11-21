<div class="row">
	<div class="col-xs-12">
		<h2>Access Denied</h2>
		<p>Customer: <?= Customer::get_customernamefromid($custID)." (".$custID.")"; ?></p>
		<?php if ($shipID != '') : ?>
			<p>Ship-to: <?= Customer::get_customernamefromid($custID, $shipID, false)." (".$shipID.")"; ?></p>
		<?php endif; ?>
		<a href="<?= $config->pages->customer; ?>" class="btn btn-primary">Return to Index</a>
	</div>
</div>
