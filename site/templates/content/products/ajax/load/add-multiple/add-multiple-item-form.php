<form action="<?= $formaction; ?>" method="post" id="add-multiple-item-form" data-checked="false" data-invaliditems="0">
    <input type="hidden" name="action" value="add-multiple-items">
    <input type="hidden" name="custID" value="<?= $custID; ?>">
    <input type="hidden" name="ordn" value="<?= $ordn; ?>">
    <input type="hidden" name="qnbr" value="<?= $qnbr; ?>">
    <div class="response"></div>
    <div class="row">
        <div class="col-sm-8">
            <div class="duplicable-item-list">
        		<div class="row duplicable-item">
        			<div class="col-sm-9 form-group">
        				<label for="">Item ID</label>
        				<input type="text" name="itemID[]" class="form-control input-sm itemid">
        			</div>
        			<div class="col-sm-3 form-group">
        				<label for="">Qty</label>
        				<input type="text" name="qty[]" class="form-control input-sm qty">
        			</div>
        		</div>
        	</div>
        	<button type="button" class="btn btn-primary" onclick="duplicateitem('.duplicable-item-list')">
        		<i class="fa fa-plus" aria-hidden="true"></i> Add Another Item
        	</button>
            <div class="form-group"></div>
            <button type="submit" class="btn btn-success">
                <i class="fa fa-shopping-basket" aria-hidden="true"></i> Submit Items
            </button>
        </div>
    </div>
</form>
