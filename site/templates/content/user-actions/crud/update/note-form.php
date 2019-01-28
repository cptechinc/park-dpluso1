<form action="<?= $editactiondisplay->generate_editactionurl($note); ?>" method="post" id="new-action-form" data-refresh="#actions-panel" data-modal="#ajax-modal" onKeyPress="return disable_enterkey(event)">
	<input type="hidden" name="action" value="update-note">
	<input type="hidden" name="id" value="<?= $note->id; ?>">
	<input type="hidden" name="customerlink" value="<?= $note->customerlink; ?>">
	<input type="hidden" name="shiptolink" value="<?= $note->shiptolink; ?>">
	<input type="hidden" name="contactlink" value="<?= $note->contactlink; ?>">
	<input type="hidden" name="salesorderlink" value="<?= $note->salesorderlink; ?>">
	<input type="hidden" name="quotelink" value="<?= $note->quotelink; ?>">

	<table class="table table-bordered table-striped">
		<tr>
			<td>Note Create Date: </td>
			<td><?= date('m/d/Y g:i A'); ?></td>
		</tr>
		<tr>
			<td>Assigned To: </td>
			<td><?= $editactiondisplay->generate_selectsalesperson($note->assignedto); ?></td>
		</tr>
		<tr>
			<td>Note Type <br> <small>(Click to Choose)</small></td>
			<td><?= $editactiondisplay->generate_selectsubtype($note); ?></td>
		</tr>
		<?php if (!empty($note->customerlink)) : ?>
			<tr>
				<td>Customer: </td>
				<td>
					<?= Customer::get_customernamefromid($note->customerlink). " ($note->customerlink)"; ?> &nbsp;
					<a href="<?= $editactiondisplay->generate_customerURL($note); ?>"><i class="glyphicon glyphicon-share"></i> Go to Customer Page</a>
				</td>
			</tr>
			<?php if (!empty($note->shiptolink)) : ?>
				<tr>
					<td>Ship-to: </td>
					<td><a href="<?= $editactiondisplay->generate_shiptourl($note); ?>"><?= Customer::get_customernamefromid($note->customerlink, $note->shiptolink). " ($note->shiptolink)"; ?></a></td>
				</tr>
			<?php endif; ?>
			<?php if (!empty($note->contactlink)) : ?>
				<tr>
					<td>Contact: </td>
					<td><?= $note->contactlink; ?></td>
				</tr>
			<?php endif; ?>
		<?php endif; ?>
		<?php if (!empty($note->salesorderlink)) : ?>
			<tr>
				<td>Sales Order #: </td>
				<td><?= $note->salesorderlink; ?>/td>
			</tr>
		<?php endif; ?>
		<?php if (!empty($note->quotelink)) : ?>
			<tr>
				<td>Quote #: </td>
				<td><?= $note->quotelink; ?>/td>
			</tr>
		<?php endif; ?>
		<tr>
			<td class="control-label">Title</td>
			<td><input type="text" name="title" class="form-control" value="<?= $note->title; ?>"></td>
		</tr>
		<tr>
			<td colspan="2">
				<label class="control-label">Notes</label> <br>
				<textarea name="textbody" id="note" rows="10" cols="30" class="form-control">
					<?= $note->textbody; ?>
				</textarea>
			</td>
		</tr>
	</table>
	<button type="submit" class="btn btn-success">
		<i class="glyphicon glyphicon-floppy-disk"></i> Save Changes
	</button>
</form>
