<div class="text-center form-group hidden-xs">
	<div class="btn-group" role="group" aria-label="View Order Attachments">
		<?php if ($quote->has_notes()) : ?>
			<a href="<?= $editquotedisplay->generate_request_dplusnotesURL($quote, 0); ?>" class="btn btn-default load-notes" title="View and Create Quote Notes" data-modal="<?= $editquotedisplay->modal; ?>">
				<i class="material-icons md-36" aria-hidden="true">&#xE0B9;</i> View and Create Quote Notes
			</a>
		<?php else : ?>
			<a href="<?= $editquotedisplay->generate_request_dplusnotesURL($quote, 0); ?>" class="btn btn-default load-notes" title="Create Quote Notes" data-modal="<?= $editquotedisplay->modal; ?>">
				<i class="material-icons md-36" aria-hidden="true">&#xE0B9;</i> Create Quote Notes
			</a>
		<?php endif; ?>
		<?php //echo $documentlink; ?>
	</div>
</div>
<div class="text-center form-group hidden-sm hidden-md hidden-lg">
	<div class="btn-group-vertical" role="group" aria-label="View Order Attachments">
		<?php if ($quote->has_notes()) : ?>
			<a href="<?= $editquotedisplay->generate_request_dplusnotesURL($quote, 0); ?>" class="btn btn-default load-notes" title="View and Create Quote Notes" data-modal="<?= $editquotedisplay->modal; ?>">
				<i class="material-icons md-36" aria-hidden="true">&#xE0B9;</i> View and Create Quote Notes
			</a>
		<?php else : ?>
			<a href="<?= $editquotedisplay->generate_request_dplusnotesURL($quote, 0); ?>" class="btn btn-default load-notes" title="Create Quote Notes" data-modal="<?= $editquotedisplay->modal; ?>">
				<i class="material-icons md-36" aria-hidden="true">&#xE0B9;</i> Create Quote Notes
			</a>
		<?php endif; ?>
		<?php //echo $documentlink; ?>
	</div>
</div>
