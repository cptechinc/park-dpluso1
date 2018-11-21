<div class="col-md-12">
	<?php if ($config->ajax) : ?>
		<?php echo $page->bootstrap->create_element('p', '', $page->bootstrap->generate_printlink($config->filename, 'View Printable Version')); ?>
		<ul class="nav nav-tabs nav_tabs">
			<li class="active"><a href="#vendor" data-toggle="tab" aria-expanded="true">Vendor Costs</a></li>
			<li><a href="#subs" data-toggle="tab" aria-expanded="false">Substitutions</a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane fade active in" id="vendor">
				<br><?php include $config->paths->content."vend-information/vend-cost-sub.php"; ?></p>
			</div>
			<div class="tab-pane fade" id="subs"><br><?php include $config->paths->content."vend-information/vend-sub.php"; ?></div>
		</div>
	<!-- for print screen -->
	<?php else : ?>
		<div>
			<h2>Vendor Costs</h2>
			<div id="vendor">
				<br><?php include $config->paths->content."vend-information/vend-cost-sub.php"; ?></p>
			</div>
		</br>
		<hr>
			<h2>Substitutions</h2>
			<div id="subs"><br><?php include $config->paths->content."vend-information/vend-sub.php"; ?></div>
		</div>
	<?php endif; ?>
		
</div>
