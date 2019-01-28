<div id="yt-menu" class="row">
	<div class="col-xs-12">
		<br>
		<nav>
			<?php 
				switch ($user->mainrole) {
					case 'sales-rep':
						include $config->paths->content."nav/nav-by-role/sales-rep.php";
						break;
					case 'sales-manager':
						include $config->paths->content."nav/nav-by-role/sales-manager.php";
						break;
					case 'warehouse':
						include $config->paths->content."nav/nav-by-role/warehouse.php";
						break;
					case 'warehouse-manager':
						include $config->paths->content."nav/nav-by-role/warehouse.php";
						break;
					default: 
						include $config->paths->content."nav/nav-by-role/default.php";
						break;
				}
			?>
		</nav>
    </div>
</div>
