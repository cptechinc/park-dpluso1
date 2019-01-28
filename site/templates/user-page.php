<?php include('./_head.php'); ?>
	<div class="jumbotron pagetitle">
		<div class="container">
			<h1><?php echo $page->get('pagetitle|headline|title') ; ?></h1>
		</div>
	</div>
	<div class="container page">
		<div class="row">
			<div class="col-sm-3 col-md-3 col-lg-3 account">
				<div class="profile bg-info">
					<p class="text-center"><i class="material-icons md-48">&#xE853;</i></p>
					<p class="text-center"><?= $user->fullname; ?></p>
					<p class="text-center"><?= $user->loginid; ?></p>
				</div>
				<ul class="list-group">
					<?php if ($users->find("name=$user->loginid")->count) : ?>
						<?php if ($users->get("name=$user->loginid")->hasPermission('setup-screen-formatter')) : ?>
							<a href="<?= $config->pages->tableformatters; ?>" class="list-group-item">Screen Configurations</a>
						<?php endif; ?>
					<?php else : ?>
						<?php if ($appconfig->allow_userscreenformatter) : ?>
							<a href="<?= $config->pages->tableformatters; ?>" class="list-group-item">Screen Configurations</a>
						<?php endif; ?>
					<?php endif; ?>
					<a href="<?= $config->pages->account.'redir/?action=logout'; ?>" class="list-group-item logout">
						<span class="glyphicon glyphicon-log-out"></span> Log Out
					</a>
				</ul>
			</div>
		</div>
	</div>
<?php include('./_foot.php'); // include footer markup ?>
