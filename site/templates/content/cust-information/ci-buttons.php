<div class="btn-group-vertical" role="group" aria-label="...">
	<?php foreach ($buttonsjson['data'] as $button) : ?>
		<button class="btn btn-default btn-sm" onClick="<?php echo $button['function'].'()'; ?>"><?php echo $button['label']; ?></button>
	<?php endforeach; ?>
</div>
