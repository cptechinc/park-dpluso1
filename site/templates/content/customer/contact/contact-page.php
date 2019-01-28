<div class="form-group">
	<a href="<?= $contact->generate_customerURL(); ?>" class="btn btn-primary"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Go To <?= $contact->get_customername()."'s"; ?> Page </a>
</div>
<div class="row">
	<div class="col-sm-12 form-group">
		<?php include $config->paths->content.'customer/contact/contact-card.php'; ?>
	</div>
	<div class="col-sm-12">
		<?php $actionpanel = new Dplus\Dpluso\UserActions\ContactActionsPanel(session_id(), $page->fullURL, $input); ?>
		<?php $actionpanel->set_contact($contact->custid, $contact->shiptoid, $contact->contact); ?>
		<?php include $config->paths->content."user-actions/user-actions-panel.php"; ?>
	</div>
</div>
