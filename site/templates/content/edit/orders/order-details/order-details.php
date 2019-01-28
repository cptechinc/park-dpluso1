<hr class="detail-line-header">
<div class="row detail-line-header">
	<strong>
		<div class="col-md-9 sm-padding">
			<div class="col-sm-4 sm-padding">Item / Description</div>
			<div class="col-sm-1 text-left sm-padding">WH</div>
			<div class="col-sm-1 text-right sm-padding">Qty</div>
			<div class="col-sm-2 text-center sm-padding">Price</div>
			<div class="col-sm-2 sm-padding">Total</div>
			<div class="col-sm-2 sm-padding">Rqst Date</div>
		</div>
		<div class="col-md-3 sm-padding">
			<div class="row">
				<div class="col-sm-6 sm-padding">Details</div>
				<div class="col-sm-6 sm-padding">Edit</div>
			</div>
		</div>
	</strong>
</div>
<hr>

<?php $order_details = $editorderdisplay->get_orderdetails($order) ?>
<?php foreach ($order_details as $detail) : ?>
	<form action="<?= $config->pages->orders.'redir/'; ?>" method="post" class="form-group detail allow-enterkey-submit">
		<input type="hidden" name="action" value="quick-update-line">
        <input type="hidden" name="ordn" value="<?= $ordn; ?>">
		<input type="hidden" name="linenbr" value="<?= $detail->linenbr; ?>">
		<input type="hidden" name="min-price" value="<?= $detail->minprice; ?>">
        <div>
            <div class="row">
    			<div class="col-md-9 sm-padding">
					<div class="col-md-4 sm-padding form-group">
						<span class="detail-line-field-name">Item/Description:</span>
						<div>
							<?php if ($detail->has_error()) : ?>
								<div class="btn-sm btn-danger">
								  <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <strong>Error!</strong> <?= $detail->errormsg; ?>
								</div>
							<?php else : ?>
								<?= $detail->itemid; ?>
								<?= (strlen($detail->vendoritemid)) ? "($detail->vendoritemid)" : ''; ?>
								<br> <small class="description-small"><?= $detail->desc1; ?></small>
							<?php endif; ?>
						</div>
						<div class="response"></div>
					</div>
					<div class="col-md-1 sm-padding form-group">
						<span class="detail-line-field-name">WH:</span>
						<p class="form-control-static"><span class="detail-line-field numeric"><?= $detail->whse; ?></span></p>
					</div>
					<div class="col-md-1 sm-padding form-group">
						<span class="detail-line-field-name">Qty:</span>
						<span class="detail-line-field numeric">
							<input class="form-control input-xs text-right underlined calculates-price" type="text" size="6" name="qty" value="<?= $detail->qty + 0; ?>">
						</span>
					</div>
					<div class="col-md-2 sm-padding form-group">
						<span class="detail-line-field-name">Price:</span>
						<span class="detail-line-field numeric">
							<input class="form-control input-xs text-right underlined calculates-price" type="text" size="10" name="price" value="<?= $page->stringerbell->format_money($detail->price); ?>">
						</span>
					</div>
					<div class="col-md-2 sm-paddingform-group">
						<span class="detail-line-field-name">Total:</span>
						<p class="form-control-static text-right"><span class="detail-line-field numeric">$ <span class="total-price"><?= $page->stringerbell->format_money($detail->totalprice); ?></span></span></p>
					</div>
					<div class="col-md-2 sm-padding form-group">
						<span class="detail-line-field-name">Rqst Date:</span>
						<span class="detail-line-field numeric">
							<div class="input-group date">
								<?php $name = 'rqstdate'; $value = $detail->rshipdate; ?>
								<?php include $config->paths->content."common/date-picker-underlined.php"; ?>
							</div>
						</span>
					</div>
    			</div>
    			<div class="col-md-3 sm-padding">
    				<div class="row">
    					<div class="col-xs-6 sm-padding">
                            <h4 class="visible-xs-block">Details</h4>
							<!--  Documents Link -->
				            <?php if ($detail->has_documents()) : ?>
				                <a href="<?= $orderpanel->generate_request_documentsURL($order, $detail); ?>" class="h3 load-sales-docs" title="View Documents" data-loadinto=".docs" data-focus=".docs" data-click="#documents-link">
				                    <i class="fa fa-file-text" aria-hidden="true"></i>
				                </a>
				            <?php else : ?>
				                <a href="#" class="h3 text-muted" title="No Documents Found">
				                    <i class="fa fa-file-text" aria-hidden="true"></i>
				                </a>
				            <?php endif; ?>
							
							<!--  Notes Link -->
							<?php if ($detail->has_notes()) : ?>
								<a href="<?= $editorderdisplay->generate_request_dplusnotesURL($order, $detail->linenbr); ?>" class="load-notes" title="View Order Notes" data-modal="<?= $editorderdisplay->modal; ?>">
									<i class="material-icons md-36" aria-hidden="true">&#xE0B9;</i>
								</a>
							<?php else : ?>
								<a href="<?= $editorderdisplay->generate_request_dplusnotesURL($order, $detail->linenbr); ?>" class="load-notes text-muted" title="View Order Notes" data-modal="<?= $editorderdisplay->modal; ?>">
									<i class="material-icons md-36" aria-hidden="true">&#xE0B9;</i>
								</a>
							<?php endif; ?>
    					</div>
    					<div class="col-xs-6 sm-padding">
                            <h4 class="visible-xs-block">Edit</h4>
							<!--  Save Button -->
							<?php if ($order->can_edit()) : ?>
								<button type="submit" name="button" class="btn btn-sm btn-info detail-line-icon" title="Save Changes">
									<span class="fa fa-floppy-o"></span> <span class="sr-only">Save Line</span>
								</button>
							<?php endif; ?>
							<?php if ($order->can_edit()) : ?>
								<!--  Edit Link -->
								<a href="<?= $editorderdisplay->generate_vieweditdetailURL($order, $detail); ?>" class="btn btn-sm btn-warning update-line" aria-label="Edit Detail Line" data-kit="<?= $detail->kititemflag; ?>" data-itemid="<?= $detail->itemid; ?>" data-custid="<?= $order->custid; ?>">
									<i class="fa fa-pencil" aria-hidden="true"></i>
								</a>
								<!--  Delete Line Link -->
								<a href="<?= $editorderdisplay->generate_removedetailURL($order, $detail); ?>" class="btn btn-sm btn-danger" title="Delete Line">
									<i class="fa fa-trash" aria-hidden="true"></i> <span class="sr-only">Delete Line</span>
								</a>
							<?php else : ?>
								<!--  View Details Link -->
								<a href="<?= $editorderdisplay->generate_detailviewediturl($order, $detail); ?>" class="btn btn-sm btn-default update-line" aria-label="View Detail Line" data-kit="<?= $detail->kititemflag; ?>" data-itemid="<?= $detail->itemid; ?>" data-custid="<?= $order->custid; ?>">
									<i class="fa fa-eye" aria-hidden="true"></i>
								</a>
							<?php endif; ?>
    					</div>
    				</div>
    			</div>
    		</div>
        </div>
	</form>
<?php endforeach; ?>
<?php if ($order->can_edit()) : ?>
	<?php include $config->paths->content.'edit/orders/order-details/add-quick-entry.php'; ?>
<?php endif; ?>
