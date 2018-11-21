<form action="<?php echo $config->pages->ajax."load/vi/item-search-results/"; ?>" method="get" id="vi-search-item">
	<input type="text" class="form-control vi-item-search" name="q" autocomplete="off">
	<input type="hidden" name="action" value="<?= $action; ?>">
	<input type="hidden" name="vendorID" class="vendorid" value="<?php echo $vendorID; ?>">
	<div>
		<?php include $config->paths->content."vend-information/item-search-results.php"; ?>
	</div>
</form>
