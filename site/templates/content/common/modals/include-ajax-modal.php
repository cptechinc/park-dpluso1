<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="ajax-modal-label"><?= html_entity_decode($page->title); ?></h4>
    </div>
    <div class="modal-body">
        <div>
        	<?php include $page->body; ?>
		</div>
    </div>
</div>
