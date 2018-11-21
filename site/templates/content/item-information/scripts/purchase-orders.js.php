<script>
	$(function() {
		<?php foreach ($purchasejson['data'] as $whse) : ?>
			<?php if ($whse != $purchasejson['data']['zz'] && $formatterjson['detail']['rows'] < 2) : ?>
				$('<?= '#'.$whse['Whse Name']; ?>').DataTable();
			<?php endif; ?>
		<?php endforeach; ?>
	});
</script>
