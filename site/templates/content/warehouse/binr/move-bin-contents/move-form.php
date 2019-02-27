<div class="form-group">
	<a href="<?= $page->parent->url; ?>" class="btn btn-primary not-round">
		<i class="fa fa-arrow-left" aria-hidden="true"></i> Return to BINR Menu
	</a>
</div>
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
			<div class="row">
				<div class="col-xs-9">
					<label for="frombin">From Bin ID</label>
					<div class="input-group">
						<input type="text" class="form-control bin-input" id="frombin" name="from-bin">
						<span class="input-group-btn">
							<button type="button" class="btn btn-default" data-input="from-bin" data-toggle="modal" data-target="#select-bin-modal"> <span class="fa fa-search" aria-hidden="true"></span> </button>
						</span>
					</div>
				</div>
				<div class="col-xs-3">
					<div class="bin-contents-toggle">
						<label aria-hidden="true">Show Bin Contents</label>
						<div class="input-group">
							<button type="button" class="btn btn-primary show-bin-contents" data-toggle="modal" data-target="#bin-contents-modal">View Bin <i class="fa fa-cube" aria-hidden="true"></i></button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="row">
				<div class="col-xs-9">
					<label for="tobin">To Bin ID</label>
					<div class="input-group">
						<input type="text" class="form-control bin-input" id="tobin" name="to-bin">
						<span class="input-group-btn">
							<button type="button" class="btn btn-default" data-input="to-bin" data-toggle="modal" data-target="#select-bin-modal"> <span class="fa fa-search" aria-hidden="true"></span> </button>
						</span>
					</div>
				</div>
				<div class="col-xs-3">
					<div class="bin-contents-toggle">
						<label aria-hidden="true">Show Bin Contents</label>
						<div class="input-group">
							<button type="button" class="btn btn-primary show-bin-contents" data-toggle="modal" data-target="#bin-contents-modal">View Bin <i class="fa fa-cube" aria-hidden="true"></i></button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<button type="submit" class="btn btn-primary not-round"> <i class="fa fa-floppy-o" aria-hidden="true"></i> Submit</button>
	</form>
</div>
<?php include __DIR__ . "/bin-contents-modal.php"; ?>
<?php include __DIR__ . "/select-bin-modal.php"; ?>
<?php include "{$config->paths->content}warehouse/session.js.php"; ?>
