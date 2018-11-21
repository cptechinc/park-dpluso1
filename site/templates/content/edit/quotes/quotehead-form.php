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
        		<button type="submit" class="btn btn-success btn-block"><i class="glyphicon glyphicon-floppy-disk"></i> Save</button>
        	</div>
        </div>
        <div class="col-sm-6">
            <div class="text-right form-group">
				<?php if ($editquotedisplay->canedit) : ?>
	        		<button type="button" class="btn btn-success text-center" onclick="$('#quotedetail-link').click()"><span class="glyphicon glyphicon-triangle-right"></span> Details Page</button>
				<?php endif; ?>
	        </div>
        </div>
    </div>
    <hr>
    <?php if (!$editquotedisplay->canedit) : ?>
         <?= $editquotedisplay->generate_confirmationlink($quote); ?>
    <?php else : ?>
        <?php if (($config->pages->orderquote.'?qnbr='.$qnbr) != $config->filename && has_dpluspermission($user->loginid, 'eso')) : ?>
            <div class="form-group">
                <?= $editquotedisplay->generate_sendtoorderlink($quote); ?>
            </div>
        <?php endif; ?>
		<div class="text-center">
            <?= $editquotedisplay->generate_saveunlockbutton($quote); ?>
		</div>
    <?php endif; ?>
</form>
