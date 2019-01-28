<?php
	if ($input->get->vendorID) {
		$linedetail->set('vendorid', $vendorID);
		$linedetail->set('shipfrom', '');
	}
?>

<?php if ($config->ajax) : ?>
	<p>
		<a href="<?php echo $config->filename; ?>" target="_blank"><i class="glyphicon glyphicon-print" aria-hidden="true"></i> View Printable Version</a>
		&nbsp; &nbsp;
		<a href="<?= $config->pages->products.'redir/?action=ii-select&itemID='.urlencode($linedetail->itemid); ?>" target="_blank"><i class="material-icons" aria-hidden="true">&#xE051;</i> View In II</a>
	</p>
<?php endif; ?>

<form action="<?php echo $formaction; ?>" method="post" id="<?= $linedetail->itemid.'-form'; ?>">
	<input type="hidden" class="action" name="action" value="update-line">
	<input type="hidden" name="ordn" value="<?= $ordn; ?>">
	<input type="hidden" name="custID" value="<?= $custID; ?>">
	<input type="hidden" name="itemID" value="<?= $linedetail->itemid; ?>">
	<input type="hidden" class="listprice" value="<?= $page->stringerbell->format_money($linedetail->listprice); ?>">
	<input type="hidden" class="linenumber" name="linenbr" value="<?= $linedetail->linenbr; ?>">
	<input type="hidden" class="originalprice" value="<?= $page->stringerbell->format_money($linedetail->price); ?>">
	<input type="hidden" class="discountprice" value="<?= $page->stringerbell->format_money($linedetail->price); ?>">
	<input type="hidden" class="cost" value="<?= $page->stringerbell->format_money($linedetail->cost); ?>">
	<input type="hidden" class="minprice" value="<?= $page->stringerbell->format_money($linedetail->minprice); ?>">
	<input type="hidden" class="calculate-from" value="percent">
	<?php if (!$appconfig->child('name=sales-orders')->allow_discount): ?>
		<input type="hidden" class="discpct" name="discount" value="<?= $page->stringerbell->format_money($linedetail->discpct); ?>">
	<?php endif; ?>
	<?php if (!$appconfig->allow_changeprice) : ?>
		<input type="hidden" name="price" value="<?= $page->stringerbell->format_money($linedetail->price); ?>">
	<?php endif; ?>
	<div class="row">
		<div class="col-sm-8 item-information">
			<div class="jumbotron item-detail-heading"> <div> <h4>Item Info</h4> </div> </div>
			<?php //include $config->paths->content."edit/pricing/item-info.php"; ?>

			<br><br>
			<div class="row">
				<div class="col-sm-6">
					<div class="jumbotron item-detail-heading"> <div> <h4>Item Pricing</h4> </div> </div>
					<div style="height: 150px; overflow-y: auto;">
						<?php $tableformatter= $page->screenformatterfactory->generate_screenformatter('item-pricing'); ?>
						<?php include $config->paths->content.'common/include-tableformatter-display.php'; ?>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="jumbotron item-detail-heading"> <div class=""> <h4><?= Customer::get_customernamefromid($custID); ?> History</h4> </div> </div>
					<?php $tableformatter= $page->screenformatterfactory->generate_screenformatter('item-purchasehistory'); ?>
					<?php include $config->paths->content.'common/include-tableformatter-display.php'; ?>
				</div>
			</div>

			<div class="jumbotron item-detail-heading"> <div class=""> <h4>Item Availability</h4> </div> </div>
			<?php $tableformatter= $page->screenformatterfactory->generate_screenformatter('item-stock'); ?>
			<?php include $config->paths->content.'common/include-tableformatter-display.php'; ?>
		</div>
		<div class="col-sm-4 item-form">
			<h4>Current Price</h4>
			<?php
				if ($modules->isInstalled('CaseQtyBottle')) {
					if ($appconfig->allow_changeprice) {
						include $config->paths->siteModules.'CaseQtyBottle/content/edit/pricing/sales-orders/tables/price-edit-table.php';
					} else {
						include $config->paths->siteModules.'CaseQtyBottle/content/edit/pricing/sales-orders/tables/price-static-table.php';
					}
				} else {
					if ($appconfig->allow_changeprice) {
						include $config->paths->content.'edit/pricing/sales-orders/tables/price-edit-table.php';
					} else {
						include $config->paths->content.'edit/pricing/sales-orders/tables/price-static-table.php';
					}
				}
			?>

			<table class="table table-bordered table-striped table-condensed">
				<tr>
					<td>Requested Ship Date</td>
					<td>
						<div class="input-group date" style="width: 180px;">
							<?php $name = 'rqstdate'; $value = $linedetail->rshipdate;?>
							<?php include $config->paths->content."common/date-picker.php"; ?>
						</div>
					</td>
				</tr>
				<tr>
					<td>Warehouse</td><td><input type="text" class="form-control input-sm qty <?= $linedetail->itemid."-whse"; ?>" name="whse" value="<?= $linedetail->whse; ?>"></td>
				</tr>
				<tr>
					<td>Special Order </td>
					<td>
						<select name="specialorder" class="form-control input-sm">
							<?php foreach ($config->specialordertypes as $spectype => $specdesc) : ?>
								<?php if ($linedetail->spcord == $spectype) : ?>
									<option value="<?= $spectype; ?>" selected><?= $specdesc; ?></option>
								<?php else : ?>
									<option value="<?= $spectype; ?>"><?= $specdesc; ?></option>
								<?php endif; ?>
							<?php endforeach; ?>
						</select>
					</td>
				</tr>
			</table>
			<div class="<?php if (!in_array($linedetail->spcord, array_values($config->specialordercodes))) {echo 'hidden';} ?>">
				<h4>Special Order Details</h4>
				<table class="table table-bordered table-striped table-condensed">
					<tr>
						<td>VendorID</td>
						<td>
							<input type="hidden" name="vendorID" value="<?= $linedetail->vendorid; ?>">
							<?= $linedetail->vendorid; ?>
							<a href="<?= $config->pages->ajax.'load/products/choose-vendor/?returnpage='.$page->fullURL; ?>" class="btn btn-sm btn-warning load-into-modal" data-modal="#ajax-modal">
								<i class="fa fa-pencil" aria-hidden="true"></i> Change Vendor
							</a>
						</td>
					</tr>
					<tr>
						<td>Ship-from</td>
						<td>
							<select name="shipfromID" class="form-control input-sm" id="">
								<?php $shipfroms = get_vendorshipfroms($linedetail->vendorid, false); ?>
								<?php foreach ($shipfroms as $shipfrom) : ?>
									<option value="<?= $shipfrom['shipfrom']; ?>" <?php if ($shipfrom['shipfrom'] == $linedetail->shipfromid) {echo 'selected';} ?>><?= $shipfrom['shipfrom'].' - '.$shipfrom['name']; ?></option>
								<?php endforeach; ?>
							</select>
						</td>
					</tr>
					<tr>
						<td>Vendor ItemID</td>
						<td><input type="text" name="vendoritemID" class="form-control input-sm" value="<?= $linedetail->vendoritemid; ?>"></td>
					</tr>
					<tr>
						<td>Group</td>
						<td>
							<?php $groups = get_itemgroups(); ?>
							<select name="nsitemgroup" class="form-control input-sm">
								<option value="">None</option>
								<?php foreach ($groups as $group) : ?>
									<?php if ($group['code'] == $linedetail->nsitemgroup) : ?>
										<option value="<?= $group['code']; ?>" selected><?= $group['desc']; ?></option>
									<?php else: ?>
										<option value="<?= $group['code']; ?>"><?= $group['desc']; ?></option>
									<?php endif; ?>
								<?php endforeach; ?>
							</select>
						</td>
					</tr>
					<tr>
						<td>PO Nbr</td>
						<td><input type="text" name="ponbr" class="form-control input-sm" value="<?= $linedetail->ponbr; ?>" disabled></td>
					</tr>
					<tr>
						<td>Reference</td>
						<td><input type="text" name="poref" class="form-control input-sm" value="<?= $linedetail->poref; ?>"></td>
					</tr>
				</table>
			</div>
			<?php if ($linedetail->can_edit()) :?>
				<button type="submit" class="btn btn-success btn-block"><i class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></i> Save Changes</button>
				<br>
				<button type="button" class="btn btn-danger btn-block remove-item"><i class="fa fa-trash" aria-hidden="true"></i> Delete Line</button>
			<?php endif; ?>
		</div>
	</div>
</form>
