<div id="sales-order-details ">
	<div class="form-group">
		<?php include $config->paths->content.'edit/orders/order-details/order-details.php'; ?>
	</div>
	<div class="row">
		<div class="col-xs-3 col-sm-7"></div>
	    <div class="col-xs-9 col-sm-5">
	    	<table class="table-condensed table table-striped numeric">
	        	<tr>
	        		<td>Subtotal</td>
	        		<td class="text-right">$ <?= $page->stringerbell->format_money($order->subtotal); ?></td>
	        	</tr>
	        	<tr>
	        		<td>Tax</td>
	        		<td class="text-right">$ <?= $page->stringerbell->format_money($order->salestax); ?></td>
	        	</tr>
	        	<tr>
	        		<td>Freight</td>
	        		<td class="text-right">$ <?= $page->stringerbell->format_money($order->freight); ?></td>
	        	</tr>
	        	<tr>
	        		<td>Misc.</td>
	        		<td class="text-right">$ <?= $page->stringerbell->format_money($order->misccost); ?></td>
	        	</tr>
	        	<tr>
	        		<td>Total</td>
	        		<td class="text-right">$ <?= $page->stringerbell->format_money($order->ordertotal); ?></td>
	        	</tr>
	        </table>
	    </div>
	</div>
</div>
