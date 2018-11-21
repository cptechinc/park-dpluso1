<legend>Bill-To</legend>
<table class="table table-striped table-bordered table-condensed">
	<tr> <td class="control-label">Customer</td> <td><?= $quote->custid. ' - ' . $quote->billname; ?></td> </tr>
	<tr> <td class="control-label">Name</td> <td><?= $quote->billname; ?></td> </tr>
    <tr> <td class="control-label">Address</td> <td><?= $quote->billaddress; ?></td> </tr>
    <tr> <td class="control-label">Address 2</td> <td><?= $quote->billaddress2; ?></td> </tr>
    <tr> <td class="control-label">City</td> <td><?= $quote->billcity; ?></td> </tr>
    <tr> <td class="control-label">State</td> <td><?= $quote->billstate; ?></td> </tr>
    <tr> <td class="control-label">Zip</td> <td><?= $quote->billzip; ?></td> </tr>
</table>
