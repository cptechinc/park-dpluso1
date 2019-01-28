<div class="form-group">
	<a href="<?= $contact->generate_customerURL(); ?>" class="btn btn-primary"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Go To <?= $contact->get_customername()."'s"; ?> Page </a>
</div>
<div class="form-group">
	<a href="<?= $contact->generate_contacturl(); ?>" class="btn btn-success"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Go To <?= $contact->contact."'s"; ?> Page </a>
</div>
<div class="row">
	<div class="col-sm-6">
		<div class="panel panel-primary not-round">
			<div class="panel-heading not-round">
				<h3 class="panel-title">Contact Details</h3>
			</div>
			<table class="table table-striped table-condensed table-user-information">
				<tr>
					<td>Customer:</td>
					<td>
						<a href="<?= $contact->generate_customerURL(); ?>" target="_blank">
							<strong><?= $contact->custid. ' - '. $contact->name ?> <i class="glyphicon glyphicon-share" aria-hidden="true"></i></strong>
						</a>
					</td>
				</tr>
				<?php if ($contact->has_shipto()) : ?>
					<tr>
						<td>Shipto ID:</td>
						<td><a href="<?= $contact->generate_shiptourl(); ?>" target="_blank"><?= $contact->shiptoid; ?> <i class="glyphicon glyphicon-share" aria-hidden="true"></i></a></td>
					</tr>
				<?php endif; ?>
				<tr>
					<td>Address:</td>
					<td>
						<?= $contact->addr1; ?><br>
						<?= (strlen($contact->addr2) > 0) ? $contact->addr2.'<br>' : ''; ?>
						<?= $contact->city . ', ' . $contact->state . ' ' . $contact->zip; ?>
					</td>
				</tr>

				<tr>
					<td class="control-label">Name:</td>
					<td><?= $contact->contact; ?></td>
				</tr>
				<tr>
					<td class="control-label">Title:</td>
					<td><?= $contact->title; ?></td>
				</tr>
				<tr>
					<td class="control-label">Email</td>
					<td><a href="mailto:<?= $contact->email; ?>"><?= $contact->email; ?></a></td>
				</tr>
				<tr>
					<td class="control-label">Office Phone</td>
					<td>
					<a href="tel:<?= $contact->phone; ?>"><?= $page->stringerbell->format_phone($contact->phone); ?></a><b> &nbsp;
						<?php if ($contact->has_extension()) { echo 'Ext. ' . $contact->extension;} ?></b>
					</td>
				</tr>
				<tr>
					<td class="control-label">Cell Phone</td>
					<td><a href="tel:<?= $contact->cellphone; ?>"> <?= $page->stringerbell->format_phone($contact->cellphone); ?></a></td>
				</tr>
				<tr>
					<td class="control-label">Fax</td>
					<td><a href="tel:<?= $contact->cellphone; ?>"> <?= $page->stringerbell->format_phone($contact->faxnbr); ?></a></td>
				</tr>
				<tr class="<?= $contact->has_shipto() ? 'hidden' : ''; ?>">
					<td class="control-label">AR Contact</td>
					<td>
						<?php if ($contact->arcontact == '0') : ?>
        				    <?= array_flip($config->yesnoarray)['N']; ?>
                        <?php else : ?>
                            <?= array_flip($config->yesnoarray)[$contact->arcontact]; ?>
                        <?php endif; ?>
					</td>
				</tr>
				<tr class="<?= $contact->has_shipto() ? 'hidden' : ''; ?>">
					<td class="control-label">Dunning Contact</td>
					<td>
                        <?= array_flip($config->yesnoarray)[$contact->dunningcontact]; ?>
					</td>
				</tr>
				<tr class="<?= $contact->has_shipto() ? 'hidden' : ''; ?>">
					<td class="control-label">Acknowledgement Contact</td>
					<td>
                        <?= array_flip($config->yesnoarray)[$contact->ackcontact]; ?>
					</td>
				</tr>
				<tr>
					<?php if ($primarycontact) : ?>
						<td class="control-label">Buying Contact <a class="small" href="<?= $primarycontact->generate_contacturl(); ?>" target="_blank">[View Primary]</a></td>
					<?php else : ?>
						<td class="control-label">Buying Contact</td>
					<?php endif; ?>
					<td>
                        <?= $config->buyertypes[$contact->buyingcontact]; ?>
					</td>
				</tr>
				<tr>
					<?php if ($config->cptechcustomer == 'stat') : ?>
						<td class="control-label">End User</td>
					<?php else : ?>
						<td class="control-label">Certificate Contact</td>
					<?php endif; ?>
					<td>
                        <?= array_flip($config->yesnoarray)[$contact->certcontact]; ?>
					</td>
				</tr>
			</table>
		</div> <!-- end panel round -->
	</div>
	<div class="col-sm-6">
		<div class="panel panel-warning not-round">
			<div class="panel-heading not-round">
				<h3 class="panel-title">Edit Contact Details</h3>
			</div>
			<form action="<?= $config->pages->customer.'redir/'; ?>" method="post">
				<input type="hidden" name="action" value="edit-contact">
				<input type="hidden" name="custID" value="<?= $contact->custid; ?>">
				<input type="hidden" name="shipID" value="<?= $contact->shiptoid; ?>">
				<input type="hidden" name="contactID" value="<?= $contact->contact; ?>">
				<input type="hidden" name="page" value="<?= $page->fullURL; ?>">
				<table class="table table-striped table-condensed table-user-information">
					<tr>
						<td>Customer:</td>
						<td>
							<a href="<?= $contact->generate_customerURL(); ?>" target="_blank">
								<strong><?= $contact->custid. ' - '. $contact->name ?> <i class="glyphicon glyphicon-share" aria-hidden="true"></i></strong>
							</a>
						</td>
					</tr>
					<?php if ($contact->has_shipto()) : ?>
						<tr>
							<td>Shipto ID:</td>
							<td><a href="<?= $contact->generate_shiptourl(); ?>" target="_blank"><?= $contact->shiptoid; ?> <i class="glyphicon glyphicon-share" aria-hidden="true"></i></a></td>
						</tr>
					<?php endif; ?>
					<tr>
						<td>Address:</td>
						<td>
							<?= $contact->addr1; ?><br>
							<?= (strlen($contact->addr2) > 0) ? $contact->addr2.'<br>' : ''; ?>
							<?= $contact->city . ', ' . $contact->state . ' ' . $contact->zip; ?>
						</td>
					</tr>

					<tr>
						<td class="control-label">Name</td>
						<td><input class="form-control input-sm required" name="contact-name" value="<?= $contact->contact; ?>"></td>
					</tr>
					<tr>
						<td class="control-label">Title:</td>
						<td><input type="text" class="form-control input-sm" name="contact-title" value="<?= $contact->title; ?>"></td>
					</tr>
					<tr>
						<td class="control-label">Email</td>
						<td><input class="form-control input-sm required" name="contact-email" value="<?= $contact->email; ?>"></td>
					</tr>
					<tr>
					<td class="control-label">Office Phone</td>
					<td>
						<div class="row">
							<div class="col-sm-8">
								<input class="form-control input-sm phone-input required" name="contact-phone" value="<?= $page->stringerbell->format_phone($contact->phone); ?>">
							</div>
							<div class="col-sm-4">
								<input class="form-control input-sm" name="contact-extension" value="<?= $contact->extension; ?>" placeholder="Ext.">
							</div>
						</div>
					</td>
					</tr>
					<tr>
						<td class="control-label">Cell Phone</td>
						<td><input class="form-control input-sm phone-input " name="contact-cellphone" value="<?= $page->stringerbell->format_phone($contact->cellphone); ?>"></td>
					</tr>
					<tr>
						<td class="control-label">Fax</td>
						<td><input type="tel" class="form-control input-sm phone-input" name="contact-fax" value="<?= $page->stringerbell->format_phone($contact->faxnbr); ?>"></td>
					</tr>
					<tr class="<?= $contact->has_shipto() ? 'hidden' : ''; ?>">
						<td class="control-label">AR Contact</td>
						<td>
							<?= $page->bootstrap->select('class=form-control input-sm|name=arcontact', array_flip($config->yesnoarray), $contact->arcontact); ?>
						</td>
					</tr>
					<tr class="<?= $contact->has_shipto() ? 'hidden' : ''; ?>">
						<td class="control-label">Dunning Contact</td>
						<td>
							<?= $page->bootstrap->select('class=form-control input-sm|name=dunningcontact', array_flip($config->yesnoarray), $contact->dunningcontact); ?>
						</td>
					</tr>
					<tr class="<?= $contact->has_shipto() ? 'hidden' : ''; ?>">
						<td class="control-label">Acknowledgement Contact</td>
						<td>
							<?= $page->bootstrap->select('class=form-control input-sm|name=ackcontact', array_flip($config->yesnoarray), $contact->ackcontact); ?>
						</td>
					</tr>
					<tr>
						<?php if ($primarycontact) : ?>
							<td class="control-label">Buying Contact <a class="small" href="<?= $primarycontact->generate_contacturl(); ?>" target="_blank">[View Primary]</a></td>
						<?php else : ?>
							<td class="control-label">Buying Contact</td>
						<?php endif; ?>
						<td>
							<?= $page->bootstrap->select('class=form-control input-sm|name=buycontact', $config->buyertypes, $contact->buyingcontact); ?>
						</td>
					</tr>
					<tr>
						<?php if ($config->cptechcustomer == 'stat') : ?>
							<td class="control-label">End User</td>
						<?php else : ?>
							<td class="control-label">Certificate Contact</td>
						<?php endif; ?>
						<td>
							<?= $page->bootstrap->select('class=form-control input-sm|name=certcontact', array_flip($config->yesnoarray), $contact->certcontact); ?>
						</td>
					</tr>
				</table>
				<div class="panel-footer">
					<button type="submit" class="btn btn-success btn-sm">
						<i class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></i> Save Changes
					</button>
				</div> <!-- end panel footer -->
			</form>
		</div> <!-- end panel round -->
	</div>
</div>
