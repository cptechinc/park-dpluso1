<?php 
	use Dplus\ProcessWire\DplusWire;
	include "{$config->paths->content}warehouse/picking/item.js.php"; 
?>
<div>
	<h2>Head to <?= $pickitem->bin; ?></h2>
	<table class="table table-condensed table-striped">
		<tr>
			<td class="control-label">Current Pallet #</td>
			<td class="text-right" colspan="2">
				<form action="<?= $pickorder->get_redirURL(); ?>" method="get">
					<input type="hidden" name="action" value="set-pallet">
					<input type="hidden" name="page" value="<?= $page->fullURL; ?>">
					<select name="palletnbr" class="form-control input-sm display-inline-block qty change-pallet">
						<?php for ($i = 1; $i < ($pickorder->order->lastpalletnbr + 1); $i++) : ?>
							<option value="<?= $i; ?>" <?= $i == $whsesession->palletnbr ? 'selected' : ''; ?>><?= $i; ?></option>
						<?php endfor; ?>
					</select>
					&nbsp; &nbsp;
					<a href="<?= $pickorder->generate_addpalleturl(); ?>" class="btn btn-emerald">
						<i class="fa fa-cart-plus" aria-hidden="true"></i> Add Pallet
					</a>
				</form>
			</td>
		</tr>
		<tr>
			<td class="control-label">Order #</td> <td class="text-right" colspan="2"><?= $pickitem->ordn; ?></td>
		</tr>
		<tr>
			<td class="control-label">Bin #</td> <td class="text-right" colspan="2"><?= $pickitem->bin; ?></td>
		</tr>
		<tr>
			<td class="control-label">Expected Qty</td> <td class="text-right" colspan="2"><?= $pickitem->binqty; ?></td>
		</tr>
		<tr>
			<td class="control-label">Item ID</td> 
			<td class="text-right" colspan="2">
				<?= $pickitem->itemid; ?>
				<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#item-info-modal">
					Item Info
				</button>
			</td>
		</tr>
		<tr>
			<td class="control-label">Qty Needed</td> 
			<td class="text-right"><?= $pickitem->qtyordered; ?> Eaches</td>
			<td class="text-right"><?= $pickitem->get_qtycasedescription($pickitem->qtyordered); ?></td>
		</tr>
		<?php if ($pickitem->has_qtypulled()) : ?>
			<tr>
				<td class="control-label">Previously Picked</td> 
				<td class="text-right"><?= $pickitem->qtypulled; ?> Eaches</td>
				<td class="text-right"><?= $pickitem->get_qtycasedescription($pickitem->qtypulled); ?></td>
			</tr>
		<?php endif; ?>
		<tr>
			<td class="control-label">Qty Picked</td> 
			<td class="text-right"><?= intval($pickitem->get_userpickedtotal()); ?> Eaches</td>
			<td class="text-right"><?= $pickitem->get_qtycasedescription(intval($pickitem->get_userpickedtotal())); ?></td>
		</tr>
		<?php 
			$bgcolor = ''; 
			if ($pickitem->has_pickedtoomuch() || $pickitem->has_pickedmorethanbinqty()) {
				$bgcolor = "bg-warning";
			} elseif (!$pickitem->has_qtyremaining()) {
				$bgcolor = "bg-success";
			}
		?>
		<tr class="<?= $bgcolor; ?>">
			<td class="control-label">Qty Remaining</td> 
			<td class="text-right"><?= $pickitem->get_qtyremaining(); ?> Eaches</td>
			<td class="text-right"><?= $pickitem->get_qtycasedescription($pickitem->get_qtyremaining()); ?></td>
		</tr>
	</table>
	
	<?php if (DplusWire::wire('notices')->hasErrors()) : ?>
		<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<strong>Error!</strong>
			<?php foreach (DplusWire::wire('notices') as $notice) : ?>
				<?= $notice->text; ?><br>
			<?php endforeach; ?>
			<?= $session->removeNotices(); ?>
		</div>
	<?php endif; ?>
	<form action="<?= "{$config->pages->salesorderpicking}redir/"; ?>" method="POST" class="allow-enterkey-submit">
		<input type="hidden" name="action" value="add-barcode">
        <input type="hidden" name="palletnbr" value="<?= $whsesession->palletnbr; ?>">
		<input type="hidden" name="page" value="<?= $page->fullURL; ?>">
        <div class="input-group form-group">
            <input class="form-control" name="barcode" placeholder="Barcode" type="text" autofocus>
            <span class="input-group-btn">
                <button type="submit" class="btn btn-emerald not-round">
					<i class="fa fa-plus" aria-hidden="true"></i> Add
				</button>
            </span>
        </div>
    </form>
	
	<div class="row">
		<div class="col-sm-3 col-xs-6 form-group">
			<a href="<?= $pickorder->generate_finishitemurl($pickitem); ?>" class="btn btn-emerald finish-item">
				<i class="fa fa-check-square" aria-hidden="true"></i> Submit Item
			</a>
		</div>
		<div class="col-sm-3 col-xs-6 form-group">
			<a href="<?= $pickorder->generate_skipitemurl($pickitem); ?>" class="btn btn-emerald finish-item">
				<i class="fa fa-check-square" aria-hidden="true"></i> Skip Item
			</a>
		</div>
		<div class="col-sm-3 col-xs-6 form-group">
			<button type="button" class="btn btn-warning change-bin">
				Change Bin
			</button>
		</div>
		<div class="col-sm-3 col-xs-6 form-group">
			<a href="<?= $pickorder->generate_exitorderurl(); ?>" class="btn btn-danger exit-order">Exit Order</a>
		</div>
	</div>
</div>
<h3 class="text-center">Barcodes Scanned</h3>
<?php include $config->paths->content."warehouse/picking/pick-pack/picked-items-table.php"; ?>
<?php include $config->paths->content."warehouse/picking/pick-order/item-info-modal.php"; ?>
	
