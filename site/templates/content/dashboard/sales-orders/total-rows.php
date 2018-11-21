<tr>
	<td></td> <td>Subtotal</td> <td colspan="2"></td> <td colspan="2" class="text-right">$ <?= $page->stringerbell->format_money($order->subtotal_nontax); ?></td> <td colspan="5"></td>
</tr>
<tr>
	<td></td> <td>Tax</td> <td colspan="2"></td> <td colspan="2" class="text-right">$ <?= $page->stringerbell->format_money($order->total_tax); ?></td> <td colspan="5"></td>
</tr>
<tr>
	<td></td> <td>Freight</td> <td colspan="2"></td> <td colspan="2" class="text-right">$ <?= $page->stringerbell->format_money($order->total_freight); ?></td> <td colspan="5"></td>
</tr>
<tr>
	<td></td> <td>Misc.</td> <td colspan="2"></td><td colspan="2" class="text-right">$ <?= $page->stringerbell->format_money($order->total_misc); ?></td> <td colspan="5"></td>
</tr>
<tr>
	<td></td>  <td>Total</td> <td colspan="2"></td> <td colspan="2" class="text-right">$ <?= $page->stringerbell->format_money($order->total_order); ?></td> <td colspan="5"></td>
</tr>
