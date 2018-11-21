<?php
    if (trim($iiconfig['saleshistory']['date-options']['start-date']) != '') {
        $date = date("m/d/y", strtotime($iiconfig['saleshistory']['date-options']['start-date']));
    } else {
        $date = date("m/d/y", strtotime("-".$iiconfig['saleshistory']['date-options']['days-back']." day"));
    }

?>
<form action="<?php echo $config->pages->products."redir/"; ?>" id="ii-sales-history-form" method="post" class="allow-enterkey-submit">
    <input type="hidden" name="action" value="ii-sales-history">
    <input type="hidden" name="itemID" value="<?php echo $itemID; ?>">
    <div class="row">
        <div class="col-xs-10">
            <div class="form-group">
                <p>Item: <?php echo $itemID; ?></p>
            </div>
            <div class="form-group">
                <label for="">Starting Invoice Date</label>
                <div class="input-group date">
                   	<?php $name = 'date'; $value = $date;?>
					<?php include $config->paths->content."common/date-picker.php"; ?>
                </div>
            </div>
            <div class="form-group">
                <label for="">Customer ID</label>
                <input type="text" class="form-control not-round custID" name="custID" placeholder="CustID" value="<?= $custID; ?>">
            </div>
            <button type="submit" class="btn btn-primary btn-sm">Submit</button> &nbsp; &nbsp;
            <button type="button" class="btn btn-primary btn-sm" onclick="iicust('ii-item-hist');">Choose Cust</button>
        </div>
    </div>
</form>
