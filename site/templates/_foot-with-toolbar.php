		<br>
        <div class="container hidden-print">
          <?php if ($toolbar) : ?>
			   <div class="row">
					<div class="col-xs-12">
						<button id="show-toolbar" class="btn btn-rounded btn-success show-toolbar hidden-md hidden-lg" type="button">
							<i class="fa fa-th-large" aria-hidden="true"></i>
							<span class="sr-only">Menu</span>
						</button>
					</div>
				</div>
            <?php endif; ?>
            <div class="row">
                <div class="col-xs-12">
                    <button id="back-to-top" class="btn btn-success back-to-top" type="button">
						<i class="fa fa-chevron-up" aria-hidden="true"></i>
						<span class="sr-only">Go Back to the Top</span>
                    </button>
                </div>
            </div>
        </div>
        <footer class="hidden-print">
            <div class="container">
                <p> Web Development by CPTech &copy; <?= date('Y'); ?> --------- <?= session_id(); ?> --- </p>
                <p class="visible-xs-inline-block"> XS </p> <p class="visible-sm-inline-block"> SM </p>
                <p class="visible-md-inline-block"> MD </p> <p class="visible-lg-inline-block"> LG </p>
            </div>
        </footer>
        <?php if ($toolbar) {include $toolbar; } ?>
		<?php include $config->paths->content."common/modals/ajax-modal.php"; ?>
		<?php include $config->paths->content."common/modals/lightbox-modal.php"; ?>
		<?php include $config->paths->content."common/modals/item-lookup-modal.php"; ?>
		<?php include $config->paths->content.'common/phpjs/js-config.js.php'; ?>
        <?php foreach($config->scripts->unique() as $script) : ?>
        	<script src="<?php echo $script; ?>"></script>
        <?php endforeach; ?>
		<?php include $config->paths->content."common/phpjs/add-to-cart-msg.js.php"; ?>
		<?php include $config->paths->content."common/phpjs/new-shopping-customer-msg.js.php"; ?>
    </body>
</html>
