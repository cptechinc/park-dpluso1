<?php
	$salespersonjson = json_decode(file_get_contents($config->companyfiles."json/salespersontbl.json"), true);
	$salespersoncodes = array_keys($salespersonjson['data']);
	$paginator = new Dplus\Content\Paginator($actionpanel->pagenbr, $actionpanel->count_actions(), $actionpanel->generate_refreshurl(), $actionpanel->paginateafter, $actionpanel->ajaxdata);

	$actionpanel->set_view($input->get->text('view'));
?>
<div class="panel panel-primary not-round" id="<?= $actionpanel->panelID; ?>">
	<div class="panel-heading not-round" id="<?= $actionpanel->panelID.'-heading'; ?>">
		<a href="#actions-panel-body" class="panel-link" data-parent="<?= $actionpanel->panelID; ?>" data-toggle="collapse">
			<span class="glyphicon glyphicon-check"></span> &nbsp; <?= $actionpanel->generate_title(); ?> <span class="caret"></span>  &nbsp;&nbsp;<span class="badge"><?= $actionpanel->count; ?></span>
		</a>

		<?php if ($actionpanel->should_haveaddlink()) : ?>
			<?= $actionpanel->generate_addlink(); ?>
		<?php endif; ?>

		<span class="pull-right">&nbsp; &nbsp;&nbsp; &nbsp;</span>
		<?= $actionpanel->generate_refreshlink(); ?>
		<span class="pull-right"><?= $actionpanel->generate_pagenumberdescription(); ?> &nbsp; &nbsp;</span>
	</div>
	<div class="<?= $actionpanel->collapse; ?>" id="actions-panel-body">
		<?php
			switch ($actionpanel->view) {
				case 'day':
					include $config->paths->content."user-actions/views/day-view.php";
					break;
				case 'list':
					include $config->paths->content."user-actions/views/list-view.php";
					break;
				case 'calendar':
					include $config->paths->content."user-actions/views/calendar-view.php";
					break;
				default:
					include $config->paths->content."user-actions/views/day-view.php";
					break;
			}
		?>
	</div>
</div>
<script>
	$(function() {
		<?php if (!empty($actionpanel->filters['assignedto'])) : ?>
			$('.selectpicker[name="assignedto[]"]').selectpicker('val', <?= json_encode($actionpanel->filters['assignedto']); ?>);
		<?php endif; ?>

		$("body").on("click", "[name='actiontype[]']", function(e) {
			var checkbox = $(this);
			var form = checkbox.closest('form');

			if (checkbox.is(':checked')) {
				if (checkbox.val() == 'all') {
					form.find("[name='actiontype[]']").not("[value='all']").prop('checked', true);
				} else {
					form.find("[name='actiontype[]'][value='all']").prop('checked', false);
				}
			}
		});

		<?php if ($config->ajax) : ?>
			$('.selectpicker[name="assignedto"]').selectpicker();
		<?php endif; ?>

		$('body').on('changed.bs.select', '.selectpicker[name="assignedto[]"]', function (e) {
			console.log($(this).val());
		});
	});
</script>
