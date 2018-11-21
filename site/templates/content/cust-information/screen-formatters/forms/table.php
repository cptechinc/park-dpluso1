<table class="table table-striped table-bordered table-condensed table-sm">
	<thead>
		<tr> <th>Field</th> <th>Field Definition</th> <th>Line</th> <th>Column</th> <th>Column Length</th> <th>Column Label</th> <th class="hidden"></th> </tr>
	</thead>
	<?php foreach (array_keys($tableformatter->fields['data'][$datasection]) as $column) : ?>
		<?php $name = str_replace(' ', '', $column); ?>
		<tr>
			<td class="field"><?= $column; ?></td>
			<td>
				<?php if ($tableformatter->fields['data'][$datasection][$column]['type'] == 'D') : ?>
					<select class="form-control input-sm" name="<?= $name."-date-format";?>">
						<?php foreach ($tableformatter->datetypes as $key => $value) : ?>
							<?php if ($key == $tableformatter->formatter[$datasection]['columns'][$column]['date-format']) : ?>
								<option value="<?= $key; ?>" selected><?= $value . ' - '. date($key); ?></option>
							<?php else : ?>
								<option value="<?= $key; ?>"><?= $value . ' - '. date($key); ?></option>
							<?php endif; ?>
						<?php endforeach; ?>
					</select>
				<?php elseif ($tableformatter->fields['data'][$datasection][$column]['type'] == 'I') : ?>
					Integer
				<?php elseif ($tableformatter->fields['data'][$datasection][$column]['type'] == 'C') : ?>
					Text
				<?php elseif ($tableformatter->fields['data'][$datasection][$column]['type'] == 'N') : ?>
					<div>
						Before Decimal &nbsp;
						<input type="text" class="form-control inline input-sm qty-sm before-decimal" name="<?= $name."-before-decimal";?>" value="<?= $tableformatter->formatter[$datasection]['columns'][$column]['before-decimal']; ?>"> &nbsp; &nbsp;
						After Decimal &nbsp;  
						<input type="text" class="form-control inline input-sm qty-sm after-decimal" name="<?= $name."-after-decimal";?>" value="<?= $tableformatter->formatter[$datasection]['columns'][$column]['after-decimal']; ?>">
						<span class="display"></span>
					</div>
				<?php endif; ?>
			</td>
			<?php $columndefinition = array_key_exists($column, $tableformatter->formatter[$datasection]['columns']) ? $tableformatter->formatter[$datasection]['columns'][$column] : $tableformatter->get_defaultformattercolumn(); ?>
			<td><input type="text" class="form-control input-sm qty-sm <?= $datasection; ?>-line" name="<?= $name."-line";?>" value="<?= $columndefinition['line']; ?>"></td>
			<td><input type="text" class="form-control input-sm qty-sm column" name="<?= $name."-column";?>" value="<?= $columndefinition['column']; ?>"></td>
			<td><input type="text" class="form-control input-sm qty-sm column-length" name="<?= $name."-length";?>" value="<?= $columndefinition['col-length']; ?>"></td>
			<td><input type="text" class="form-control input-sm col-label" name="<?= $name."-label";?>" value="<?= $columndefinition['label']; ?>"></td>
		</tr>
	<?php endforeach; ?>
</table>
