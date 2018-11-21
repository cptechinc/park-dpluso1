<div id="function-toolbar" style="padding: 10px 60px 10px 10px;">
	<div class="btn-group-vertical" role="group" aria-label="item-information-functions">
		<?php foreach ($buttonsjson['data'] as $button) : ?>
			<button class="btn btn-default btn-sm" onClick="<?php echo $button['function'].'()'; ?>"><?php echo $button['label']; ?></button>
		<?php endforeach; ?>
	</div>
</div>
