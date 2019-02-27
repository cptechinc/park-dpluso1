<div class="modal fade" id="select-bin-modal" tabindex="-1" role="dialog" aria-labelledby="select-bin-modal-label" data-input="">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="select-bin-modal-label">Select bin</h4>
			</div>
			<div class="modal-body">
                <div>
                    <h4>All Bins</h4>
                    <?php if ($whseconfig->are_binslisted()) : ?>
                        <div class="list-group">
                            <?php $list = $whseconfig->get_binlist(); ?>
                            <?php foreach ($list as $listedbin) : ?>
                                <a href="#" class="list-group-item select-bin" data-bin="<?= $listedbin->from; ?>">
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <h5 class="list-group-item-heading"><?= $listedbin->from; ?></h5>
                                        </div>
                                    </div>
                                    <p class="list-group-item-text"><?= $listedbin->bindesc;; ?></p>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php else : ?>
                        <?php $binranges = $whseconfig->get_binranges(); ?>
                        <table class="table table-condensed table-striped table-bordered">
                            <tr>
                                <th>Range From</th>
                                <th>Range Through</th>
                            </tr>
                            <?php foreach ($binranges as $binrange) : ?>
                                <tr>
                                    <td><?= $binrange->from; ?></td>
                                    <td><?= $binrange->through; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php endif; ?>
                </div>
			</div>
		</div>
	</div>
</div>
