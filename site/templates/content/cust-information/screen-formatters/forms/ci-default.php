<ol class="breadcrumb">
	<li><a href="<?= $page->parent->parent->url; ?>"><?= $page->parent->parent->title; ?></a></li>
	<li><a href="<?= $page->parent->url; ?>"><?= $page->parent->title; ?></a></li>
	<li class="active"><?= $page->title; ?></li>
</ol>
<div class="formatter-response">
	<div class="message"></div>
</div>
<form action="<?= $page->fullURL; ?>" method="POST" class="screen-formatter-form" id="screen-formatter-form">
    <input type="hidden" name="action" value="save-formatter">
	<input type="hidden" name="user" value="<?= $user->loginid; ?>">
	<div class="panel panel-default">
		<div class="panel-heading"><h3 class="panel-title"><?= $page->title; ?></h3> </div>
		<br>
		<div class="row">
			<div class="col-xs-12">
				<div class="formatter-container">
					<div>
						<ul class="nav nav-tabs" role="tablist">
							<?php foreach ($tableformatter->datasections as $datasection => $label) : ?>
								<?php $class = ($datasection == key($tableformatter->datasections)) ? 'active' : ''; ?>
								<li role="presentation" class="<?= $class; ?>"><a href="#<?= $datasection; ?>" aria-controls="<?= $datasection; ?>" role="tab" data-toggle="tab"><?= $label; ?></a></li>
							<?php endforeach; ?>
						</ul>
						<div class="tab-content">
							<?php foreach ($tableformatter->datasections as $datasection => $label) : ?>
								<?php $class = ($datasection == key($tableformatter->datasections)) ? 'active' : ''; ?>
								<div role="tabpanel" class="tab-pane <?= $class; ?>" id="<?= $datasection; ?>">
									<?php include $config->paths->content."cust-information/screen-formatters/forms/table.php";  ?>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<button type="button" class="btn btn-info" onclick="preview_tableformatter()"><i class="fa fa-table" aria-hidden="true"></i> Preview Table</button>
	<?php if ($pages->get('/config/')->allow_userscreenformatter) : ?>
		<button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-floppy-disk"></i> Save Configuration</button>
	<?php endif; ?>

	<?php if ($tableformatter->can_edit()) : ?>
		<button type="button" class="btn btn-emerald" onclick="save_tableformatterfor('default')"><i class="glyphicon glyphicon-floppy-disk"></i> Save as Default</button>
	<?php endif; ?>
</form>
