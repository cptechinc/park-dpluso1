<?php $contacts = search_customerbuyersendusers($custID, $shipID, $input->get->text('q')); ?>
<div id="contact-results">
	<div class="table-responsive">
		<table class="table table-striped table-bordered" id="contacts-table">
			<thead>
				<tr> <th>Shipto</th> <th>Name</th> <th>Title</th> <th>Phone</th> <th>Fax</th> <th>Email</th> <th>Contact Type</th> </tr>
			</thead>
			<tbody>
				<?php foreach ($contacts as $contact) : ?>
					<?php $attr = "data-contact=$contact->contact|data-phone=$contact->phone|data-extension=$contact->extension|data-fax=$contact->faxnbr|data-email=$contact->email"; ?>
					<tr>
						<td><?= $contact->shiptoid; ?></td>
						<td><button type="button" class="btn btn-sm btn-primary order-choose-contact" <?= $page->bootstrap->generate_attributes($attr); ?>><?= $contact->contact; ?></button></td>
						<td><?= $contact->title; ?></td>
						<td>
							<a href="<?= $contact->generate_contactmethodurl('phone'); ?>"><?= $contact->phone; ?></a>
							&nbsp; <?= $contact->has_extension() ? 'Ext. ' . $contact->extension : ''; ?>
						</td>
						<td>
							<?= $contact->faxnbr; ?>
						</td>
						<td><a href="<?= $contact->generate_contactmethodurl('email'); ?>"><?= $contact->email; ?></td>
						<td><?= $contact->generate_buyerorenduserdisplay(); ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
			<tfoot> <tr> <th>Shipto</th> <th>Name</th> <th>Title</th>  <th>Phone</th> <th>Fax</th> <th>Email</th> <th>Contact Type</th> </tr> </tfoot>
		</table>
	</div>
</div>
