<?php
	// top navigation consists of homepage and its visible children
	$homepage = $pages->get('/');
	$children = $homepage->children();

	// make 'home' the first item in the navigation
	$children->prepend($homepage);

	if ($config->debug) {
		$navbar = 'navbar-inverse';
	} else {
		$navbar = 'navbar-default';
	}
?>
<nav class="navbar <?php echo $navbar; ?> navbar-fixed-top" id="nav-yt">
	<div class="container">
		<div class="navbar-header">
			<a href="#" class=" navbar-brand yt-menu-open">
            	<i class="material-icons">&#xE5D2;</i>
            </a>
			<?php if (!$config->debug) : ?>
            	<a class="navbar-brand" href="#">TESTING - DEBUG</a>
            <?php else : ?>
				<img class="header-logo hidden-xs" id="header-logo" src="<?= $config->urls->files; ?>images/dplus.png" height="50">
				<img class="header-logo hidden-sm hidden-md hidden-lg" id="header-logo" src="<?= $config->urls->files; ?>images/dplus-short.png" height="50">
            <?php endif; ?>
			<img src="<?= $appconfig->companylogo->url; ?>" alt="<?= $appconfig->companydisplayname.' logo'; ?>" height="60" class="hidden-sm hidden-md hidden-lg pull-right">
		</div>


		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<?php foreach($homepage->and($homepage->children) as $child) : ?>
                	<?php if ($child->show_in_main_nav == 1) : ?>
						<?php if ($child->id == $page->rootParent->id) : ?>
                            <li class="active"><a href="<?php echo $child->url; ?>"><?php echo $child->title; ?></a></li>
                        <?php else : ?>
                            <li><a href="<?php echo $child->url; ?>"><?php echo $child->title; ?></a></li>
                        <?php endif; ?>
                    <?php endif; ?>
				<?php endforeach; ?>
			</ul>
            <ul class="nav navbar-nav navbar-right visible-sm-block">
				<li><img src="<?= $appconfig->companylogo->url; ?>" alt="<?= $appconfig->companydisplayname.' logo'; ?>" height="60"></li>
                <li>
                	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    	My Account <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                    	<li> <a href="<?php echo $config->pages->account; ?>">View My Account</a> </li>
                        <li><a href="<?php echo $config->pages->cart; ?>">Quick Entry</a></li>
                        <li role="separator" class="divider"></li>
						<?php if ($user->loggedin) : ?>
                            <li><a>Welcome, <?php echo $user->username; ?></a> </li>
                            <li>
                            	<a href="<?php echo $config->pages->account; ?>redir/?action=logout" class="logout"> <span class="glyphicon glyphicon-log-out"></span> Logout</a>
                            </li>
                        <?php else : ?>
                        <?php endif; ?>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right hidden-sm">
				<li><img src="<?= $appconfig->companylogo->url; ?>" alt="<?= $appconfig->companydisplayname.' logo'; ?>" height="60"></li>
                <?php //if($page->editable()) echo "<li class='edit'><a href='$page->editUrl'>Edit</a></li>"; ?>
                <?php if ($user->loggedin) : ?>
                    <li><a>Welcome, <?php echo $user->fullname; ?></a> </li>
                    <li>
                    	<a href="<?php echo $config->pages->account; ?>redir/?action=logout" class="logout"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
                    </li>
                <?php else : ?>

                <?php endif; ?>

          	</ul>
		</div><!--/.nav-collapse -->
	</div>
</nav>
