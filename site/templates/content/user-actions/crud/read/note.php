<?php
	// $note is loaded by Crud Controller
	$notedisplay = new Dplus\Dpluso\UserActions\UserActionDisplay($page->fullURL);
	$contact = Contact::load($note->customerlink, $note->shiptolink, $note->contactlink);
?>

<div>
	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#note" aria-controls="note" role="tab" data-toggle="tab">Note ID: <?= $note->id; ?></a></li>
	</ul>
	<br>
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="note">
			<?php if ($config->ajax) : ?>
				<?= $page->bootstrap->create_element('p', '', $page->bootstrap->generate_printlink($config->filename, 'View Printable Version')); ?>
			<?php endif; ?>
			<?php include $config->paths->content."user-actions/crud/read/note-details.php"; ?>
		</div>
	</div>
</div>
