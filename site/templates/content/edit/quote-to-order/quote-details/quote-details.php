<hr class="detail-line-header">
<div class="row detail-line-header">
	<strong>
		<div class="col-md-9 sm-padding">
            <div class="col-sm-1 sm-padding"><input type="checkbox" id="select-all">&nbsp;&nbsp;</div>
			<div class="col-sm-3 sm-padding">Item / Description</div>
			<div class="col-sm-1 text-left sm-padding">WH</div>
			<div class="col-sm-1 text-right ">Qty</div>
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
<div class="quote-details">
	<?php $quote_details = $editquotedisplay->get_quotedetails($quote); ?>
	<?php foreach ($quote_details as $detail) : ?>
		<form action="<?= $config->pages->quotes.'redir/'; ?>" method="post" class="form-group detail allow-enterkey-submit">
			<input type="hidden" name="action" value="quick-update-line">
	        <input type="hidden" name="qnbr" value="<?= $qnbr; ?>">
			<input type="hidden" name="linenbr" value="<?= $detail->linenbr; ?>">
			<input type="hidden" name="page" value="<?= $page->fullURL->getUrl(); ?>">
			<input type="hidden" name="min-price" value="<?= $detail->minprice; ?>">
			<div class="row detail-line">
				<div class="col-md-9 sm-padding">
                    <div class="col-sm-1 sm-padding">
                        <input type="checkbox" value="<?= $detail->linenbr; ?>" class="select-item" checked>
                    </div>
					<div class="col-sm-3 form-group sm-padding">
                        <span class="detail-line-field-name cart-item">Item/Description:</span>
						<div>
							<?php if ($detail->has_error()) : ?>
								<div class="btn-sm btn-danger">
								  <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <strong>Error!</strong> <?= $detail->errormsg; ?>
								</div>
							<?php else : ?>
								<?= $detail->itemid; ?>
								<?= (strlen($detail->vendoritemid)) ? $detail->vendoritemid : ''; ?>
								<br> <small class="description-small"><?= $detail->desc1; ?></small>
							<?php endif; ?>
						</div>
						<div class="response"></div>
					</div>
					<div class="col-md-1 form-group sm-padding">
						<span class="detail-line-field-name">WH:</span>
						<p class="form-control-static"><span class="detail-line-field numeric"><?= $detail->whse; ?></span></p>
					</div>
					<div class="col-md-1 form-group sm-padding">
						<span class="detail-line-field-name">Qty:</span>
						<span class="detail-line-field numeric">
							<input class="form-control input-xs text-right underlined calculates-price" type="text" size="6" name="qty" value="<?= $detail->quotqty + 0; ?>">
						</span>
					</div>
					<div class="col-md-2 form-group sm-padding">
						<span class="detail-line-field-name">Price:</span>
						<span class="detail-line-field numeric">
							<input class="form-control input-xs text-right underlined calculates-price" type="text" size="10" name="price" value="<?= $page->stringerbell->format_money($detail->quotprice); ?>">
						</span>
					</div>
					<div class="col-md-2 form-group sm-padding">
						<span class="detail-line-field-name">Total:</span>
						<p class="form-control-static text-right"><span class="detail-line-field numeric">$ <span class="total-price"><?= $page->stringerbell->format_money($detail->quotqty * $detail->quotprice); ?></span></span></p>
					</div>
					<div class="col-md-2 form-group sm-padding">
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
							<!-- View Detail Link --> 
							<a href="<?= $editquotedisplay->generate_viewdetailURL($quote, $detail); ?>" class="h3 view-item-details detail-line-icon" data-itemid="<?= $detail->itemid; ?>" data-kit="<?= $detail->kititemflag; ?>" data-modal="<?= $editquotedisplay->modal; ?>">
								<i class="fa fa-info-circle" aria-hidden="true"></i>
							</a>
							<!-- Dplus Notes Link --> 
							<?php if ($detail->has_notes()) : ?>
								<a href="<?= $editquotedisplay->generate_request_dplusnotesURL($quote, $detail->linenbr); ?>" class="load-notes" title="View Order Notes" data-modal="<?= $editquotedisplay->modal; ?>">
									<i class="material-icons md-36" aria-hidden="true">&#xE0B9;</i>
								</a>
							<?php else : ?>
								<a href="<?= $editquotedisplay->generate_request_dplusnotesURL($quote, $detail->linenbr); ?>" class="load-notes text-muted" title="View Order Notes" data-modal="<?= $editquotedisplay->modal; ?>">
									<i class="material-icons md-36" aria-hidden="true">&#xE0B9;</i>
								</a>
							<?php endif; ?>
						</div>
						<div class="col-xs-6 sm-padding">
							<h4 class="visible-xs-block">Edit</h4>
							<!-- Save Detail Button --> 
							<button type="submit" name="button" class="btn btn-sm btn-info detail-line-icon" title="Save Changes">
								<span class="fa fa-floppy-o"></span> <span class="sr-only">Save Line</span>
							</button>
							<!-- Edit Detail Link --> 
							<a href="<?= $editquotedisplay->generate_vieweditdetailURL($quote, $detail); ?>" class="update-line" data-kit="<?= $detail->kititemflag; ?>" data-itemid="<?= $detail->itemid; ?>" data-custid="<?= $quote->custid; ?>" aria-label="Edit Detail Line">
								<button class="btn btn-sm btn-warning detail-line-icon">
									<span class="fa fa-pencil"></span>
								</button>
							</a>
							<!-- Remove Detail Link --> 
							<a href="<?= $editquotedisplay->generate_removedetailURL($quote, $detail); ?>" class="btn btn-sm btn-danger" aria-label="Delete Line" title="Delete Line">
								<span class="fa fa-trash-o"></span>
							</a>
						</div>
					</div>
				</div>
			</div>
		</form>
	<?php endforeach; ?>
</div>
<?php include $config->paths->content.'edit/quote-to-order/quote-details/add-quick-entry.php'; ?>
