<form action="<?= $config->pages->cart.'redir/'; ?>" method="post" class="quick-entry-add allow-enterkey-submit" id="quick-entry-add" data-validated="">
	<input type="hidden" name="action" value="add-to-cart">
	<input type="hidden" name="custID" value="<?= $custID; ?>">
	<div class="row">
		<div class="col-xs-9 sm-padding">
			<div class="col-md-4 form-group sm-padding">
				<span class="detail-line-field-name">Item/Description:</span>
				<span class="detail-line-field numeric">
					<input class="form-control input-xs underlined" type="text" name="itemID" placeholder="Item ID" autofocus>
				</span>
			</div>
			<div class="col-md-1 form-group sm-padding"> </div>
			<div class="col-md-1 form-group sm-padding">
				<span class="detail-line-field-name">Qty:</span>
				<span class="detail-line-field numeric">
					<input class="form-control input-xs text-right underlined" type="text" size="6" name="qty" value="">
				</span>
			</div>
			<div class="col-md-2 form-group text-right sm-padding">
				<button type="submit" class="btn btn-sm btn-primary">
					<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> &nbsp; Add
				</button>
			</div>
			<div class="col-md-2 form-group text-right sm-padding">
				<button type="button" class="btn btn-sm btn-primary"  data-toggle="modal" data-target="#item-lookup-modal">
					<span class="glyphicon glyphicon-search" aria-hidden="true"></span> &nbsp; Search Items
				</button>
			</div>
			<div class="col-md-2 form-group text-right sm-padding">
				<a href="<?= $config->pages->ajax.'load/products/non-stock/form/cart/'; ?>" class="btn btn-sm btn-primary load-into-modal nonstock-btn" data-modal="#ajax-modal" data-modalsize="xl">
					<i class="fa fa-cube" aria-hidden="true"></i> Add Non-stock
				</a>
			</div>
		</div>
		<div class="col-xs-3 col-sm-3 sm-padding"> </div>
	</div>

	</br>
	<div>
		<div class="qe-results">

		</div>
	</div>
</form>
