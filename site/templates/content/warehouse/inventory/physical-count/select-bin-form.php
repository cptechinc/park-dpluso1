<?php include "{$config->paths->content}warehouse/session.js.php"; ?>
<div>
	<form action="<?= $page->fullURL->getUrl(); ?>" method="GET" class="select-bin-form">
		<div class="form-group">
			<label for="binID">Bin ID</label>
			<div class="input-group">
				<input type="text" class="form-control" id="binID" name="binID">
				<span class="input-group-btn">
					<button type="button" class="btn btn-default show-possible-bins" data-input="binID"> <span class="fa fa-search" aria-hidden="true"></span> </button>
				</span>
			</div>
		</div>
		<button type="submit" class="btn btn-primary not-round"> <i class="fa fa-floppy-o" aria-hidden="true"></i> Submit</button>
	</form>
</div>
