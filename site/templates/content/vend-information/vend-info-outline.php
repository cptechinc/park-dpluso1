<?php
	$vendjson = json_decode(file_get_contents($config->jsonfilepath.session_id()."-vivendor.json"), true);
?>
<?php if ($vendjson['error']) : ?>
	<div class="alert alert-warning">
		<?= $vendjson['errormsg']; ?>
	</div>
<?php else : ?>
	<div class="row">
		<div class="col-sm-2">
			<?php include $config->paths->content.'vend-information/vi-buttons.php'; ?>
		</div>
		<div class="col-sm-10">
			<div class="row">
				<div class="col-sm-6">
					<table class="table table-striped table-bordered table-condensed table-excel">
					<?php $topcolumns = array_keys($vendjson['columns']['top']); ?>
					<?php foreach ($topcolumns as $column ) : ?>
						<?php if ($vendjson['columns']['top'][$column]['heading'] == '' && $vendjson['data']['top'][$column] == '') : ?>
						<?php else : ?>
							<tr>
								<td class="<?= $config->textjustify[$vendjson['columns']['top'][$column]['headingjustify']]; ?>">
									<?php echo $vendjson['columns']['top'][$column]['heading']; ?>
								</td>
								<td>
									<?php
										if ($column == 'vendorid') {
											include $config->paths->content."vend-information/forms/vend-page-form.php";
										} else {
											echo $vendjson['data']['top'][$column];
										}
									?>
								</td>
							</tr>
						<?php endif; ?>
					<?php endforeach; ?>
					</table>
					<table class="table table-striped table-bordered table-condensed table-excel">
						<?php $leftcolumns = array_keys($vendjson['columns']['left']); ?>
						<?php foreach ($leftcolumns as $column) : ?>
							<?php if ($vendjson['columns']['left'][$column]['heading'] == '' && $vendjson['data']['left'][$column] == '') : ?>
							<?php else : ?>
								<tr>
									<td class="<?= $config->textjustify[$vendjson['columns']['left'][$column]['headingjustify']]; ?>">
										<?php echo $vendjson['columns']['left'][$column]['heading']; ?>
									</td>
									<td>
										<?php echo $vendjson['data']['left'][$column]; ?>
									</td>
								</tr>
							<?php endif; ?>
						<?php endforeach; ?>
					</table>
				</div>
				<div class="col-sm-6">
					<table class="table table-striped table-bordered table-condensed table-excel">
						<?php $rightsection = array_keys($vendjson['columns']['right']); ?>
						<?php foreach ($rightsection as $section) : ?>
							<?php if ($section != 'misc') : ?>
								<tr>
									<?php foreach ($vendjson['columns']['right'][$section] as $column) : ?>
										<th class="<?= $config->textjustify[$column['headingjustify']]; ?>">
											<?php echo $column['heading']; ?>
										</th>
									<?php endforeach; ?>
								</tr>

								<?php $rows = array_keys($vendjson['data']['right'][$section] ); ?>
								<?php foreach ($rows as $row) : ?>
									<tr>
										<?php $columns = array_keys($vendjson['data']['right'][$section][$row]); ?>
										<?php foreach ($columns as $column) : ?>
											<td class="<?= $config->textjustify[$vendjson['columns']['right'][$section][$column]['datajustify']]; ?>">
												<?php echo $vendjson['data']['right'][$section][$row][$column]; ?>
											</td>
										<?php endforeach; ?>
									</tr>
								<?php endforeach; ?>
								<tr class="last-section-row"> <td>&nbsp;</td> <td>&nbsp;</td> <td>&nbsp;</td> </tr>
							<?php endif; ?>
						<?php endforeach; ?>
						
						<?php $misccolumns = array_keys($vendjson['data']['right']['misc']); ?>
						<?php foreach ($misccolumns as $misc) : ?>
							<?php if ($misc != 'rfml') : ?>
								<tr>
									<td class="<?= $config->textjustify[$vendjson['columns']['right']['misc'][$misc]['headingjustify']]; ?>">
										<?php echo $vendjson['columns']['right']['misc'][$misc]['heading']; ?>
									</td>
									<td class="<?= $config->textjustify[$vendjson['columns']['right']['misc'][$misc]['datajustify']]; ?>">
										<?php echo $vendjson['data']['right']['misc'][$misc]; ?>
									</td>
									<td></td>
								</tr>
							<?php endif; ?>
						<?php endforeach; ?>
					</table>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>
