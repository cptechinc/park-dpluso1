<tr class="international <?= $hidden_intl; ?>">
    <td colspan="2" class="control-label"><h4>Office Phone</h4></td>
</tr>
<tr class="international <?= $hidden_intl; ?>">
    <td class="control-label">Access Code</td>
    <td> <input type="text" class="form-control input-sm" name="office-accesscode" size="3" value="<?= $office_phone_arr[0]; ?>"> </td>
</tr>
<tr class="international <?= $hidden_intl; ?>">
    <td class="control-label">Country Code</td>
    <td> <input type="text" class="form-control input-sm" name="office-countrycode" size="3" value="<?= $office_phone_arr[1]; ?>"> </td>
</tr>
<tr class="international <?= $hidden_intl; ?>">
    <td class="control-label">Phone</td>
    <td> <input type="text" class="form-control input-sm" name="intl-office" onKeyup='addDashes(this)' placeholder="952-888-1888" value="<?= $office_phone_arr[2]; ?>">  </td>
</tr>
<tr class="international <?= $hidden_intl; ?>">
    <td class="control-label">Ext.</td>
    <td> <input type="text" class="form-control input-sm" name="intl-office-ext" value="<?= $order->extension; ?>"> </td>
</tr>

<tr class="international <?= $hidden_intl; ?>">
    <td colspan="2" class="control-label"><h4>Fax</h4></td>
    <td></td>
</tr>
<tr class="international <?= $hidden_intl; ?>">
    <td class="control-label">Access Code</td>
    <td> <input type="text" class="form-control input-sm" name="fax-accesscode" size="3" value="<?= $fax_phone_arr[0]; ?>"> </td>
</tr>
<tr class="international <?= $hidden_intl; ?>">
    <td class="control-label">Country Code</td>
    <td> <input type="text" class="form-control input-sm"  name="fax-countrycode" size="3" value="<?= $fax_phone_arr[1]; ?>"> </td>
</tr>

<tr class="international <?= $hidden_intl; ?>">
    <td class="control-label">Phone</td>
    <td>  <input type="text" class="form-control input-sm" id="intl-fax" onKeyup='addDashes(this)' placeholder="952-888-1888" value="<?= $fax_phone_arr[2]; ?>"> </td> 
</tr>
