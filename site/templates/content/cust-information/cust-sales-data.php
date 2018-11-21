<?php
	$salesfile = $config->jsonfilepath.session_id()."-ci53weeks.json";
	//$salesfile = $config->paths->templates."json/test-cust-sales.json";

	$href = $config->pages->ajax.'load/ci/ci-53weeks/?custID='.urlencode($custID);
	if ($page->name == 'cust-info') {
		echo $page->bootstrap->create_element('p', '', $page->bootstrap->generate_printlink($href, 'View Printable Version'));
	}
?>

<?php if (file_exists($salesfile)) : ?>
	<?php $salesjson = json_decode(file_get_contents($salesfile), true);  ?>
	<?php if (!$salesjson) { $salesjson = array('error' => true, 'errormsg' => 'The customer shiptos Inquiry Single JSON contains errors');} ?>
	<?php if ($salesjson['error']) : ?>
		<div class="alert alert-warning" role="alert"><?php echo $salesjson['errormsg']; ?></div>
	<?php else : ?>
		<?php $data = array_values($salesjson['data']); ?>
		<h2><?= Customer::get_customernamefromid($custID); ?> 52 Week Sales Data</h2>

		<div id="salesdata"></div>

		<script>
			$(function() {
				new Morris.Line({
					// ID of the element in which to draw the chart.
					element: 'salesdata',
					// Chart data records -- each entry in this array corresponds to a point on
					// the chart.
					data: <?php echo json_encode($data); ?>,
					// The name of the data record attribute that contains x-values.
					xkey: 'weekstartdate',
					dateFormat: function (d) {
						var ds = new Date(d);
						return moment(ds).format('MM/DD/YYYY');
					},
					hoverCallback: function (index, options, content, row) {
						var date = moment(row.weekstartdate).format('MM/DD/YYYY');
						var hover = '<b>'+date+'</b><br>';
						hover += '<b>Amt Sold: </b> $' + row.saleamount.formatMoney()+'<br>';
						if (user.permissions.show_cost) {
							hover += '<b>Cost Amt: </b> $' + row.costamount.formatMoney()+'<br>';
						}
						hover += '<b># of Orders: </b> ' + row.nbroforders+'<br>';
						hover += '<b># of Items: </b> ' + row.nbrofitems+'<br>';
						return hover;
					},
					xLabels: 'day',
					// A list of names of data record attributes that contain y-values.
					ykeys: ['saleamount'],
					// Labels for the ykeys -- will be displayed when you hover over the
					// chart.
					labels: ['Amount'],
					xLabelFormat: function (x) { return  moment(x).format('MM/DD/YYYY'); },
					yLabelFormat: function (y) { return "$ "+y.formatMoney() + ' dollars'; },
				});
			});
		</script>
	<?php endif; ?>
<?php else : ?>
	<div class="alert alert-warning" role="alert">Information Not Available</div>
<?php endif; ?>
