<?php
	$shiptofile = $config->jsonfilepath.session_id()."-cishiptoinfo.json";
	//$shiptofile = $config->jsonfilepath."cislist-cishiptolist.json";
 ?>

<?php if (file_exists($shiptofile)) : ?>
	<?php $shiptojson = json_decode(file_get_contents($shiptofile), true);  ?>
	<?php if (!$shiptojson) { $shiptojson = array('error' => true, 'errormsg' => 'The customer shiptos Inquiry Single JSON contains errors');} ?>
	<?php if ($shiptojson['error']) : ?>
		<div class="alert alert-warning" role="alert"><?php echo $shiptojson['errormsg']; ?></div>
	<?php else : ?>
			<div class="row">
				<div class="col-sm-6">
					<table class="table table-striped table-bordered table-condensed table-excel">
						<?php $topcolumns = array_keys($shiptojson['columns']['top']); ?>
						<?php foreach ($topcolumns as $column) : ?>
							<?php if ($shiptojson['columns']['top'][$column]['heading'] == '' && $shiptojson['data']['top'][$column] == '') : ?>
							<?php else : ?>
								<tr>
									<td> <?= $shiptojson['columns']['top'][$column]['heading']; ?></td>
									<td>
										<?php
											if ($column == 'customerid') {
												include $config->paths->content."cust-information/forms/cust-page-form.php";
											} else {
												echo $shiptojson['data']['top'][$column];
											}
										?>
									</td>
								</tr>
							<?php endif; ?>
						<?php endforeach; ?>
					</table>
				</div>
				<div class="col-sm-6">
					<table class="table table-striped table-bordered table-condensed table-excel">
						<?php $topcolumns = array_keys($shiptojson['columns']['top']); ?>
						<tbody>
							<?php foreach ($topcolumns as $column) : ?>
								<?php if ($shiptojson['columns']['top'][$column]['heading'] == '' && $shiptojson['data']['top'][$column] == '') : ?>
								<?php else : ?>
									<tr>
										<td> <?= $shiptojson['columns']['top'][$column]['heading']; ?></td> <td> <?= $shiptojson['data']['top'][$column]; ?></td>
									</tr>
								<?php endif; ?>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<table class="table table-striped table-bordered table-condensed table-excel">
						<?php $leftcolumns = array_keys($shiptojson['columns']['left']); ?>
						<tbody>
							<?php foreach ($leftcolumns as $column) : ?>
								<?php if ($shiptojson['columns']['left'][$column]['heading'] == '' && $shiptojson['data']['left'][$column] == '') : ?>
								<?php else : ?>
									<tr>
										<td class="<?= $config->textjustify[$shiptojson['columns']['left'][$column]['headingjustify']]; ?>">
											<?php echo $shiptojson['columns']['left'][$column]['heading']; ?>
										</td>
										<td>
											<?php echo $shiptojson['data']['left'][$column]; ?>
										</td>
									</tr>
								<?php endif; ?>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
				<div class="col-sm-6">
					<table class="table table-striped table-bordered table-condensed table-excel">
						<?php $sections = array('activity', 'saleshistory'); ?>
						<?php foreach ($sections as $section) : ?>
							<?php $columns = array_keys($shiptojson['columns']['right'][$section]); ?>
							<tr>
								<?php foreach ($shiptojson['columns']['right'][$section] as $column) : ?>
									<th class="<?= $config->textjustify[$column['headingjustify']]; ?>">
										<?php echo $column['heading']; ?>
									</th>
								<?php endforeach; ?>
							</tr>
							<?php $rows = array_keys($shiptojson['data']['right'][$section]); ?>
							<?php foreach ($rows as $row) : ?>
								<tr>
									<?php foreach ($columns as $column) : ?>
										<td class="<?= $config->textjustify[$shiptojson['columns']['right'][$section][$column]['datajustify']]; ?>">
											<?php echo $shiptojson['data']['right'][$section][$row][$column]; ?>
										</td>
									<?php endforeach; ?>
								</tr>
							<?php endforeach; ?>
						<?php endforeach; ?>
						<?php $misccolumns = array('rfml', 'dateentered', 'lastsaledate'); ?>
						<?php foreach ($misccolumns as $misc) : ?>
							<tr>
								<td class="<?= $config->textjustify[$shiptojson['columns']['right']['misc'][$misc]['headingjustify']]; ?>">
									<?php echo $shiptojson['columns']['right'][$misc]['heading']; ?>
								</td>
								<td class="<?= $config->textjustify[$shiptojson['columns']['right']['misc'][$misc]['datajustify']]; ?>">
									<?php echo $shiptojson['data']['right'][$misc]; ?>
								</td>
								<td></td>
							</tr>
						<?php endforeach; ?>
					</table>
				</div>
			</div>
	<?php endif; ?>
<?php else : ?>
	<div class="alert alert-warning" role="alert">Information Not Available</div>
<?php endif; ?>
