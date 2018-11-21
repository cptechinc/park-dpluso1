<tr class="international <?php echo $hidden_intl; ?>">
    <td colspan="2" class="control-label"><h4>Office Phone</h4></td>
</tr>
<tr class="international <?php echo $hidden_intl; ?>">
    <td class="control-label">Access Code</td>
    <td> <input type="text" class="form-control input-sm" name="office-accesscode" size="3" value="<?php echo $office_phone_arr[0]; ?>"> </td>
</tr>
<tr class="international <?php echo $hidden_intl; ?>">
    <td class="control-label">Country Code</td>
    <td> <input type="text" class="form-control input-sm" name="office-countrycode" size="3" value="<?php echo $office_phone_arr[1]; ?>"> </td>
</tr>
<tr class="international <?php echo $hidden_intl; ?>">
    <td class="control-label">Phone</td>
    <td> <input type="text" class="form-control input-sm" name="intl-office" onKeyup='addDashes(this)' placeholder="952-888-1888" value="<?php echo $office_phone_arr[2]; ?>">  </td>
</tr>
<tr class="international <?php echo $hidden_intl; ?>">
    <td class="control-label">Ext.</td>
    <td> <input type="text" class="form-control input-sm" name="intl-office-ext" value="<?php echo $billing['extension']; ?>"> </td>
</tr>

<tr class="international <?php echo $hidden_intl; ?>">
    <td colspan="2" class="control-label"><h4>Fax</h4></td>
    <td></td>
</tr>
<tr class="international <?php echo $hidden_intl; ?>">
    <td class="control-label">Access Code</td>
    <td> <input type="text" class="form-control input-sm" name="fax-accesscode" size="3" value="<?php echo $fax_phone_arr[0]; ?>"> </td>
</tr>
<tr class="international <?php echo $hidden_intl; ?>">
    <td class="control-label">Country Code</td>
    <td> <input type="text" class="form-control input-sm"  name="fax-countrycode" size="3" value="<?php echo $fax_phone_arr[1]; ?>"> </td>
</tr>

<tr class="international <?php echo $hidden_intl; ?>">
    <td class="control-label">Phone</td>
    <td>  <input type="text" class="form-control input-sm" id="intl-fax" onKeyup='addDashes(this)' placeholder="952-888-1888" value="<?php echo $fax_phone_arr[2]; ?>"> </td>
</tr>
