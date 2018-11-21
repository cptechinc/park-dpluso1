<?php
if (trim($iiconfig['activity']['date-options']['start-date']) != '') {
    $date = date("m/d/y", strtotime($iiconfig['activity']['date-options']['start-date']));
} else {
    $date = date("m/d/y", strtotime("-".$iiconfig['activity']['date-options']['days-back']." day"));
}
?>
<form action="<?php echo $config->pages->products."redir/"; ?>" id="ii-item-activity-form" method="post" class="allow-enterkey-submit">
    <input type="hidden" name="action" value="ii-activity">
    <input type="hidden" name="itemID" value="<?php echo $itemID; ?>">
    <div class="row">
        <div class="col-xs-10">
            <div class="form-group">
                <p>Item: <?php echo $itemID; ?></p>
            </div>
            <div class="form-group">
                <label for="">Starting Report Date</label>
                <div class="input-group date">
                	<?php $name = 'date'; $value = $date;?>
					<?php include $config->paths->content."common/date-picker.php"; ?>
                </div>
            </div>
            <button type="submit" class="btn btn-success">Search</button>
        </div>
    </div>
</form>
