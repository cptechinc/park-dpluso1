<form action="<?= $input->get->text('printurl'); ?>" method="post" id="email-file-form">
    <input type="hidden" name="action" value="email-file-form">
    <div class="row">
        <div class="col-sm-6 form-group">
            <label for="self-bcc">Send Bcc to you?</label>
            <input type="checkbox" name="self-bcc" id="self-bcc" class="check-toggle" data-size="small" data-width="73px" value="Y">
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 form-group">
            <label for="email-recipient">Recipient Name</label>
            <div class="input-group">
                <input type="text" class="form-control" name="name" id="email-recipient" value="<?= $contact; ?>">
                <div class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></div>
            </div>
        </div>
        <div class="col-sm-6 form-group">
            <label for="email-email">Email Address</label>
            <div class="input-group">
                <div class="input-group-addon">@</div>
                <input type="text" class="form-control" name="email" id="email-email" value="<?= $email; ?>">
            </div>
        </div>
    </div>
    
    <div class="form-group">
        <label for="email-subject">Subject</label>
        <input type="text" class="form-control" name="subject" id="email-subject" value="<?= urldecode($input->get->text('subject')); ?>">
    </div>
    
    <div class="form-group">
        <label for="email-message">Message <small>(Not Required)</small></label>
        <textarea name="message" class="form-control" id="email-message"></textarea>
    </div>
    <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-envelope" aria-hidden="true"></i> Send Email</button>
</form>
<div id="show-email-sending" class="hidden">
    <div class="text-center">
        <i class="fa fa-spinner  fa-5x fa-fw"></i>
        <h4></h4>
    </div>
</div>
<script>
	$(function() {
		$('.check-toggle').bootstrapToggle({on: 'Yes', off: 'No', onstyle: 'info' });
	});
</script>
