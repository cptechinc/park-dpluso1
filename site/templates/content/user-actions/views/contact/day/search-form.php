<form action="<?= $actionpanel->generate_refreshurl(); ?>" method="GET" class="actions-filter" data-loadinto="<?= $actionpanel->loadinto; ?>" data-focus="<?= $actionpanel->focus; ?>">
    <input type="hidden" name="filter" value="filter">
    <div class="row">
        <div class="col-sm-3 form-group">
            <?php if (($appconfig->child('name=actions')->allow_changeuserview)) : ?>
                <h4 id="actions-assignedto">Assigned To</h4>
                <select name="assignedto[]" class="selectpicker show-tick form-control input-sm" aria-labelledby="#actions-assignedto" data-style="btn-default btn-sm" multiple>
                    <?php foreach ($salespersoncodes as $salespersoncode) : ?>
                        <?php $selected = ($actionpanel->has_filtervalue('assignedto', $salespersonjson['data'][$salespersoncode]['splogin'])) ? 'selected' : ''; ?>
                        <?php if (!empty($salespersonjson['data'][$salespersoncode]['splogin'])) : ?>
                            <option value="<?= $salespersonjson['data'][$salespersoncode]['splogin']; ?>" <?= $selected; ?>><?= $salespersonjson['data'][$salespersoncode]['spname']; ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            <?php endif; ?>
        </div>
        <div class="col-sm-2 form-group">
            <h4>Completed Status</h4>
            <?php foreach ($actionpanel->taskstatuses as $taskstatus) : ?>
                <label><?= $taskstatus['label']; ?></label>
    			<input class="pull-right" type="checkbox" name="completed[]" value="<?= $taskstatus['value']; ?>" <?= ($actionpanel->has_filtervalue('completed', $taskstatus['value'])) ? 'checked' : ''; ?>></br>
            <?php endforeach; ?>
        </div>
        <div class="col-sm-2 form-group">
            <h4>Action Type(s)</h4>
            <?php foreach ($appconfig->child('name=actions')->child('name=types')->children() as $actiontype) : ?>
                <label><?= $actiontype->title; ?></label>
    			<input class="pull-right" type="checkbox" name="actiontype[]" value="<?= $actiontype->name; ?>" <?= ($actionpanel->has_filtervalue('actiontype', $actiontype->name)) ? 'checked' : ''; ?>></br>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <button type="submit" class="btn btn-sm btn-success btn-block"><i class="fa fa-filter" aria-hidden="true"></i> Apply Filter</button>
        </div>
        <div class="col-xs-6">
            <?php if ($input->get->filter) : ?>
                <a href="<?= $actionpanel->generate_clearfilterurl(); ?>" class="btn btn-sm btn-warning btn-block load-link" data-loadinto="<?= $actionpanel->loadinto; ?>" data-focus="<?= $actionpanel->focus; ?>">
                    <i class="fa fa-times" aria-hidden="true"></i> Clear Filter
                </a>
            <?php endif; ?>
        </div>
    </div>
</form>
