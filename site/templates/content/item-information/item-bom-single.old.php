<?php
	$bomfile = $config->jsonfilepath.session_id()."-iibomsingle.json";
	//$bomfile = $config->jsonfilepath."iiboms-iibomsingle.json";
	
	if ($config->ajax) {
		echo $page->bootstrap->create_element('p', '', $page->bootstrap->generate_printlink($config->filename, 'View Printable Version'));
	}
?>
<?php if (file_exists($bomfile)) : ?>
	<?php $bomjson = json_decode(file_get_contents($bomfile), true);  ?>
	<?php if (!$bomjson) { $bomjson = array('error' => true, 'errormsg' => 'The BOM Item Inquiry Single JSON contains errors');} ?>

	<?php if ($bomjson['error']) : ?>
		<div class="alert alert-warning" role="alert"><?php echo $bomjson['errormsg']; ?></div>
	<?php else : ?>
		<?php $componentcolumns = array_keys($bomjson['columns']['component']); ?>
		<?php $warehousecolumns = array_keys($bomjson['columns']['warehouse']); ?>
		<p><b>Kit Qty:</b> <?php echo $bomjson['qtyneeded']; ?></p>
		<?php foreach ($bomjson['data']['component'] as $component) : ?>
			<h3><?php echo $component['component item']; ?></h3>
			<table class="table table-striped table-bordered table-condensed table-excel no-bottom">
				<thead>
					<tr>
						<?php foreach($bomjson['columns']['component'] as $column) : ?>
							<th class="<?= $config->textjustify[$column['headingjustify']]; ?>"><?php echo $column['heading']; ?></th>
						<?php endforeach; ?>
					</tr>
				</thead>
				<tbody>
					<tr>
						<?php foreach ($componentcolumns as $column) : ?>
							<td class="<?= $config->textjustify[$bomjson['columns']['component'][$column]['datajustify']]; ?>"><?php echo $component[$column]; ?></td>
						<?php endforeach; ?>
					</tr>
				</tbody>
			</table>
			<table class="table table-striped table-bordered table-condensed table-excel">
				<thead>
					<tr>
						<?php foreach($bomjson['columns']['warehouse'] as $column) : ?>
							<th class="<?= $config->textjustify[$column['headingjustify']]; ?>"><?php echo $column['heading']; ?></th>
						<?php endforeach; ?>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($component['warehouse'] as $whse) : ?>
						<tr>
							<?php foreach ($warehousecolumns as $column) : ?>
								<td class="<?= $config->textjustify[$bomjson['columns']['warehouse'][$column]['datajustify']]; ?>"><?php echo $whse[$column]; ?></td>
							<?php endforeach; ?>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		<?php endforeach; ?>
		<p>
			<b>Warehouses that meet the Requirement: </b>
			<?php foreach ($bomjson['data']['whse meeting req'] as $whse => $name) : ?>
				<?= $name; ?> &nbsp;
			<?php endforeach; ?>
		</p>
	<?php endif; ?>
<?php else : ?>
	<div class="alert alert-warning" role="alert">Information Not Available</div>
<?php endif; ?>
