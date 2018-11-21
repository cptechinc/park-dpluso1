<?php
    $date = date("m/d/y", strtotime("- 365 day"));
?>
<form action="<?php echo $config->pages->vendor."redir/"; ?>" id="vi-purchase-history-form" method="post" class="allow-enterkey-submit">
    <input type="hidden" name="action" value="vi-purchase-history">
    <input type="hidden" name="vendorID" value="<?php echo $vendorID; ?>">
    <input type="hidden" name="shipfromID" value="<?php echo $shipfromID; ?>">
    <div class="row">
        <div class="col-xs-10">
            <div class="form-group">
                <p>Vendor: <?php echo $vendorID; ?></p>
            </div>

            <div class="form-group">
                <label for="date">Starting Report Date</label>
                <div class="input-group date">
                	<?php $name = 'date'; $value = $date;?>
					<?php include $config->paths->content."common/date-picker.php"; ?>
                </div>
            </div>
            <button type="submit" class="btn btn-success">Search</button>
        </div>
    </div>
</form>
