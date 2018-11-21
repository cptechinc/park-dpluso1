<legend>Bill-To</legend>
<table class="table table-striped table-bordered table-condensed">
	<tr> <td>Customer</td> <td><p class="form-control-static"><?= $order->custid. ' - ' . $order->custname; ?></p></td> </tr>
	<tr> <td class="control-label">Name</td> <td><?= $order->custname; ?></td> </tr>
    <tr> <td>Address</td> <td><?= $order->billaddress; ?></td> </tr>
    <tr> <td>Address 2</td> <td><?= $order->billaddress2; ?></td> </tr>
    <tr> <td class="control-label">City</td> <td><?= $order->billcity; ?></td> </tr>
    <tr> <td>State</td> <td><?= $order->billstate; ?></td> </tr>
    <tr> <td>Zip</td> <td><?= $order->billzip; ?></td> </tr>
</table>
