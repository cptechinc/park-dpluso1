<div class="item-result">
	<div class="row">
		<div class="col-md-2 col-sm-3 print-col-sm-2">
			<a href="#" data-toggle="modal" data-target="#lightbox-modal">
				<img src="<?= $item->generate_imagesrc(); ?>" data-desc="<?php echo $item->itemid.' image'; ?>">
			</a>
		</div>
		<div class="col-md-7 col-sm-6 print-col-sm-10">
			<h4><a href="<?= $config->pages->products.'redir/?action=ii-select&itemID='.urlencode($item->itemid); ?>" target="_blank"><?= $item->itemid; ?></a></h4>
			<h5><?= $item->name1; ?></h5>
			<?php if (!empty($item->supercedes)) : ?>
				<div class="alert alert-warning" role="alert"><b>Supercedes</b> <?= $item->supercedes; ?></div>
			<?php endif; ?>
			<div class="product-info">
				<ul class="nav nav-tabs nav_tab hidden-print">
					<li class="active"><a href="#<?= cleanforjs($item->itemid); ?>-stock-tab" data-toggle="tab" aria-expanded="true">Stock</a></li>
					<li><a href="#<?= cleanforjs($item->itemid); ?>-desc-tab" data-toggle="tab" aria-expanded="false">Description</a></li>
					<li><a href="#<?= cleanforjs($item->itemid); ?>-specs-tab" data-toggle="tab" aria-expanded="false">Specs</a></li>
					<li><a href="#<?= cleanforjs($item->itemid); ?>-pricing-tab" data-toggle="tab" aria-expanded="false">Price Breaks</a></li>

					<?php if ($config->cptechcustomer == 'stat') : ?>
						<li><a href="#<?= cleanforjs($item->itemid); ?>-commission-tab" data-toggle="tab" aria-expanded="false">Comission Pricing</a></li>
					<?php endif; ?>
				</ul>
				<div class="tab-content">
					<div class="tab-pane fade active in" id="<?= cleanforjs($item->itemid); ?>-stock-tab"><br><?php include $config->paths->content."products/product-results/stock-table.php"; ?></div>
					<div class="tab-pane fade" id="<?= cleanforjs($item->itemid); ?>-desc-tab">
						<br><p><?= $item->shortdesc; ?></p>
					</div>
					<div class="tab-pane fade" id="<?= cleanforjs($item->itemid); ?>-specs-tab"><br><?php include $config->paths->content."products/product-results/product-features.php"; ?></div>
					<div class="tab-pane fade" id="<?= cleanforjs($item->itemid); ?>-pricing-tab"><br><?php include $config->paths->content."products/product-results/price-structure.php"; ?></div>

					<?php if ($config->cptechcustomer == 'stat') : ?>
						<div class="tab-pane fade" id="<?= cleanforjs($item->itemid); ?>-commission-tab"><br><?php include $config->paths->content."products/product-results/item-commission.php"; ?></div>
					<?php endif; ?>
				</div>
				<?php if (!empty($item->has_saleshistory()) && !empty($item->history('lastqty'))) : ?>
					<table class="table table-condensed">
						<thead>
							<tr><th colspan="3"><?= $custID."'s " .$item->itemid; ?> History</th></tr>
						</thead>
						<tr>
							<td>Last Sold: <?= Dplus\Base\DplusDateTime::format_date($item->history('lastsold')); ?></td>
							<td>Price: $ <?= $item->history('lastprice'); ?></td>
							<td>Qty Sold: <?= $item->history('lastqty'); ?></td>
						</tr>
					</table>
				<?php endif; ?>
			</div>
		</div>
		<div class="col-md-3 hidden-print">
			<form action="<?= $addtoform->action; ?>" method="post" data-addto="order" id="<?= cleanforjs($item->itemid)."-form"; ?>" >
				<input type="hidden" name="action" value="<?= $addtoform->rediraction; ?>">
				<input type="hidden" name="page" value="<?= $addtoform->returnpage; ?>">
				<input type="hidden" name="itemID" value="<?= $item->itemid; ?>">
				<input type="hidden" name="whse" id="<?= cleanforjs($item->itemid)."-whse"; ?>" value="">
				<input type="hidden" name="custID" value="<?= $custID; ?>">
				<input type="hidden" name="jsondetailspage" value="<?= $config->pages->ajax.'json/order/details/?ordn='.$ordn; ?>">
				<?php if ($custID != '') : ?>
					<input type="hidden" name="shipID" value="<?= $shipID; ?>">
				<?php endif; ?>
				<input type="hidden" name="ordn" value="<?= $ordn; ?>">
				<table class="table table-condensed no-bottom ">
					<tr> <td>UoM:</td> <td class="text-right"><?= $item->unit; ?></td> </tr>
					<?php if ($appconfig->child('name=sales-orders')->show_listprice) : ?>
						<tr> <td>List Price:</td> <td class="text-right">$ <?= $item->listprice; ?></td> </tr>
					<?php endif; ?>
					<tr> <td>Price:</td> <td class="text-right">$ <?= $item->price;?></td> </tr>
					<tr> <td>In Stock:</td> <td class="text-right"><?= $item->get_totalavailable(); ?></td> </tr>
					<tr class="item-whse-row"><td>Whse:</td> <td class="item-whse-val text-right"></td></tr>
					<tr> <td>Qty:</td> <td class="text-right"><input type="text" class="form-control input-sm text-right qty" name="qty"></td> </tr>
					<tr>
						<td colspan="2" class="text-center">
							<button type="submit" class="btn btn-primary btn-sm">
								<span class="glyphicon glyphicon-plus"></span> Add Item
							</button>
						</td>
					</tr>
				</table>
			</form>
		</div>
	</div>
</div>
