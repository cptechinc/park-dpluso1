<ul class="nav list-unstyled">
	<?php if ($user->loggedin) : ?>
		<li class="welcome"><a href="#">Welcome, <?= $user->fullname; ?></a> </li>
	<?php endif; ?>
	<li> <a href="#"><?= $appconfig->companydisplayname; ?></a> </li>

	<li> <a href="<?= $config->user_roles[$user->mainrole]['homepage']; ?>"><i class="glyphicon glyphicon-home"></i> Home</a> </li>

	<?php if ($user->hasPermission('can-run-reports')) : ?>
		<li> <a href="<?= $config->pages->reports; ?>"> <i class="glyphicon glyphicon-duplicate"></i> Reports</a> </li>
	<?php endif; ?>

	<?php if ($config->cptechcustomer != 'stat') : ?>
		<li> <a href="<?= $config->pages->cart; ?>"> <i class="glyphicon glyphicon-list-alt"></i> Quick Entry (<?php //echo get_cart_count(session_id()); ?>)</a> </li>
	<?php endif; ?>

	<li class="divider"></li>
	<?php if (has_dpluspermission($user->loginid, 'ci')) : ?>
		<li> <a href="<?= $config->pages->custinfo; ?>"><i class="fa fa-users" aria-hidden="true"></i> Customers</a> </li>
	<?php endif; ?>
	<?php if (has_dpluspermission($user->loginid, 'ii')) : ?>
		<li> <a href="<?= $config->pages->iteminfo; ?>"><i class="fa fa-diamond" aria-hidden="true"></i> Items</a> </li>
	<?php endif; ?>
	<?php if (has_dpluspermission($user->loginid, 'vi')) : ?>
		<li><a href="<?= $config->pages->vendorinfo; ?>"><i class="fa fa-cubes" aria-hidden="true"></i> Vendors</a></li>
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
