<script>
	$(function() {
		<?php foreach ($ordersjson['data'] as $whse) : ?>
			<?php if ($whse != $ordersjson['data']['zz'] && $formatterjson['detail']['rows'] < 2) : ?>
				$('<?= '#'.$whse['Whse Name']; ?>').DataTable();
			<?php endif; ?>
		<?php endforeach; ?>
	});
</script>
