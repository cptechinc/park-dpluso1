<legend>Contact</legend>
<table class="table table-striped table-bordered table-condensed">
	<tr>
		<td class="control-label">
			<?= $formconfig->fields['fields']['contact']['label']; ?><?= $formconfig->generate_asterisk('contact'); ?>
			&nbsp;
			<button type="button" class="btn btn-sm btn-primary get-cust-contact-search" data-custid="<?= $order->custid; ?>" data-shiptoid="<?= $order->shiptoid; ?>">Search</button>
		</td>
		<td> <input type="text" name="contact" class="form-control input-sm <?= $formconfig->generate_showrequiredclass('contact'); ?>" id="shiptocontact" value="<?= $order->contact; ?>"> </td>
	</tr>
	<?php if ($config->phoneintl) : ?>
		<tr>
			<td class="control-label">International ?</td>
			<td>
				<select class="form-control input-sm" name="intl" onChange="showphone(this.value)">
					<?php foreach ($config->yesnoarray as $key => $value) : ?>
						<?php $selected = ($order->phintl == $value) ? 'selected' : ''; ?>
						<option value="<?= $value; ?>" <?= $selected; ?>><?= $key; ?></option>
					<?php endforeach; ?>
				</select>
			</td>
		</tr>
		<?php include $config->paths->content.'edit/orders/orderhead/phone-domestic.php'; ?>
	<?php else : ?>
		<?php include $config->paths->content.'edit/orders/orderhead/phone-domestic.php'; ?>
	<?php endif; ?>

	<tr>
		<td class="control-label"><?= $formconfig->fields['fields']['email']['label']; ?><?= $formconfig->generate_asterisk('email'); ?></td>
		<td> <input type="text" name="contact-email" class="form-control input-sm <?= $formconfig->generate_showrequiredclass('email'); ?> email" value="<?= $order->email; ?>"> </td>
	</tr>
</table>

<legend>Sales Order</legend>
<table class="table table-striped table-bordered table-condensed">
	<tr class="bg-info">
		<td class="control-label">Sales Person</td>
		<td> <p class="form-control-static"><?= $order->sp1; ?> - <?= $order->sp1name; ?></p> </td>
	</tr>
	<tr>
		<td class="control-label"><?= $formconfig->fields['fields']['custpo']['label']; ?><?= $formconfig->generate_asterisk('custpo'); ?></td>
		<td> <input type="text" name="custpo" class="form-control input-sm <?= $formconfig->generate_showrequiredclass('custpo'); ?>" value="<?= $order->custpo; ?>"> </td>
	</tr>
	<tr>
		<td class="control-label"><?= $formconfig->fields['fields']['releasenbr']['label']; ?><?= $formconfig->generate_asterisk('releasenbr'); ?></td>
		<td> <input type="text" name="release-number" class="form-control input-sm <?= $formconfig->generate_showrequiredclass('releasenbr'); ?>" value="<?= $order->releasenbr; ?>"> </td>
	</tr>
	<tr>
		<td>Shipvia</td>
		<td>
			<select name="shipvia" class="form-control input-sm">
				<?php $shipvias = get_shipvias(session_id()); ?>
				<?php foreach($shipvias as $shipvia) : ?>
					<?php if ($order->shipviacd == $shipvia['code']) {$selected = 'selected'; } else {$selected = ''; } ?>
					<option value="<?= $shipvia['code']; ?>" <?= $selected; ?>><?= $shipvia['via']; ?> </option>
				<?php endforeach; ?>
			</select>
		</td>
	</tr>
	<tr>
		<td class="control-label">Terms Code</td> <td class="value text-right"><?= $order->termcode; ?> - <?= $order->termcodedesc; ?></td>
	</tr>
	<tr>
		<td class="control-label">Order Date</td> <td class="value text-right"><?= $order->orderdate; ?></td>
	</tr>
	<tr>
		<td class="control-label">Request Date</td>
		<td>
			<div class="input-group date">
				<?php $name = 'rqstdate'; $value = $order->rqstdate; ?>
				<?php include $config->paths->content."common/date-picker.php"; ?>
			</div>
		</td>
	</tr>
	<tr>
		<td class="control-label">Ship Complete</td>
		<td>
			<select name="ship-complete" class="form-control input-sm">
				<?php foreach ($config->yesnoarray as $key => $value) : ?>
					<?php if ($order->shipcom == $value) {$selected = 'selected'; } else {$selected = ''; } ?>
					<option value="<?= $value; ?>" <?= $selected; ?>><?= $key; ?></option>
				<?php endforeach; ?>
			</select>
		</td>
	</tr>
	<?php if ($order->termtype == 'STD') : ?>
		<tr>
			<td class="control-label">Payment Type</td>
			<td>
				<select name="paytype" class="form-control input-sm required" onChange="showcredit(this.value)">
					<option value="<?= $order->paymenttype; ?>">-- Choose Payment Type -- </option>
					<option value="billacc" <?php if ($order->paymenttype == 'bill') echo 'selected'; ?> >Bill To Account</option>
					<option value="cc" <?php if ($order->paymenttype == 'cc') {echo 'selected';} ?>>Credit Card</option>
				</select>
			</td>
		</tr>
	<?php endif; ?>
</table>
<?php $creditcard = $editorderdisplay->get_creditcard(); ?>
<?php if ($order->termtype == 'STD') : ?>
	<div id="credit" class="<?= $editorderdisplay->showhide_creditcard($order); ?>">
		<?php include $config->paths->content.'edit/orders/orderhead/credit-card-form.php'; ?>
	</div>
<?php else : ?>
	<?php include $config->paths->content.'edit/orders/orderhead/credit-card-form.php'; ?>
<?php endif; ?>
