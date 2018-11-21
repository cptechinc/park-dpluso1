<div class="modal fade" id="item-info-modal" tabindex="-1" role="dialog" aria-labelledby="item-info-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="item-info-modal-label"><?= "Order $pickitem->ordernbr Line $pickitem->linenbr Info"; ?></h4>
            </div>
            <div class="modal-body">
                <table class="table">
                    <tr> 
                        <td class="control-label">Item ID</td> <td><?= $pickitem->itemid; ?></td>
                    </tr>
                    <tr> 
                        <td class="control-label">Desc1 </td> <td><?= $pickitem->itemdesc1; ?></td>
                    </tr>
                    <tr> 
                        <td class="control-label">Inner Pack Qty</td> <td><?= $pickitem->innerpack; ?></td>
                    </tr>
                    <tr> 
                        <td class="control-label">Case Qty</td> <td><?= $pickitem->caseqty; ?></td>
                    </tr>
                    <tr>
            			<td class="control-label">Bin #</td> <td><?= $pickitem->bin; ?></td>
            		</tr>
            		<tr>
            			<td class="control-label">Expected Qty</td> <td><?= $pickitem->binqty; ?></td>
            		</tr>
                    <tr> 
                        <td class="control-label">Over Bin 1: <?= $pickitem->overbin1; ?></td> <td><?= $pickitem->overbinqty1; ?></td>
                    </tr>
                    <tr> 
                        <td class="control-label">Over Bin 2: <?= $pickitem->overbin2; ?></td> <td><?= $pickitem->overbinqty2; ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
