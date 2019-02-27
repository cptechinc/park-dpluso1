<div class="form-group">
	<a href="<?= $page->parent->url; ?>" class="btn btn-primary not-round">
		<i class="fa fa-arrow-left" aria-hidden="true"></i> Return to <?= $page->parent->title; ?> Menu
	</a>
</div>
<?php if ($input->get->text('tobin')) : ?>
	<?php if (!$whseconfig->validate_bin($input->get->text('tobin'))) : ?>
		<div class="alert alert-danger" role="alert">
			<strong>Error! </strong> <?= $input->get->text('tobin'); ?> is not a valid bin
		</div>
	<?php endif; ?>
<?php endif; ?>
<form action="<?= $page->url; ?>" method="get" class="select-bin-form allow-enterkey-submit">
    <div class="form-group">
        <label for="binID">Bin ID</label>
        <div class="input-group">
            <input type="text" class="form-control" id="tobin" name="tobin">
            <span class="input-group-btn">
                <button type="button" class="btn btn-default show-possible-bins" data-input="tobin"> <span class="fa fa-search" aria-hidden="true"></span> </button>
            </span>
        </div>
    </div>
	<button type="submit" class="btn btn-emerald not-round">Submit</button>
</form>
<?php include "{$config->paths->content}warehouse/session.js.php"; ?>
