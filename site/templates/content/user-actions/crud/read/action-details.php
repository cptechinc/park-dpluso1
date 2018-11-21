<table class="table table-bordered table-striped">
	<tr>
		<td>Action ID:</td> <td><?= $action->id; ?></td>
	</tr>
	<tr>
		<td>Action Type:</td> <td><?= $action->generate_actionsubtypedescription(); ?></td>
	</tr>
	<tr>
		<td>Written on:</td> <td><?= Dplus\Base\DplusDateTime::format_date($action->datecreated, 'm/d/Y g:i A'); ?></td>
	</tr>
	<tr>
		<td>Written by:</td> <td><?= $action->createdby; ?></td>
	</tr>
	<tr>
		<td>Completed:</td> <td><?= Dplus\Base\DplusDateTime::format_date($action->datecompleted, 'm/d/Y g:i A'); ?></td>
	</tr>
	<?php if ($action->has_customerlink()) : ?>
		<tr>
			<td>Customer:</td>
			<td><?= Customer::get_customernamefromid($action->customerlink); ?> &nbsp;<a href="<?= $actiondisplay->generate_ciloadurl($action); ?>" target="_blank"><i class="glyphicon glyphicon-share"></i> Go to Customer Page</a></td>
		</tr>
	<?php endif; ?>
	<?php if ($action->has_shiptolink()) : ?>
		<tr>
			<td>Ship-to:</td>
			<td><?= Customer::get_customernamefromid($action->customerlink, $action->shiptolink); ?> <a href="<?= $actiondisplay->generate_ciloadurl($action); ?>" target="_blank"><i class="glyphicon glyphicon-share"></i> Go to Ship-to Page</a></td>
		</tr>
	<?php endif; ?>
	<?php if ($action->has_contactlink()) : ?>
		<tr>
			<td>Action Contact:</td>
			<td><?= $action->contactlink; ?> <a href="<?= $actiondisplay->generate_contacturl($action); ?>" target="_blank"><i class="glyphicon glyphicon-share"></i> Go to Contact Page</a></td>
		</tr>
	<?php else : ?>
		<tr>
			<td class="text-center h5" colspan="2">
				Who to Contact
			</td>
		</tr>
		<tr>
			<td>Contact: </td>
			<td><?= $contact->contact; ?></td>
		</tr>
	<?php endif; ?>
	<tr>
		<td>Phone:</td>
		<td>
			<a href="tel:<?= $contact->phone; ?>"><?= $contact->phone; ?></a> &nbsp; <?php if ($contact->has_extension()) {echo ' Ext. '.$contact->extension;} ?>
		</td>
	</tr>
	<?php if ($contact->cellphone != '') : ?>
		<tr>
			<td>Cell Phone:</td>
			<td>
				<a href="tel:<?= $contact->cellphone; ?>"><?= $contact->cellphone; ?></a>
			</td>
		</tr>
	<?php endif; ?>
	<tr>
		<td>Email:</td>
		<td><a href="mailto:<?= $contact->email; ?>"><?= $contact->email; ?></a></td>
	</tr>
	<?php if ($action->has_salesorderlink()) : ?>
		<tr>
			<td>Sales Order #:</td>
			<td><?= $action->salesorderlink; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($action->has_quotelink()) : ?>
		<tr>
			<td>Quote #:</td>
			<td><?= $action->quotelink; ?></td>
		</tr>
	<?php endif; ?>
	<tr>
		<td class="control-label">Title</td> <td><?= $action->title; ?></td>
	</tr>
	<tr>
		<td colspan="2">
			<b>Notes</b><br>
			<div class"view-notes">
				<?= $action->textbody; ?>
			</div>
		</td>
	</tr>
</table>
