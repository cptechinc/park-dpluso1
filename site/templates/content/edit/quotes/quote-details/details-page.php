<div id="sales-order-details">
	<div class="form-group"><?php include $config->paths->content.'edit/quotes/quote-details/quote-details.php'; ?></div>
	<div class="row">
		<div class="col-xs-6 col-sm-7"></div>
	    <div class="col-xs-6 col-sm-5">
	    	<table class="table-condensed table table-striped numeric">
	        	<tr>
	        		<td>Subtotal</td>
	        		<td class="text-right">$ <?= $page->stringerbell->format_money($quote->subtotal); ?></td>
	        	</tr>
	        	<tr>
	        		<td>Tax</td>
	        		<td class="text-right">$ <?= $page->stringerbell->format_money($quote->salestax); ?></td>
	        	</tr>
	        	<tr>
	        		<td>Freight</td>
	        		<td class="text-right">$ <?= $page->stringerbell->format_money($quote->freight); ?></td>
	        	</tr>
	        	<tr>
	        		<td>Misc.</td>
	        		<td class="text-right">$ <?= $page->stringerbell->format_money($quote->misccost); ?></td>
	        	</tr>
	        	<tr>
	        		<td>Total</td>
	        		<td class="text-right">$ <?= $page->stringerbell->format_money($quote->ordertotal); ?></td>
	        	</tr>
	        </table>
	    </div>
	</div>
</div>
