<form action="<?= $page->child('name=redir')->url; ?>" method="post" class="allow-enterkey-submit">
    <input type="hidden" name="action" value="select-bin">
    <input type="hidden" name="page" value="<?= $page->fullURL->getUrl(); ?>">
    <label>Choose Bin to Start from</label>
    <div class="input-group form-group">
        <input class="form-control" name="bin" placeholder="Bin ID" type="text">
        <span class="input-group-btn">
            <button type="submit" class="btn btn-emerald not-round">Submit </button>
        </span>
    </div>
</form>
