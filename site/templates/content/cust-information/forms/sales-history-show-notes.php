<div class="row form-group">
    <div class="col-sm-3 col-xs-5">
        <label for="shownotes">Show Notes</label>
        <select name="" class="form-control" id="shownotes" data-link="<?= $shownoteslink; ?>" data-ajax="<?= $pageajax; ?>">
            <?php foreach ($config->yesnoarray as $key => $value) : ?>
                <option value="<?= $value; ?>"><?= $key; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
