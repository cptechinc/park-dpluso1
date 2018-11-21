<div class="modal fade" id="item-lookup-modal" tabindex="-1" role="dialog" aria-labelledby="item-lookup-modal-label">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title" id="item-lookup-modal-label">Add Item to <?= $itemlookup->type; ?></h4>
            </div>
            <div class="modal-body">
                <div>
                    <div class="row">
                        <?php if ($appconfig->show_nonstockadd) : ?>
                            <div class="col-xs-2">
                                <a href="<?= $itemlookup->generate_nonstockformurl(); ?>" class="btn btn-primary load-into-modal nonstock-btn" data-modal="#ajax-modal" data-modalsize="xl">
                                    <i class="fa fa-cube" aria-hidden="true"></i> Non-stock
                                </a>
                            </div>
                        <?php endif; ?>
                        <div class="col-xs-2">
                            <a href="<?= $itemlookup->generate_addmultipleurl(); ?>" class="btn btn-primary load-into-modal add-multiple-items" data-modal="#ajax-modal" data-modalsize="md">
                                <i class="fa fa-cube" aria-hidden="true"></i> Add Multiple
                            </a>
                        </div>
                        <div class="col-xs-8">
                            <div>
                                <form action=""></form>
                                <form action="<?= $config->pages->products."redir/"; ?>" id="add-item-search-form" class="allow-enterkey-submit">
                                    <input type="hidden" name="action" value="item-search">
                                    <input type="hidden" name="custID" value="<?= $itemlookup->custID; ?>" class="custID">
                                    <input type="hidden" name="shipID" value="<?= $itemlookup->shipID; ?>" class="shipID">
                                    <input type="hidden" class="resultsurl" name="resultsurl" value="<?= $itemlookup->generate_resultsurl(); ?>">
                                    <div class="row form-group">
                                        <div class="col-xs-12">
                                            <div class="input-group">
                                                <input type="text" class="form-control not-round searchfield" name="q" placeholder="Search itemID, X-ref, UPC">
                                                <span class="input-group-btn">
                                                	<button type="submit" class="btn btn-default not-round"> <span class="glyphicon glyphicon-search"></span> </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12"> <div class="results"> </div> </div>
                </div>
            </div>
        </div>
    </div>
</div>
