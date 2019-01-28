<form action="<?= $config->pages->ajax."load/ii/search-results/"; ?>" method="get" id="ii-search-item">
	<input type="text" class="form-control ii-item-search" name="q" placeholder="Type Item ID" autocomplete="off" value="<?= $q; ?>">
	<input type="hidden" name="custID" class="custID" value="<?= $custID; ?>" >
</form>
<div class="form-group">
	
</div>
<div>
	<?php include $config->paths->content.'item-information/item-search-results.php'; ?>
</div>
