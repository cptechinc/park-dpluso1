<?php $custID = $input->get->text('custID'); ?>
<?php $vendors = get_vendors(false); ?>
<?php if ($appconfig->show_vendorinfononstock) : ?>
	<h3>Choose Vendor</h3>
	<div class="table-responsive">
		<table class="table table-bordered table-condensed" id="vendors-table">
			<thead>
				<tr>
					<th>VendorID</th> <th>Name</th> <th>Address1</th> <th>Address2</th> <th>Address3</th> <th>City, State Zip</th> <th>Country</th> <th>Phone</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($vendors as $vendor) : ?>
					<tr id="tr-<?= $vendor->vendid; ?>">
						<td><button class="btn btn-sm btn-primary" onClick="choosevendor('<?= $vendor->vendid; ?>')"><?= $vendor->vendid; ?></button></td>
						<td class="name"><?= $vendor->name; ?></td>
						<td><?= $vendor->address1; ?></td>
						<td><?= $vendor->address2; ?></td>
						<td><?= $vendor->address3; ?></td>
						<td><?= $vendor->city.', '.$vendor->state.' '.$vendor->zip; ?></td>
						<td><?= $vendor->country; ?></td>
						<td><?= $vendor->phone; ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
<?php endif; ?>

<h3>Item Details</h3>
<div class="row">
	<div class="col-sm-10">
		<form action="<?= $formaction; ?>" method="post">
			<input type="hidden" name="action" value="add-nonstock-item">
			<input type="hidden" name="custID" value="<?= $custID; ?>">
			<?php if ($addtype == 'sales-order') : ?>
				<input type="hidden" name="ordn" value="<?= $ordn; ?>">
			<?php elseif ($addtype == 'quote') : ?>
				<input type="hidden" name="qnbr" value="<?= $qnbr; ?>">
			<?php endif; ?>
			<?php if ($input->get->page) : ?>
				<input type="hidden" name="page" value="<?= $input->get->text('page'); ?>">
			<?php endif; ?>
			<table class="table table-condensed table-bordered table-striped">
				<tr class="<?= $appconfig->show_vendorinfononstock ? '' : 'hidden'; ?>">
					<td class="control-label">Vend ID:</td>
					<td>
						<input type="hidden" class="required" id="vendorID" name="vendorID">
						<p class="form-control-static" id="vendortext"></p>
					</td>
				</tr>
				<tr class="<?= $appconfig->show_vendorinfononstock ? '' : 'hidden'; ?>">
					<td class="control-label">Ship From</td>
					<td> <select class="form-control input-sm" name="shipfromID" id="shipfrom"> <option value="n/a">Choose a Vendor</option> </select> </td>
				</tr>
				<tr>
					<td class="control-label">Item ID</td>
					<td> <input type="text" class="form-control input-sm required" name="itemID"> </td>
				</tr>
				<tr>
					<td class="control-label">Description1</td>
					<td> <input type="text" class="form-control input-sm required" name="desc1"> </td>
				</tr>
				<tr>
					<td class="control-label">Description2</td>
					<td> <input type="text" class="form-control input-sm" name="desc2"> </td>
				</tr>
				<tr>
					<td class="control-label">Qty</td>
					<td> <input type="text" class="form-control input-sm qty" name="qty"> </td>
				</tr>
				<tr>
					<td class="control-label">Price</td>
					<td>
						<div class="pull-right">
							<div class="input-group">
								<div class="input-group-addon input-sm">$</div>
								<input type="text" class="form-control input-sm text-right price" name="price">
							</div>
						</div>
					</td>
				</tr>
				<tr class="<?= $appconfig->show_vendorinfononstock ? '' : 'hidden'; ?>">
					<td class="control-label">Cost</td>
					<td>
						<div class="pull-right">
							<div class="input-group">
								<div class="input-group-addon input-sm">$</div>
								<input type="text" class="form-control input-sm text-right price" name="cost">
							</div>
						</div>
					</td>
				</tr>
				<tr class="<?= $appconfig->show_vendorinfononstock ? '' : 'hidden'; ?>">
					<td class="control-label">Unit of Measurement</td>
					<td>
						<?php $measurements = get_unitofmeasurements(false); ?>
						<select name="uofm" class="form-control input-sm">
							<?php foreach ($measurements as $measurement) : ?>
								<option value="<?= $measurement['code']; ?>"><?= $measurement['desc']; ?></option>
							<?php endforeach; ?>
						</select>
					</td>
				</tr>
				<tr class="<?= $appconfig->show_vendorinfononstock ? '' : 'hidden'; ?>">
					<td class="control-label">Group</td>
					<td>
						<?php $groups = get_itemgroups(false); ?>
						<select name="itemgroup" class="form-control input-sm">
							<option value="">None</option>
							<?php foreach ($groups as $group) : ?>
								<option value="<?= $group['code']; ?>"><?= $group['desc']; ?></option>
							<?php endforeach; ?>
						</select>
					</td>
				</tr>
				<tr class="<?= $appconfig->show_vendorinfononstock ? '' : 'hidden'; ?>">
					<td class="control-label">PO Nbr</td> <td><input type="text" class="form-control input-sm" name="ponbr"></td>
				</tr>
				<tr class="<?= $appconfig->show_vendorinfononstock ? '' : 'hidden'; ?>">
					<td class="control-label">Reference</td> <td><input type="text" class="form-control input-sm" name="poref"></td>
				</tr>
			</table>
			<button type="submit" class="btn btn-default">Submit</button>
		</form>
	</div>
</div>


<script>
	$(function() {
		$('#vendors-table').DataTable();
		$('#vendorID').change(function(){
			var vendorID = $(this).val();
			var url = config.urls.json.vendorshipfrom + '?vendorID=' + urlencode(vendorID);
			console.log(url);
			$('#shipfrom option').remove();
			$.getJSON(url, function( json ) {
				if (json.response.shipfroms.length) {
					$('<option value="n/a">Choose A Ship-from</option>').appendTo('#shipfrom');
					$('<option value="n/a">None</option>').appendTo('#shipfrom');
					$.each( json.response.shipfroms, function( key, shipfrom ) {
						$('<option value="'+shipfrom.shipfrom+'">'+shipfrom.name+'</option>').appendTo('#shipfrom');
					});
				} else {
					$('<option value="N/A">No Ship-froms found</option>').appendTo('#shipfrom');
				}
			});
		})
	});

	function choosevendor(vendorID) {
		$('#vendors-table_filter input').val(vendorID).keyup();
		$('#vendorID').val(vendorID).change();
		$('#vendortext').text($('#tr-'+vendorID).find('.name').text());
	}
</script>
