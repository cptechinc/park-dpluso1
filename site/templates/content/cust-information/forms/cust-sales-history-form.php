<?php $date = date("m/d/y", strtotime("- 365 day"));  //TODO HAVE THIS SET IN USERCONFIG; ?>
<div>
    <form action="<?= $config->pages->customer.'redir/'; ?>" method="get" id="cust-sales-history-form">
        <input type="hidden" name="action" value="ci-sales-history">
        <input type="hidden" name="custID" value="<?php echo $input->get->text('custID'); ?>">
        <input type="hidden" name="shipID" value="<?php echo $input->get->text('shipID'); ?>">

        <div class="form-group">
            <label for="">Starting Invoice Date</label>
            <div class="input-group date">
                <?php $name = 'date'; $value = $date;?>
                <?php include $config->paths->content."common/date-picker.php"; ?>
            </div>
        </div>

        <div class="form-group">
            <label for="">Search Item</label>
            <input type="text" class="form-control input-sm ci-history-item-search" name="itemID" data-results="<?= $config->pages->ajax.'load/ci/item-search-results/'; ?>">
        </div>


        <div>
            <div class="panel panel-primary" id="item-results">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" href="#resultspanel" aria-expanded="true" aria-controls="resultspanel">
                            Item Results
                        </a>
                    </h4>
                </div>
                <div id="resultspanel" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                    </div>
                </div>
            </div>
        </div>

        <br>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

</div>
<script>
    //$('.datepicker').datepicker({allowPastDates: true});
    //$('.datepicker').datepicker('setDate', '');
    $('#shownotes').checkbox();
</script>
