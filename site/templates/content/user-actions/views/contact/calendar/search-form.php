<form action="<?= $actionpanel->generate_refreshurl(); ?>" class="form-ajax form-inline display-inline-block" data-loadinto="<?= $actionpanel->loadinto; ?>" data-focus="<?= $actionpanel->focus; ?>">
    <input type="hidden" name="filter" value="filter">
    <input type="hidden" name="view" value="calendar">

    <label class="control-label">Go to Month</label> &nbsp; &nbsp;
    <div class="input-group date" style="width: 180px;">
        <?php $name = 'month'; $value = ''; ?>
        <?php include $config->paths->content."common/date-picker.php"; ?>
    </div>
    <button type="submit" class="btn btn-sm btn-success">Go</button>
</form>
