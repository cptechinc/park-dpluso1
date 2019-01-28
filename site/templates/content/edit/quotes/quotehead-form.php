<?php include $config->paths->content.'edit/quotes/quote-attachments.php'; ?>
<form id="quotehead-form" action="<?= $config->pages->quotes."redir/";  ?>" class="form-group order-form" method="post">
	<input type="hidden" name="action" value="update-quotehead">
	<input type="hidden" name="qnbr" id="qnbr" value="<?= $quote->quotnbr; ?>">
    <input type="hidden" name="custID" id="custID" value="<?= $quote->custid; ?>">
    <div class="row"> <div class="col-xs-10 col-xs-offset-1"> <div class="response"></div> </div> </div>

    <div class="row">
    	<div class="col-sm-6">
        	<?php include $config->paths->content.'edit/quotes/quotehead/bill-to.php'; ?>
            <?php include $config->paths->content.'edit/quotes/quotehead/ship-to.php'; ?>
        </div>
        <div class="col-sm-6">
        	<?php include $config->paths->content.'edit/quotes/quotehead/quote-info.php'; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="text-center form-group">
        		<button type="submit" class="btn btn-success btn-block"><i class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></i> Save</button>
        	</div>
        </div>
        <div class="col-sm-6">
            <div class="text-right form-group">
				<?php if ($quote->can_edit()) : ?>
	        		<button type="button" class="btn btn-success text-center" onclick="$('#quotedetail-link').click()"><span class="glyphicon glyphicon-triangle-right"></span> Details Page</button>
				<?php endif; ?>
	        </div>
        </div>
    </div>
    <hr>
    <?php if (!$quote->can_edit()) : ?>
		<a href="<?= $editquotedisplay->generate_unlockURL($quote); ?>" class="btn btn-block btn-success">
			<i class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></i> Finished with quote
		</a>
    <?php else : ?>
        <?php if (($config->pages->orderquote.'?qnbr='.$qnbr) != $config->filename && has_dpluspermission($user->loginid, 'eso')) : ?>
            <div class="form-group">
				<a href="<?= $editquotedisplay->generate_orderquoteURL($quote); ?>" class="btn btn-default btn-block">
					<i class="fa fa-paper-plane-o" aria-hidden="true"></i> Send To Order
				</a>
            </div>
        <?php endif; ?>
		<div class="text-center">
			<button type="button" class="btn btn-block btn-emerald save-unlock-quotehead" data-form="#quotehead-form">
				<i class="fa fa-unlock" aria-hidden="true"></i> Save and Exit
			</button>
		</div>
    <?php endif; ?>
</form>
