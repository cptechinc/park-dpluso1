<?php 
	include "{$config->paths->content}warehouse/session.js.php"; 
?>
<div class="row">
	<div class="col-sm-6">
		<?php include __DIR__."/scanned-item-details.php"; ?>
		<?php if (!empty($session->get('binr'))) : ?>
			<?php if ($whsesession->had_succeeded()) : ?>
				<div class="alert alert-success" role="alert">
					<strong>Success:</strong> <?= strtoupper($item->get_itemtypepropertydesc()) . " ". $item->get_itemidentifier(); ?> has been moved
				</div>
				<a href="<?= $config->pages->menu_binr; ?>" class="btn btn-primary not-round">BINR Menu</a>
			<?php elseif (!empty($whsesession->status)) : ?>
				<div class="alert alert-danger" role="alert">
					<strong>Error:</strong> <?= $whsesession->status; ?>
				</div>
			<?php endif; ?>
		<?php else : ?>
			<form action="<?= "{$config->pages->menu_binr}redir/"; ?>" method="POST" class="binr-form" id="binr-form">
				<input type="hidden" name="action" value="bin-reassign">
				<input type="hidden" name="page" value="<?= $page->fullURL->getUrl(); ?>">
				<input type="hidden" name="itemID" value="<?= $item->itemid; ?>">
				<input type="hidden" name="<?= $item->get_itemtypeproperty(); ?>" value="<?= $item->get_itemidentifier(); ?>">
				<div class="form-group">
					<h3>From</h3>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label for="from-bin">Bin</label>
							<div class="input-group">
								<input type="text" class="form-control input-sm" name="from-bin" value="<?= $item->bin; ?>">
								<span class="input-group-btn">
									<button type="button" class="btn btn-sm btn-default show-select-bins" data-direction="from"> <span class="fa fa-search"></span> </button>
								</span>
							</div>
						</div>
					</div>
					<div>
						<?php 
							$direction = 'from';
							include __DIR__."/select-direction-bin.php"; 
						?>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-6 form-group">
							<label for="bin-qty">Qty </label> (On Hand: <span class="qty-available"><?= ItemBinInfo::get_binqty(session_id(), $item); ?></span>)
							<div class="input-group">
								<input type="text" class="form-control input-sm text-right" name="qty" value="<?= ItemBinInfo::get_binqty(session_id(), $item); ?>">
								<span class="input-group-btn">
									<button type="submit" class="btn btn-primary btn-sm not-round use-bin-qty" data-direction="from">Use Bin Qty</button>
								</span>
							</div>
						</div>
					</div>
				</div>
				
				<div class="form-group">
					<h3>To</h3>
					<div class="row">
						<div class="col-sm-6 form-group">
							<label for="to-bin">Bin</label>
							<div class="input-group">
								<input type="text" class="form-control input-sm" name="to-bin">
								<span class="input-group-btn">
									<button type="button" class="btn btn-sm btn-default show-possible-bins"> <span class="fa fa-search"></span> </button>
								</span>
							</div>
						</div>
					</div>
				</div>
				<button type="submit" class="btn btn-emerald not-round">Submit</button> 
				&nbsp; &nbsp;
				<a href="<?= $config->pages->binr; ?>" class="btn btn-warning not-round">Cancel</a>
			</form>
		<?php endif; ?>
	</div>
</div>
