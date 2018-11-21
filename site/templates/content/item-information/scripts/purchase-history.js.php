<script>
	$(function() {
		<?php foreach ($historyjson['data'] as $whse) : ?>
			<?php if ($whse != $historyjson['data']['zz'] && $formatterjson['detail']['rows'] < 2) : ?>
				// $('<?= '#'.$whse['Whse Name']; ?>').DataTable();
			<?php endif; ?>
		<?php endforeach; ?>
	});
</script>
