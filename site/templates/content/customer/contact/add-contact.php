<div class="row">
	<div class="col-sm-6">
		<form action="<?= $config->pages->customer.'redir/'; ?>" method="post">
			<input type="hidden" name="action" value="add-contact">
			<input type="hidden" name="custID" value="<?= $custID; ?>">
			<input type="hidden" name="shipID" value="<?= $shipID; ?>">
			<input type="hidden" name="page" value="<?= $page->fullURL; ?>">
			<table class="table table-striped table-bordered table-condensed">
				<tbody>
					<tr>
						<td class="control-label">Name</td>
						<td><input class="form-control input-sm required" name="contact-name"></td>
					</tr>
					<tr>
						<td class="control-label">Contact Title</td>
						<td><input type="text" class="form-control input-sm" name="contact-title" value=""></td>
					</tr>
					<tr>
						<td class="control-label">Phone</td>
						<td><input class="form-control input-sm phone-input required" name="contact-phone"></td>
					</tr>
					<tr>
						<td class="control-label">Ext.</td>
						<td><input class="form-control pull-right input-sm qty" name="contact-extension"></td>
					</tr>
					<tr>
						<td class="control-label">Fax</td>
						<td><input type="tel" class="form-control input-sm phone-input" name="contact-fax" value=""></td>
					</tr>
					<tr>
						<td class="control-label">Cell</td>
						<td><input class="form-control input-sm phone-input " name="contact-cellphone"></td>
					</tr>
					<tr>
						<td class="control-label">Email</td>
						<td><input class="form-control input-sm required" name="contact-email"></td>
					</tr>
					<tr class="<?= $customer->has_shipto() ? 'hidden' : ''; ?>">
						<td class="control-label">AR Contact</td>
						<td>
							<?php $attr = "class=form-control input-sm|name=arcontact"; ?>
							<?php $attr .= ((LogmUser::load($user->loginid))->get_dplusrole() == Dplus\ProcessWire\DplusWire::wire('config')->roles['sales-rep']) ? '|disabled' : ''; ?>
							<?= $page->bootstrap->select("$attr", array_flip($config->yesnoarray), 'N'); ?>
						</td>
					</tr>
					<tr class="<?= $customer->has_shipto() ? 'hidden' : ''; ?>">
						<td class="control-label">Dunning Contact</td>
						<td>
							<?php $attr = "class=form-control input-sm|name=dunningcontact"; ?>
							<?php $attr .= ((LogmUser::load($user->loginid))->get_dplusrole() == Dplus\ProcessWire\DplusWire::wire('config')->roles['sales-rep']) ? '|disabled' : ''; ?>
							<?= $page->bootstrap->select($attr, array_flip($config->yesnoarray), 'N'); ?>
						</td>
					</tr>
					<tr <?= $customer->has_shipto() ? 'hidden' : ''; ?>>
						<td class="control-label">Acknowledgement Contact</td>
						<td>
							<?= $page->bootstrap->select('class=form-control input-sm|name=ackcontact', array_flip($config->yesnoarray), 'N'); ?>
						</td>
					</tr>
					<tr>
						<?php if ($primarycontact) : ?>
							<td class="control-label">Buying Contact <a class="small" href="<?= $primarycontact->generate_contacturl(); ?>" target="_blank">[View Primary]</a></td>
						<?php else : ?>
							<td class="control-label">Buying Contact</td>
						<?php endif; ?>

						<td>
							<?= $page->bootstrap->select('class=form-control input-sm|name=buycontact', $config->buyertypes, 'N'); ?>
						</td>
					</tr>
					<tr>
						<?php if ($config->cptechcustomer == 'stat') : ?>
							<td class="control-label">End User</td>
						<?php else : ?>
							<td class="control-label">Certificate Contact</td>
						<?php endif; ?>

						<td>
							<?= $page->bootstrap->select('class=form-control input-sm|name=certcontact', array_flip($config->yesnoarray), 'N'); ?>
						</td>
					</tr>
				</tbody>
		   </table>
		   <button type="submit" class="btn btn-success">
			  <i class="fa fa-user-plus" aria-hidden="true"></i> Add Contact
		   </button>
		</form>
	</div>
</div>
