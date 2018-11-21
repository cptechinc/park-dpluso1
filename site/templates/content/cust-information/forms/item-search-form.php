<form action="<?php echo $config->pages->ajax."load/ci/item-search-results/"; ?>" method="get" id="ci-search-item">
	<input type="text" class="form-control ci-item-search" name="q" autocomplete="off">
	<input type="hidden" name="action" value="<?= $action; ?>">
	<input type="hidden" name="custID" class="custid" value="<?php echo $custID; ?>">
	<input type="hidden" name="shipID" class="shipid" value="<?php echo $shipID; ?>">
	<div>
		<?php include $config->paths->content."cust-information/item-search-results.php"; ?>
	</div>
</form>
