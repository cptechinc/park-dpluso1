<?php $item = PricingItem::load(session_id(), $linedetail->itemid); ?>
<div class="row edit-pricing">
    <div class="col-md-3">
        <img src="<?= $item->generate_imagesrc(); ?>" alt="">
    </div>
    <div class="col-md-9">
        <?php if (in_array($linedetail->itemid, $config->nonstockitems)) : ?>
            <h4><?= $linedetail->itemid; ?> &nbsp;<?= (strlen($linedetail->vendoritemid)) ? $linedetail->vendoritemid : ''; ?></h4> 
			<h5><?= $linedetail->desc1; ?></h5>
        <?php else : ?>
            <h4><?= $item->itemid; ?></h4> <h5><?= $item->name1; ?></h5>
            <div class="product-info">
                <ul class="nav nav-tabs nav_tabs hidden-print">
                    <li class="active"><a href="#<?= $page->stringerbell->format_forjs($item->itemid); ?>-desc-tab" data-toggle="tab" aria-expanded="true">Description</a></li>
                    <li><a href="#<?= $page->stringerbell->format_forjs($item->itemid); ?>-specs-tab" data-toggle="tab" aria-expanded="false">Specifications</a></li>
                    <li><a href="#<?= $page->stringerbell->format_forjs($item->itemid); ?>-pricing-tab" data-toggle="tab" aria-expanded="false">Prices</a></li>
                    <?php if ($linedetail->kititemflag == 'Y') : ?>
                        <li><a href="#<?= $page->stringerbell->format_forjs($item->itemid); ?>-components-tab" data-toggle="tab" aria-expanded="false">Kit Components</a></li>
                    <?php endif; ?>
					<?php if ($config->cptechcustomer == 'stat') : ?>
						<li><a href="#<?= $page->stringerbell->format_forjs($item->itemid); ?>-comission-tab" data-toggle="tab" aria-expanded="false">Comission Pricing</a></li>
					<?php endif; ?>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="<?= $item->itemid; ?>-desc-tab">
                        <br><p><?= $item->shortdesc; ?></p>
                    </div>
                    <div class="tab-pane fade" id="<?= $page->stringerbell->format_forjs($item->itemid); ?>-specs-tab"><br><?php include $config->paths->content."products/product-results/product-features.php"; ?></div>
                    <div class="tab-pane fade" id="<?= $page->stringerbell->format_forjs($item->itemid); ?>-pricing-tab"><br><?php include $config->paths->content."products/product-results/price-structure.php"; ?></div>
                    <div class="tab-pane fade" id="<?= $page->stringerbell->format_forjs($item->itemid); ?>-components-tab"><br>
						<?php $tableformatter= $page->screenformatterfactory->generate_screenformatter('item-kitcomponents'); ?>
						<?php include $config->paths->content.'common/include-tableformatter-display.php'; ?>
					</div>
					<?php if ($config->cptechcustomer == 'stat') : ?>
						<div class="tab-pane fade" id="<?= $page->stringerbell->format_forjs($item->itemid); ?>-comission-tab"><br><?php include $config->paths->content."products/product-results/item-commission.php"; ?></div>
					<?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
