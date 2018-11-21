<table class="table table-striped table-bordered table-condensed">
	<tr>
		<td colspan="2" class="text-center"><h4>Credit Card <span class="credit-img"></h4>  </span></td>
	</tr>
	<tr>
		<td class="control-label">Card Number</td>
		<td>
			<div class="input-group creditcard pull-right">
				<input id="cardnumber" name="creditcard" type="tel" class="form-control ordrhed input-sm text-right" value="<?= $creditcard->cardnumber; ?>" placeholder="XXXX XXXX XXXX XXXX"> 
				<span class="input-group-addon input-sm"><i class="glyphicon glyphicon-credit-card"></i></span>
			</div>
			<p class="help-block" id="credit-status"></p>
		</td>
	</tr>
	<tr>
		<td class="control-label">Expiration date MM/YYYY</td>
		<td>
			<input type="tel" class="form-control input-sm text-right pull-right expiredate" name="xpd" id="expire" value="<?= $creditcard->expiredate; ?>" placeholder="01/2018" />
		</td>
		<p class="help-block" id="expire-status"></p>
	</tr>
	<tr>
		<td class="control-label">CCV</td>
		<td>
        	<input type="tel" class="form-control text-right pull-right input-sm qty" name="ccv" id="cvv" value="<?= $creditcard->cardcode; ?>" />
		</td>
	</tr>
</table>
