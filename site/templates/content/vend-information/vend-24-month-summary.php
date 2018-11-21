<?php
	$summaryfile = $config->jsonfilepath.session_id()."-vimonthsum.json";
	// $summaryfile = $config->jsonfilepath."vimthv-vimonthsum.json";

    if ($config->ajax) {
		echo $page->bootstrap->create_element('p', '', $page->bootstrap->generate_printlink($config->filename, 'View Printable Version'));
	}

?>

<?php if (file_exists($summaryfile)) : ?>
	<?php $summaryjson = json_decode(file_get_contents($summaryfile), true);  ?>
	<?php if (!$summaryjson) { $summaryjson = array('error' => true, 'errormsg' => 'The Vendor 24-Month Summary JSON contains errors');} ?>
	<?php if ($summaryjson['error']) : ?>
		<div class="alert alert-warning" role="alert"><?php echo $summaryjson['errormsg']; ?></div>
	<?php else : ?>
		<?php $data = array_values($summaryjson['data']['monthsum']); ?>
		
		<h2>24-Month Data</h2>
		<table class= 'table table-striped table-bordered table-condensed table-excel' id='monthsum'>
			<thead>
				<?php foreach ($summaryjson['columns']['monthsum'] as $column) : ?>
					<?php $class = $config->textjustify[$column['headingjustify']]; ?>
					<th class="<?php echo $class; ?>">
						<?php echo $column['heading']; ?>
					</th>
				<?php endforeach; ?>
			</thead>
			<tbody>
				<?php $maxrows = count($summaryjson['data']['monthsum'])?>
				<?php for ($i = 1; $i < $maxrows; $i++) : ?>
					<tr>
						<?php foreach ($summaryjson['data']['monthsum'][$i] as $month) : ?>
							<?php $key = array_search($month, ($summaryjson['data']['monthsum'][$i])); ?>
							<?php $class = $config->textjustify[$summaryjson['columns']['monthsum'][$key]['datajustify']]; ?>
							<td class="<?php echo $class; ?>"><?php echo $month; ?></td>
						<?php endforeach; ?>
					</tr>
			<?php endfor; ?>
			</tbody>
		</table>
		
		</br>
		<h2>24-Month Graph</h2>
		<div id="24monthsummary"></div>

		<script>
			$(function() {
				wait(1000, function() {
                    new Morris.Line({
    					// ID of the element in which to draw the chart.
    					element: '24monthsummary',
    					// Chart data records -- each entry in this array corresponds to a point on
    					// the chart.
    					data: <?php echo json_encode($data); ?>,
    					// The name of the data record attribute that contains x-values.
    					xkey: 'month',
    					dateFormat: function (d) {
    						var ds = new Date(d);
    						return moment(ds).format('YYYY/MM/DD');
    					},
    					hoverCallback: function (index, options, content, row) {
    						var date = moment(row.month).format('YYYY/MM/DD');
    						var hover = '<b>'+date+'</b><br>';
    						hover += '<b>Receipt Amt: </b> $' + row.receiptamount+'<br>';
    						hover += '<b>Invoice Amt: </b> $' + row.invoiceamount+'<br>';
    						hover += '<b>Receipt #: </b> ' + row.receiptnumber+'<br>';
    						hover += '<b>Invoice #: </b> ' + row.invoicenumber+'<br>';
    						return hover;
    					},
    					xLabels: 'month',
    					// A list of names of data record attributes that contain y-values.
    					ykeys: ['receiptamount'],
    					// Labels for the ykeys -- will be displayed when you hover over the
    					// chart.
    					labels: ['Amount'],
    					xLabelFormat: function (x) { return  moment(x).format('YYYY/MM/DD'); },
    					yLabelFormat: function (y) { return "$ "+y.formatMoney() + ' dollars'; },
    				});
                });
			});
		</script>
	<?php endif; ?>
<?php else : ?>
	<div class="alert alert-warning" role="alert">Information Not Available</div>
<?php endif; ?>
