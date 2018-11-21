<div id="slide-menu" class="row">
	<div class="col-xs-12">
		<?php if ($user->loggedin) : ?>

		<?php else : ?>
			<br>
		<?php endif; ?>
		<nav>
			<ul class="nav list-unstyled">
				<?php if ($user->loggedin) : ?>
					<li class="welcome"><a href="#">Welcome, <?php echo $user->fullname ?></a> </li>
				<?php else : ?>

				<?php endif; ?>

				<li> <a href="<?php echo $config->pages->index; ?>"><i class="glyphicon glyphicon-home"></i> Home</a> </li>
				<li> <a href="<?php echo $config->pages->customer; ?>"><i class="material-icons">&#xE7FB;</i> Customers</a> </li>
				<li> <a href="<?php echo $config->pages->dashboard; ?>"><i class="glyphicon glyphicon-blackboard"></i> Dashboard</a> </li>
				<li> <a href="<?php echo $config->pages->account; ?>"><i class="material-icons">&#xE851;</i> Account</a> </li>
				<li> <a href="<?php echo $config->pages->iteminfo; ?>"><i class="material-icons">&#xE051;</i> Item Info</a> </li>
				<li> <a href="<?php echo $config->pages->cart; ?>"> <i class="glyphicon glyphicon-list-alt"></i> Quick Entry (<?php //echo get_cart_count(session_id()); ?>)</a> </li>
				<li class="divider"></li>
				<li class="dropdown-header">Categories</li>
				<?php if ($user->loggedin) : ?>
				<li class="logout">
					<a href="<?php echo $config->pages->account; ?>redir/?action=logout">
						<span class="glyphicon glyphicon-log-out"></span> Logout
					</a>
				</li>
				<?php endif; ?>
			</ul>
		</nav>
    </div>
</div>
