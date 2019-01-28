<?php if (isset($_SESSION['shipID']) && $_SESSION['shipID'] != '' && $_SESSION['custID'] == $order->custid) : ?>
	<?php $shiptoid = $_SESSION['shipID']; ?>
<?php else : ?>
    <?php $shiptoid = $order->shiptoid; ?>
<?php endif ;?>

<legend>Ship-To</legend>
<?php if (100 == 1) : ?>
	<div class="form-group">
		<button type="button" class="btn btn-block btn-primary" id="load-shiptos">Load This Customer's Ship-tos</button>
	</div>
<?php endif; ?>

<table class="table table-striped table-bordered table-condensed">
	<tr>
    	<td class="control-label"><?= $formconfig->fields['fields']['shiptoid']['label']; ?><?= $formconfig->generate_asterisk('shiptoid'); ?><input type="hidden" id="shipto-id" value="<?= $order->shiptoid; ?>"></td>
        <td>
        	<select class="form-control input-sm ordrhed <?= $formconfig->generate_showrequiredclass('shiptoid'); ?> shipto-select" name="shiptoid" data-custid="<?= $order->custid; ?>">
				<?php $shiptos = get_customershiptos($order->custid); ?>
                <?php foreach ($shiptos as $shipto) : ?>
                    <?php if ($order->shiptoid == $shipto->shiptoid) : ?>
                        <option value="<?= $order->shiptoid; ?>" selected><?= $order->shiptoid.' - '.$order->shipname; ?></option>
                    <?php else : ?>
                        <option value="<?= $shipto->shiptoid;?>"><?= $shipto->shiptoid.' - '.$shipto->name; ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
                <option value="">Drop Ship To </option>
            </select>
        </td>
    </tr>
    <tr>
    	<td class="control-label"><?= $formconfig->fields['fields']['shipname']['label']; ?><?= $formconfig->generate_asterisk('shipname'); ?></td>
    	<td><input type="text" class="form-control input-sm ordrhed <?= $formconfig->generate_showrequiredclass('shipname'); ?> shipto-name" name="shiptoname" value="<?= $order->shipname; ?>"></td>
    </tr>
    <tr>
    	<td class="control-label"><?= $formconfig->fields['fields']['shipaddress']['label']; ?><?= $formconfig->generate_asterisk('shipaddress'); ?></td>
    	<td><input type="text" class="form-control input-sm ordrhed <?= $formconfig->generate_showrequiredclass('shipaddress'); ?> shipto-address" name="shipto-address" value="<?= $order->shipaddress; ?>"></td>
    </tr>
    <tr>
    	<td class="control-label"><?= $formconfig->fields['fields']['shipaddress2']['label']; ?><?= $formconfig->generate_asterisk('shipaddress2'); ?></td>
    	<td><input type="text" class="form-control input-sm ordrhed <?= $formconfig->generate_showrequiredclass('shipaddress2'); ?> shipto-address2" name="shipto-address2" value="<?= $order->shipaddress2; ?>"></td>
    </tr>
    <tr>
    	<td class="control-label"><?= $formconfig->fields['fields']['shipcity']['label']; ?><?= $formconfig->generate_asterisk('shipcity'); ?></td>
    	<td><input type="text" class="form-control input-sm ordrhed <?= $formconfig->generate_showrequiredclass('shipcity'); ?> shipto-city" name="shipto-city" value="<?= $order->shipcity; ?>"></td>
    </tr>
    <tr>
    	<td class="control-label"><?= $formconfig->fields['fields']['shipstate']['label']; ?><?= $formconfig->generate_asterisk('shipstate'); ?></td>
    	<td>
        	<select class="form-control input-sm ordrhed <?= $formconfig->generate_showrequiredclass('shipstate'); ?> shipto-state" name="shipto-state">
            <option value="">---</option>
				<?php $states = get_states(); ?>
                <?php foreach ($states as $state) : ?>
                    <?php if ($state['state'] == $order->shipstate) { $selected = 'selected'; } else { $selected = ''; } ?>
                    <option value="<?= $state['state']; ?>" <?= $selected; ?>><?= $state['state'] . ' - ' . $state['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </td>
    </tr>
    <tr>
    	<td class="control-label"><?= $formconfig->fields['fields']['shipzip']['label']; ?><?= $formconfig->generate_asterisk('shipzip'); ?></td>
    	<td><input type="text" class="form-control input-sm <?= $formconfig->generate_showrequiredclass('shipzip'); ?> shipto-zip" name="shipto-zip" value="<?= $order->shipzip; ?>"></td>
    </tr>
	<tr>
		<td class="control-label">Country</td>
		<td>
			<?php $countries = get_countries(); if (empty($order->shipcountry)) {$order->set('shipcountry', 'USA');}?>
			<select name="shipto-country" class="form-control input-sm">
				<?php foreach ($countries as $country) : ?>
					<?php $selected = ($country['ccode'] == $order->shipcountry) ? 'selected' : ''; ?>
					<option value="<?= $country['ccode']; ?>" <?= $selected; ?>><?= $country['name']; ?></option>
				<?php endforeach; ?>
			</select>
		</td>
	</tr>
</table>
