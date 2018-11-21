<?php if ($appconfig->child('name=actions')->allow_changeuserview) : ?>
    <form action="<?= $actionpanel->generate_refreshurl(); ?>" class="form-ajax" data-loadinto="<?= $actionpanel->loadinto; ?>" data-focus="<?= $actionpanel->focus; ?>">
        <input type="hidden" name="filter" value="filter">
        <input type="hidden" name="view" value="calendar">
        <label class="control-label" id="actions-assignedto">Assigned To: </label> &nbsp; &nbsp;
        <div class="row">
            <div class="col-sm-10">
                <select name="assignedto[]" class="selectpicker show-tick form-control input-sm" aria-labelledby="#actions-assignedto" data-style="btn-default btn-sm" multiple>
                    <?php foreach ($salespersoncodes as $salespersoncode) : ?>
                        <?php $selected = ($actionpanel->has_filtervalue('assignedto', $salespersonjson['data'][$salespersoncode]['splogin'])) ? 'selected' : ''; ?>
                        <?php if (!empty($salespersonjson['data'][$salespersoncode]['splogin'])) : ?>
                            <option value="<?= $salespersonjson['data'][$salespersoncode]['splogin']; ?>" data-subtext="<?= $salespersonjson['data'][$salespersoncode]['splogin']; ?>" <?= $selected; ?>><?= $salespersonjson['data'][$salespersoncode]['spname']; ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-sm-1">
                <button type="submit" class="btn btn-sm btn-success">Go</button>
            </div>
        </div>
    </form>
<?php endif; ?>
