<?php include "{$config->paths->content}warehouse/session.js.php"; ?>
<?php if ($session->bincm && $whsesession->had_succeeded()) : ?>
	<?php $results = json_decode($session->bincm, true); ?>
	<div>
		<div class="alert alert-success" role="alert">
			<strong>Success!</strong> You moved all the items from <?= $results['frombin']; ?> to  <?= $results['tobin']; ?> 
		</div>
	</div>
<?php endif; ?>
<div>
	<form action="<?= "{$config->pages->menu_binr}redir/"; ?>" method="GET" class="move-contents-form">
		<input type="hidden" name="action" value="move-bin-contents">
		<input type="hidden" name="page" value="<?= $page->fullURL->getUrl(); ?>">
		<div class="form-group">
			<label for="frombin">From Bin ID</label>
			<div class="input-group">
				<input type="text" class="form-control" id="frombin" name="from-bin">
				<span class="input-group-btn">
					<button type="button" class="btn btn-default show-possible-bins"> <span class="fa fa-search" aria-hidden="true"></span> </button>
				</span>
			</div>
		</div>
		
		<div class="form-group">
			<label for="tobin">To Bin ID</label>
			<div class="input-group">
				<input type="text" class="form-control" id="tobin" name="to-bin">
				<span class="input-group-btn">
					<button type="button" class="btn btn-default show-possible-bins"> <span class="fa fa-search" aria-hidden="true"></span> </button>
				</span>
			</div>
		</div>
		<button type="submit" class="btn btn-primary not-round"> <i class="fa fa-floppy-o" aria-hidden="true"></i> Submit</button>
	</form>
</div>
