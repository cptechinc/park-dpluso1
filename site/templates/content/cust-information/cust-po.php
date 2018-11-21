<div>
	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#salesorders" aria-controls="salesorders" role="tab" data-toggle="tab">Sales Orders</a></li>
		<li role="presentation"><a href="#saleshistory" aria-controls="saleshistory" role="tab" data-toggle="tab">Sales History</a></li>
	</ul>

	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="salesorders">
			<br>
			<?php
				$tableformatter = $page->screenformatterfactory->generate_screenformatter('ci-sales-orders');
				include $config->paths->content."cust-information/ci-formatted-screen.php";
			?>
		</div>
		<div role="tabpanel" class="tab-pane" id="saleshistory">
			<br>
			<?php
				$tableformatter = $page->screenformatterfactory->generate_screenformatter('ci-sales-history');
				include $config->paths->content."cust-information/ci-formatted-screen.php";
			?>
		</div>
	</div>
</div>
