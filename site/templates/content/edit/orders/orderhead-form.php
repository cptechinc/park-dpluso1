<?php include $config->paths->content.'edit/orders/order-attachments.php'; ?>
<form id="orderhead-form" action="<?= $config->pages->orders."redir/"; ?>" method="post" class="form-group order-form" data-ordn="<?= $order->ordernumber; ?>">
	<input type="hidden" name="action" value="update-orderhead">
	<input type="hidden" name="exitorder" value="true">
	<input type="hidden" name="ordn" id="ordn" value="<?= $ordn; ?>">
    <input type="hidden" name="custID" id="custID" value="<?= $order->custid; ?>">
    <div class="row"> <div class="col-xs-10 col-xs-offset-1"> <div class="response"></div> </div> </div>

    <div class="row">
    	<div class="col-sm-6">
        	<?php include $config->paths->content.'edit/orders/orderhead/bill-to.php'; ?>
            <?php include $config->paths->content.'edit/orders/orderhead/ship-to.php'; ?>
        </div>
        <div class="col-sm-6">
        	<?php include $config->paths->content.'edit/orders/orderhead/order-info.php'; ?>
			<?php if (!$user->loginid == SalesOrder::get_orderlockuser($ordn)) : ?>
				<div class="text-right form-group">
					<button type="button" class="btn btn-success text-center" onclick="$('#salesdetail-link').click()">
						<span class="glyphicon glyphicon-triangle-right"></span> Details Page
					</button>
				</div>
			<?php endif; ?>
        </div>
    </div>
    <div class="row">
		<div class="col-sm-6">
			<?php if ($user->loginid == SalesOrder::get_orderlockuser($ordn)) : ?>
        		<button type="submit" class="btn btn-success btn-block text-center"><span class="glyphicon glyphicon-floppy-disk"></span> Save Changes</button>
			<?php endif; ?>
		</div>
    </div>
	<hr>
	<?php if ($user->loginid != SalesOrder::get_orderlockuser($order->ordernumber)) : ?>
		<a href="<?= $editorderdisplay->generate_unlockURL($order); ?>" class="btn btn-block btn-success">
			<span class="fa fa-arrow-right" aria-hidden="true"></span> Finished With Order
		</a>
	<?php else : ?>
		<a href="<?= $editorderdisplay->generate_unlockURL($order); ?>" class="btn btn-block btn-emerald save-unlock-order" data-form="#orderhead-form">
			<span class="fa fa-unlock" aria-hidden="true"></span> Save and Exit
		</a>
	<?php endif; ?>
</form>
