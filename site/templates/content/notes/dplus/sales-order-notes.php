<?php
	//$qnbr = is defined in notes router
	//$linenbr is defined in notes-router
	$notes = get_qnotes(session_id(), $ordn, $linenbr, Qnote::get_qnotetype('sales-orders'), true); // TRUE is USE CLASS 
?>

<div class="panel panel-primary">
	<div class="panel-heading">
		<div class="row">
			<div class="col-sm-3 col-xs-2">Pick Ticket</div> <div class="col-sm-3 col-xs-2">Pack Ticket</div>
			<div class="col-sm-3 col-xs-2">Invoice</div> <div class="col-sm-3 col-xs-2">Acknowledgement</div>
		</div>
	</div>
	<ul class="list-group">
		<?php foreach ($notes as $note) : ?>
			<a href="<?= $note->generate_jsonurl();?>" class="list-group-item dplusnote rec<?= $note->recno; ?>" data-form="#notes-form">
				<div class="row">
					<div class="col-xs-2 col-sm-3"><?= $note->form1; ?></div> <div class="col-xs-2 col-sm-3"><?= $note->form2; ?></div>
					<div class="col-xs-2 col-sm-3"><?= $note->form3; ?></div> <div class="col-xs-2 col-sm-3"><?= $note->form4; ?></div>
				</div>
			</a>
		<?php endforeach; ?>
	</ul>
</div>
<div class="well">
	<form class="notes" action="<?= $config->pages->notes."redir/"; ?>" method="POST" id="notes-form">
		<div class="response"></div>
		<div class="row">
			<div class="form-group col-xs-6 col-sm-2">
				<label class="control-label">Pick Ticket</label><br>
				<input type="checkbox" name="form1" id="note1" class="check-toggle" data-size="small" data-width="73px" value="Y" <?= Qnote::generate_showchecked('quote', 'pickticket'); ?>>
			</div>
			<div class="form-group col-xs-6 col-sm-offset-1 col-sm-2">
				<label class="control-label">Pack Ticket</label><br>
				<input type="checkbox" name="form2" id="note2" class="check-toggle" data-size="small" data-width="73px" value="Y" <?= Qnote::generate_showchecked('quote', 'packticket'); ?>>
			</div>
			<div class="form-group col-xs-6 col-sm-offset-1 col-sm-2">
				<label class="control-label">Invoice</label><br>
				<input type="checkbox" name="form3" id="note3" class="check-toggle" data-size="small" data-width="73px" value="Y" <?= Qnote::generate_showchecked('quote', 'invoice'); ?>>
			</div>
			<div class="form-group col-xs-6 col-sm-offset-1 col-sm-2">
				<label class="control-label">Acknowledgement</label>
				<input type="checkbox" name="form4" id="note4" class="check-toggle" data-size="small" data-width="73px" value="Y" <?= Qnote::generate_showchecked('sales-orders', 'acknowledgement'); ?>>
			</div>
			<div class="form-group col-xs-6 col-sm-offset-1 col-sm-2 hidden">
				<label class="control-label">Acknowledgement</label>
				<input type="checkbox" name="form6" id="note5" class="check-toggle" data-size="small" data-width="73px" value="Y">
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 form-group">
				<label for="notes" class="control-label">Note: <span class="which"></span></label>
				<textarea class="form-control note" rows="3" cols="35" name="note" placeholder="Add a Note.." style="max-width: 35em;"></textarea>
				<input type="hidden" name="action" class="action" value="add-note">
				<input type="hidden" name="key1" class="key1"value="<?= $ordn; ?>">
				<input type="hidden" name="key2" class="key2" value="<?= $linenbr; ?>">
				<input type="hidden" name="type" class="type" value="<?= Qnote::get_qnotetype('sales-orders'); ?>">
				<input type="hidden" name="recnbr" class="recnbr" value="">
				<input type="hidden" name="notepage" class="notepage" value="<?= $config->filename; ?>">
				<span class="help-block"></span>
				<?php if (Qnote::can_write(session_id(), Qnote::get_qnotetype('sales-orders'), $ordn, $linenbr)) : ?>
					<button type="submit" id="submit-note" class="btn btn-success"><i class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></i> Save Changes</button>
					&nbsp; &nbsp;
					<?php if (100 == 1) : //TODO ?>
						<button type="button" id="delete-note" class="btn btn-danger" data-form="#notes-form"><i class="fa fa-trash" aria-hidden="true"></i> Delete Note</button>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		</div>
	</form>
</div>

<script>
	$(function() {
		$('.check-toggle').bootstrapToggle({on: 'Yes', off: 'No', onstyle: 'info' });
	});
</script>
