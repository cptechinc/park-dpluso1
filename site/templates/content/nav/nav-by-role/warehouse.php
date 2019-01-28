<ul class="nav list-unstyled">
	<?php if ($user->loggedin) : ?>
		<li class="welcome"><a href="#">Welcome, <?= $user->fullname; ?></a> </li>
	<?php endif; ?>
	<li> <a href="#"><?= $appconfig->companydisplayname; ?></a> </li>

	<li> <a href="<?= $config->user_roles[$user->mainrole]['homepage']; ?>"><i class="glyphicon glyphicon-home"></i> Home</a> </li>
	<li> <a href="<?= $page->fullURL->getUrl(); ?>"><i class="fa fa-refresh" aria-hidden="true"></i> Refresh</a> </li>
	
	<?php if (has_dpluspermission($user->loginid, 'wm')) : ?>
		<li> <a href="<?= $config->pages->warehouse; ?>"><i class="fa fa-building-o" aria-hidden="true"></i> Warehouse</a> </li>
	<?php endif; ?>
	
	<li class="divider"></li>
	<li> <a href="<?= $config->pages->documentation; ?>"> <i class="fa fa-book" aria-hidden="true"></i> Documentation</a> </li>
	<li> <a href="<?= $config->pages->user; ?>"><i class="fa fa-user-circle" aria-hidden="true"></i> User</a> </li>
	<li class="divider"></li>

	<?php if ($user->loggedin) : ?>
		<li class="logout">
			<a href="<?= $config->pages->account; ?>redir/?action=logout" class="logout">
				<span class="glyphicon glyphicon-log-out"></span> Logout
			</a>
		</li>
	<?php endif; ?>
</ul>
