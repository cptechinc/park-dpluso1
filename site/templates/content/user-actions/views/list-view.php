<div>
	<div class="panel-body">
		<form action="<?= $actionpanel->generate_clearfilterurl(); ?>" method="GET" class="form-ajax" data-loadinto="<?= $actionpanel->loadinto; ?>" data-focus="<?= $actionpanel->focus; ?>">
			<input type="hidden" name="filter" value="filter">
			<div class="row">
				<div class="col-sm-2 form-group">
		            <h4>Action Type(s)</h4>
		            <?php foreach ($appconfig->child('name=actions')->child('name=types')->children() as $actiontype) : ?>
		                <label><?= $actiontype->title; ?></label>
		    			<input class="pull-right" type="checkbox" name="actiontype[]" value="<?= $actiontype->name; ?>" <?= ($actionpanel->has_filtervalue('actiontype', $actiontype->name)) ? 'checked' : ''; ?>></br>
		            <?php endforeach; ?>
		        </div>
				<div class="col-sm-2 form-group">
					<?php if ($appconfig->child('name=actions')->allow_changeuserview) : ?>
						<h4 id="actions-assignedto">Assigned To</h4>
						<select name="assignedto[]" class="selectpicker show-tick form-control input-sm" aria-labelledby="#actions-assignedto" data-style="btn-default btn-sm" multiple>
							<?php foreach ($salespersoncodes as $salespersoncode) : ?>
								<?php $selected = ($actionpanel->has_filtervalue('assignedto', $salespersonjson['data'][$salespersoncode]['splogin'])) ? 'selected' : ''; ?>
								<?php if (!empty($salespersonjson['data'][$salespersoncode]['splogin'])) : ?>
									<option value="<?= $salespersonjson['data'][$salespersoncode]['splogin']; ?>" <?= $selected; ?>><?= $salespersoncode.' - '.$salespersonjson['data'][$salespersoncode]['spname']; ?></option>
								<?php endif; ?>
							<?php endforeach; ?>
						</select>
					<?php endif; ?>
				</div>
				<div class="col-sm-2">
					<h4>Date Created</h4>
					<?php $name = 'datecreated[]'; $value = $actionpanel->get_filtervalue('datecreated'); ?>
					<?php include $config->paths->content."common/date-picker.php"; ?>
					<label class="small text-muted">From Date </label>
					<?php $name = 'datecreated[]'; $value = $actionpanel->get_filtervalue('datecreated', 1); ?>
					<?php include $config->paths->content."common/date-picker.php"; ?>
					<label class="small text-muted">Through Date </label>
				</div>
				<div class="col-sm-2">
					<h4>Date Completed</h4>
					<?php $name = 'datecompleted[]'; $value = $actionpanel->get_filtervalue('datecompleted'); ?>
					<?php include $config->paths->content."common/date-picker.php"; ?>
					<label class="small text-muted">From Date </label>
					<?php $name = 'datecompleted[]'; $value = $actionpanel->get_filtervalue('datecompleted', 1); ?>
					<?php include $config->paths->content."common/date-picker.php"; ?>
					<label class="small text-muted">Through Date </label>
				</div>
				<div class="col-sm-4 form-group">
					<label>Table Legend</label>
					<br>
					<?= $actionpanel->generate_legend(); ?>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6">
					<button type="submit" class="btn btn-sm btn-success btn-block"><i class="fa fa-filter" aria-hidden="true"></i> Apply Filter</button>
				</div>
				<div class="col-xs-6">
					<?php if ($input->get->filter) : ?>
						<a href="<?= $actionpanel->generate_clearfilterurl(); ?>" class="btn btn-sm btn-warning btn-block load-link" data-loadinto="<?= $actionpanel->loadinto; ?>" data-focus="<?= $actionpanel->focus; ?>"><i class="fa fa-times" aria-hidden="true"></i> Clear Filter</a>
					<?php endif; ?>
				</div>
			</div>
		</form>
	</div>
	<div class="table-responsive">
		<?php include $config->paths->content."user-actions/views/$actionpanel->paneltype/list/tables/$actionpanel->actiontype.php"; ?>
	</div>
	<?= $paginator; ?>
</div>
