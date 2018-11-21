<?php
	$print = $input->get->text('view') == 'print' ? true : false;
	
	$iiusageformatter = $page->screenformatterfactory->generate_screenformatter('ii-usage');
	$iiusageformatter->set_printpage($print);
	$iiusageformatter->process_json();
	
	$iinotesformatter = $page->screenformatterfactory->generate_screenformatter('ii-notes');
	$iinotesformatter->set_printpage($print);
	$iinotesformatter->process_json();
	
	$iimiscformatter = $page->screenformatterfactory->generate_screenformatter('ii-misc');
	$iimiscformatter->set_printpage($print);
	$iimiscformatter->process_json();
	
	if ($config->ajax) {
		$url = new Purl\Url($page->fullURL->getUrl());
		$url->query->set('view', 'print');
		echo $page->bootstrap->create_element('p', '', $page->bootstrap->generate_printlink($url->getUrl(), 'View Printable Version'));
	}

	$iiusageformatter->generate_iteminfotable();
 ?>

<!-- if print screen goes to else statement -->
<?php if ($config->ajax) : ?>
	<div>
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#usage" aria-controls="usage" role="tab" data-toggle="tab">Usage</a></li>
			<li role="presentation"><a href="#notes" aria-controls="notes" role="tab" data-toggle="tab">Notes</a></li>
			<li role="presentation"><a href="#misc" aria-controls="misc" role="tab" data-toggle="tab">Misc</a></li>
		</ul>

		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="usage">
				<br>
				<?= $iiusageformatter->process_andgeneratescreen(); ?>
			</div>
			<div role="tabpanel" class="tab-pane" id="notes">
				<br>
				<?= $iinotesformatter->process_andgeneratescreen(); ?>
			</div>
			<div role="tabpanel" class="tab-pane" id="misc">
				<br>
				<?= $iimiscformatter->process_andgeneratescreen(); ?>
			</div>
		</div>
	</div>
	<?= $iiusageformatter->generate_javascript(); ?>
<?php else : ?>
	<h2 class="page-header">Usage</h2>
	<div id="usage">
		<?= $iiusageformatter->process_andgeneratescreen(); ?>
	</div>
	<h2 class="page-header">Notes</h2>
	<div id="notes">
		<?= $iinotesformatter->process_andgeneratescreen(); ?>
	</div>
	<h2 class="page-header">Misc</h2>
	<div id="misc">
		<?= $iimiscformatter->process_andgeneratescreen(); ?>
	</div>
<?php endif; ?>
