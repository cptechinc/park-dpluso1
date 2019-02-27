<?php
    /**
     * $direction is which bin to apply this select bins
     * Ex. to | from
     */
?>
<div class="<?= !empty($item->bin) ? 'hidden' : ''; ?>">
    <h3>Select From Bin</h3>
    <div class="list-group choose-from-bins">
        <div class="list-group-item">
            <div class="row">
                <div class="col-xs-3">
                    <h4 class="list-group-item-heading">Bin</h4>
                </div>
                <div class="col-xs-3">
                    <h4 class="list-group-item-heading"><?= $item->is_lotted() || $item->is_serialized() ? ucwords($item->get_itemtypepropertydesc()) : ''; ?></h4>
                </div>
                <div class="col-xs-3">
                    <h4 class="list-group-item-heading">On Hand</h4>
                </div>
            </div>
        </div>
        <?php $bins = ItemBinInfo::find_by_item(session_id(), $item); ?>
        <?php foreach ($bins as $bin) : ?>
            <a href="#" class="list-group-item choose-bin" data-binid="<?= $bin->binid; ?>" data-direction="from" data-qty="<?= $bin->qty; ?>">
                <div class="row">
                    <div class="col-xs-4">
                        <p class="list-group-item-text"><?= $bin->binid; ?></p>
                    </div>
                    <div class="col-xs-4">
                        <p class="list-group-item-text"><?= $item->is_lotted() || $item->is_serialized() ? $bin->lotserial : ''; ?></p>
                    </div>
                    <div class="col-xs-4">
                        <p class="list-group-item-text text-right"><?= $bin->qty; ?></p>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>
