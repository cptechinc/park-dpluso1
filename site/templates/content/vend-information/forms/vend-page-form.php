<form action="<?php echo $config->pages->ajax."load/vendors/vend-index/"; ?>" method="POST" id="vi-vend-lookup" class="allow-enterkey-submit">
    <input type="hidden" name="action" value="vi-item-lookup">
    <input type="hidden" class="shipfromID" name="shipfromID" value="<?= $shipfromID; ?>">
    <div class="form-group">
        <div class="input-group custom-search-form">
            <input type="text" class="form-control input-sm not-round vendorID" name="vendorID" placeholder="Search vendorID" value="<?= $vendorID; ?>">
            <span class="input-group-btn">
            	<button type="submit" class="btn btn-sm btn-default not-round"> <span class="glyphicon glyphicon-search"></span> </button>
            </span>
        </div>
    </div>
</form>
