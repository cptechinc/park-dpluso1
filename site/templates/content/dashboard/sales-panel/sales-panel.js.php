<?php if (!(empty($page->has_salesdata))) : ?>
	<script>
		$(function() {
			var pie = Morris.Donut({
				element: 'cust-sales-graph',
				data: <?= json_encode($data); ?>,
				colors: <?= json_encode(array_rand(array_flip($config->allowedcolors), 25)); ?>
			});

			pie.options.data.forEach(function(label, i) {
				var index = i;
				if (pie.options.colors.length < 11) {
					if (index >= 10) {
						var multiply = parseInt(i / 10);
						var subtract = 10 * multiply;
						index = i - subtract;
					}
				}
				$('#cust-sales').find('#'+label['custid']+'-cust').css('backgroundColor', pie.options.colors[index]);
			});
		});
	</script>
<?php endif; ?>
