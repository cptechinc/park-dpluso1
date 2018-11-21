<table class="table table-striped table-bordered table-condensed table-excel" id="<?= urlencode($whse['Whse Name']); ?>">
	<thead>
		<?php for ($x = 1; $x < $table['detail']['maxrows'] + 1; $x++) : ?>
			<tr>
				<?php for ($i = 1; $i < $table['maxcolumns'] + 1; $i++) : ?>
					<?php if (isset($table['detail']['rows'][$x]['columns'][$i])) : ?>
						<?php $column = $table['detail']['rows'][$x]['columns'][$i]; ?>
						<th class="<?= $config->textjustify[$fieldsjson['data']['detail'][$column['id']]['headingjustify']]; ?>"><?= $column['label']; ?></th>
					<?php else : ?>
						<th></th>
					<?php endif; ?>
				<?php endfor; ?>
			</tr>
		<?php endfor; ?>
	</thead>
	<tbody>
		<?php foreach($whse['orders'] as $order) : ?>
			<?php for ($x = 1; $x < $table['detail']['maxrows'] + 1; $x++) : ?>
				<tr>
					<?php for ($i = 1; $i < $table['maxcolumns'] + 1; $i++) : ?>
						<?php if (isset($table['detail']['rows'][$x]['columns'][$i])) : ?>
							<?php $column = $table['detail']['rows'][$x]['columns'][$i]; ?>
							<td class="<?= $config->textjustify[$fieldsjson['data']['detail'][$column['id']]['datajustify']]; ?>">
								<?= generatecelldata($fieldsjson['data']['detail'][$column['id']]['type'],$order, $column, false); ?>
							</td>
						<?php else : ?>
							<td></td>
						<?php endif; ?>
					<?php endfor; ?>
				</tr>
			<?php endfor; ?>
		<?php endforeach; ?>
	</tbody>
	<tfoot>
		<?php $order = $whse['orders']['TOTAL']; ?>
		<?php for ($x = 1; $x < $table['detail']['maxrows'] + 1; $x++) : ?>
			<tr>
				<?php for ($i = 1; $i < $table['maxcolumns'] + 1; $i++) : ?>
					<?php if (isset($table['detail']['rows'][$x]['columns'][$i])) : ?>
						<?php $column = $table['detail']['rows'][$x]['columns'][$i]; ?>
						<td class="<?= $config->textjustify[$fieldsjson['data']['detail'][$column['id']]['datajustify']]; ?>">
							<?= generatecelldata($fieldsjson['data']['detail'][$column['id']]['type'],$order, $column, false); ?>
						</td>
					<?php else : ?>
						<td></td>
					<?php endif; ?>
				<?php endfor; ?>
			</tr>
		<?php endfor; ?>
	</tfoot>
</table>
