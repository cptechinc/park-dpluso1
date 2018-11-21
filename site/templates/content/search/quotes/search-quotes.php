<?php
	$quotepanel = new RepQuotePanel(session_id(), $page->fullURL, '#ajax-modal', "#quotes-panel", $config->ajax);
	$quotepanel->pagenbr = $input->pageNum;
	$quotepanel->activeID = !empty($input->get->qnbr) ? $input->get->text('qnbr') : false;
	$quotepanel->get_quotecount();
	
	$paginator = new Dplus\Content\Paginator($quotepanel->pagenbr, $quotepanel->count, $quotepanel->pageurl->getUrl(), $quotepanel->paginationinsertafter, $quotepanel->ajaxdata);
?>

    <div class="row">
        <div class="col-sm-2"> 
            <form action="<?php echo $page->fullURL->getUrl(); ?>" method="get" id="quote-search-form" data-loadinto="#quotes-panel" data-focus="#quotes-panel" data-modal="#ajax-modal" class="fuelux">
                <input type="hidden" name="filter" value="filter">
                <h4>Quote # :</h4>
                <input class="form-control form-group inline input-sm" type="text" name="quoteno-low" value="" placeholder="From Quote #">
                <input class="form-control form-group inline input-sm" type="text" name="quoteno-high" value="" placeholder="Through Quote #">
            
                <h4>Quote Total :</h4>
                <input class="form-control form-group inline input-sm" type="text" name="quote-total-low" value="" placeholder="From Quote Total">
                <input class="form-control form-group inline input-sm" type="text" name="quote-total-high" value="" placeholder="Through Quote Total">
            
                <h4>Quote Date :</h4>
                <label class="control-label">From Date </label>
                <?php $name = 'date-from'; $value=""; ?>
                <?php include $config->paths->content."common/date-picker.php"; ?>
                <label class="control-label">Through Date </label>
                <?php $name = 'date-through'; $value=""; ?>
                <?php include $config->paths->content."common/date-picker.php"; ?></br>

                <h4>Review Date :</h4>
                <label class="control-label">From Date </label>
                <?php $name = 'date-from'; $value=""; ?>
                <?php include $config->paths->content."common/date-picker.php"; ?>
                <label class="control-label">Through Date </label>
                <?php $name = 'date-through'; $value=""; ?>
                <?php include $config->paths->content."common/date-picker.php"; ?></br>
            
                <h4>Expire Date :</h4>
                <label class="control-label">From Date </label>
                <?php $name = 'date-from'; $value=""; ?>
                <?php include $config->paths->content."common/date-picker.php"; ?>
                <label class="control-label">Through Date </label>
                <?php $name = 'date-through'; $value=""; ?>
                <?php include $config->paths->content."common/date-picker.php"; ?></br>
                
                <div class="form-group">
                	<button class="btn btn-success btn-block" type="submit">Search</button>
                </div>
            </form>
        </div>
        <div class="col-sm-10">
            <table class="table table-striped table-bordered table-condensed" id="quotes-table">
            	<thead>
                   <?php include $config->paths->content.'salesrep/quotes/quotes-thead-rows.php'; ?>
                </thead>
            	<tbody>
            		<?php if ($quotepanel->count == 0 && $input->get->text('qnbr') == '') : ?>
            			<tr> <td colspan="8" class="text-center">No Quotes found! Try using a date range to find the quotes(s) you are looking for.</td> </tr>
            		<?php endif; ?>

            		<?php $quotepanel->get_quotes(); ?>
            		<?php foreach ($quotepanel->quotes as $quote) : ?>
            			<tr class="<?= $quote->quotnbr == $input->get->text('qnbr') ? 'selected' : ''; ?>" id="<?= $quote->quotnbr; ?>">
            				<td class="text-center">
								<?php if ($quote->quotnbr == $input->get->text('qnbr')) : ?>
									<a href="<?= $quotepanel->generate_closedetailsurl($quote); ?>" class="btn btn-sm btn-primary load-link" <?= $quotepanel->ajaxdata; ?>>
										<i class="fa fa-minus" aria-hidden="true"></i> <span class="sr-only">Close <?= $quote->quotnbr; ?> Details</span>
									</a>
								<?php else : ?>
									<a href="<?= $quotepanel->generate_loaddetailsurl($quote); ?>" class="btn btn-sm btn-primary generate-load-link" <?= $quotepanel->ajaxdata; ?>>
										<i class="fa fa-plus" aria-hidden="true"></i> <span class="sr-only">Load <?= $quote->quotnbr; ?> Details</span>
									</a>
								<?php endif; ?>
            				</td>
            				<td><?= $quote->quotnbr; ?></td>
            				<td><a href="<?= $quotepanel->generate_customerurl($quote); ?>"><?= $quote->custid; ?></a> <span class="glyphicon glyphicon-share" aria-hidden="true"></span><br><?= Customer::get_customernamefromid($quote->custid); ?></td>
            				<td><?= $quote->shiptoid; ?></td>
            				<td><?= $quote->quotdate; ?></td>
            				<td><?= $quote->revdate; ?></td>
            				<td><?= $quote->expdate; ?></td>
            				<td class="text-right">$ <?= $quote->subtotal; ?></td>
            				<td><?= $quotepanel->generate_loaddplusnoteslink($quote, '0'); ?></td>
            				<td><?= $quotepanel->generate_editlink($quote); ?></td>
            			</tr>

            			<?php if ($quote->quotnbr == $input->get->text('qnbr')) : ?>
            				<?php if ($quote->error == 'Y') : ?>
            	                <tr class="detail bg-danger" >
            	                    <td></td>
            						<td></td>
            	                    <td colspan="3"><b>Error: </b><?= $quote->errormsg; ?></td>
            	                    <td></td>
            	                    <td></td>
            						<td></td>
            						<td></td>
            	                </tr>
            	            <?php endif; ?>
            				<?php include $config->paths->content."salesrep/quotes/quote-detail-rows.php"; ?>
            				<?php include $config->paths->content."salesrep/quotes/quote-totals.php"; ?>
            				<tr class="detail last-detail">
            					<td></td>
            					<td></td>
            					<td> <?= $quotepanel->generate_viewprintlink($quote); ?> </td>
            					<td> <?= $quotepanel->generate_orderquotelink($quote); ?> </td>
            					<td></td>
            					<td></td>
            					<td></td>
            					<td></td>
            					<td><a href="<?= $quotepanel->generate_closedetailsurl(); ?>" class="btn btn-sm btn-danger load-link" <?= $quotepanel->ajaxdata; ?>>Close</a></td>
            					<td></td>
            				</tr>
            			<?php endif; ?>
            		<?php endforeach; ?>
            	</tbody>
            </table>
        </div>
    </div> 
