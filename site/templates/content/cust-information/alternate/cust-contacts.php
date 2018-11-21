<?php if ($config->ajax) : ?>
	<p> <a href="<?php echo $config->filename; ?>" target="_blank"><i class="glyphicon glyphicon-print" aria-hidden="true"></i> View Printable Version</a> </p>
<?php endif; ?>
<?php if (file_exists($contactfile)) : ?>
    <?php $contactjson = json_decode(file_get_contents($contactfile), true);  ?>
    <?php if (!$contactjson) { $contactjson = array('error' => true, 'errormsg' => 'The customer Contacts JSON contains errors');} ?>
    <?php if ($contactjson['error']) : ?>
        <div class="alert alert-warning" role="alert"><?php echo $contactjson['errormsg']; ?></div>
    <?php else : ?>
		<?php if (sizeof($contactjson['data']) > 0) : ?>
			<?php $customerleftcolumns = array_keys($contactjson['columns']['customer']['customerleft']); ?>
			<?php $customerrightcolumns = array_keys($contactjson['columns']['customer']['customerright']); ?>
			<?php $shiptoleftcolumns = array_keys($contactjson['columns']['shipto']['shiptoleft']); ?>
			<?php $shiptorightcolumns = array_keys($contactjson['columns']['shipto']['shiptoright']); ?>
			<?php $contactcolumns = array_keys($contactjson['columns']['contact']); ?>
			<?php $formscolumns = array_keys($contactjson['columns']['forms']); ?>
			
			<div class="row">
				<div class="col-sm-6">
					<table class="table table-striped table-bordered table-condensed table-excel">
						<?php foreach ($customerleftcolumns as $column) : ?>
							<tr>
								<td class="<?= $config->textjustify[$contactjson['columns']['customer']['customerleft'][$column]['headingjustify']]; ?>">
									<?php echo $contactjson['columns']['customer']['customerleft'][$column]['heading']; ?>
								</td>
								<td class="<?= $config->textjustify[$contactjson['columns']['customer']['customerleft'][$column]['headingjustify']]; ?>">
									<?php echo $contactjson['data']['customer']['customerleft'][$column]; ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</table>
				</div>
				<div class="col-sm-6">
					<table class="table table-striped table-bordered table-condensed table-excel">
						<?php foreach ($customerrightcolumns as $column) : ?>
							<tr>
								<td class="<?= $config->textjustify[$contactjson['columns']['customer']['customerright'][$column]['headingjustify']]; ?>">
									<?php echo $contactjson['columns']['customer']['customerright'][$column]['heading']; ?>
								</td>
								<td class="<?= $config->textjustify[$contactjson['columns']['customer']['customerright'][$column]['headingjustify']]; ?>">
									<?php echo $contactjson['data']['customer']['customerright'][$column]; ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</table>
				</div>
			</div>
			<hr>
			<h2>Ship-To Contact Info</h2>
			<?php foreach ($contactjson['data']['shipto'] as $shipto) : ?>
				<h3><?php echo $shipto['shiptoid'].' - '.$shipto['shiptoname']; ?></h3>
					
				<?php foreach ($shipto['shiptocontacts'] as $contact) : ?>
					<div class="row">
						<div class="col-sm-6">
							<table class="table table-striped table-bordered table-condensed table-excel">
								<?php foreach ($shiptoleftcolumns as $column) : ?>
									<tr>
										<td class="<?= $config->textjustify[$contactjson['columns']['shipto']['shiptoleft'][$column]['headingjustify']]; ?>">
											<?php echo $contactjson['columns']['shipto']['shiptoleft'][$column]['heading']; ?>
										</td>
										<td class="<?= $config->textjustify[$contactjson['columns']['shipto']['shiptoleft'][$column]['headingjustify']]; ?>">
											<?php echo $contact['shiptoleft'][$column]; ?>
										</td>
									</tr>
								<?php endforeach; ?>
							</table>
						</div>
						<div class="col-sm-6">
							<table class="table table-striped table-bordered table-condensed table-excel">
								<?php foreach ($shiptorightcolumns as $column) : ?>
									<tr>
										<td class="<?= $config->textjustify[$contactjson['columns']['shipto']['shiptoright'][$column]['headingjustify']]; ?>">
											<?php echo $contactjson['columns']['shipto']['shiptoright'][$column]['heading']; ?>
										</td>
										<td class="<?= $config->textjustify[$contactjson['columns']['shipto']['shiptoright'][$column]['headingjustify']]; ?>">
											<?php echo $contact['shiptoright'][$column]; ?>
										</td>
									</tr>
								<?php endforeach; ?>
							</table>
						</div>
					</div>
				<?php endforeach; ?>

			<?php endforeach; ?>
			
			<h2>Customer Contact Info</h2>
			<table class="table table-striped table-bordered table-condensed table-excel">
				<thead>
					<tr>
						<?php foreach ($contactcolumns as $column) : ?>
							<th class="<?= $config->textjustify[$contactjson['columns']['contact'][$column]['headingjustify']]; ?>">
								<?php echo $contactjson['columns']['contact'][$column]['heading']; ?>
							</th>
						<?php endforeach; ?>
					</tr>
				</thead>
					
				<?php foreach ($contactjson['data']['contact'] as $contact) : ?>
					<tbody>
						<tr>
							<td class="<?= $config->textjustify[$contactjson['columns']['contact']['contactname']['datajustify']]; ?>">
								<?php echo $contact['contactname']; ?>
							</td>
							<td class="<?= $config->textjustify[$contactjson['columns']['contact']['contactemail']['datajustify']]; ?>">
								<?php echo $contact['contactemail']; ?>
							</td>
							<td class="<?= $config->textjustify[$contactjson['columns']['contact']['contactnbr']['datajustify']]; ?>">
								<?php echo $contact['contactnumbers']["1"]['contactnbr']; ?>
							</td>
						</tr>
						<?php for ($i = 1; $i < sizeof($contact['contactnumbers']) + 1; $i++) : ?>
							<?php if ($i != 1) : ?>
								<tr>
									<td></td> <td></td>
									<td class="<?= $config->textjustify[$contactjson['columns']['contact']['contactnbr']['datajustify']]; ?>">
										<?php echo $contact['contactnumbers']["$i"]['contactnbr']; ?>
									</td>
								</tr>
							<?php endif; ?> 
						<?php endfor; ?>
					</tbody>
					
				<?php endforeach; ?>
			</table>
			
			
			<h2>Forms Information</h2>
				
				<table class="table table-striped table-bordered table-condensed table-excel">
					<thead>
						<tr>
							<?php foreach ($formscolumns as $column) : ?>
								<th class="<?= $config->textjustify[$contactjson['columns']['forms'][$column]['headingjustify']]; ?>">
									<?php echo $contactjson['columns']['forms'][$column]['heading']; ?>
								</th>
							<?php endforeach; ?>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($contactjson['data']['forms'] as $form) : ?>
							<tr>
								<?php foreach ($formscolumns as $column) : ?>
									<td class="<?= $config->textjustify[$contactjson['columns']['forms'][$column]['datajustify']]; ?>">
										<?php echo $form[$column]; ?>
									</td>
								<?php endforeach; ?>
							</tr>
						<?php endforeach; ?>
					</tbody>
					
				</table>
				
		<?php else : ?>
			 <div class="alert alert-warning" role="alert">Customer has no Contacts</div>
		<?php endif; ?>
		
    <?php endif; ?>
<?php else : ?>
    <div class="alert alert-warning" role="alert">Information Not Available</div>
<?php endif; ?>
