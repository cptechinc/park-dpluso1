		<?php include $config->paths->content.'common/phpjs/js-config.js.php'; ?>
		<?php foreach($config->scripts->unique() as $script) : ?>
        	<script src="<?php echo $script; ?>"></script>
        <?php endforeach; ?>
        <div id="loading-bkgd" class="modal-backdrop fade in"></div>
		<?php include $config->paths->content."common/modals/ajax-modal.php"; ?>
		<?php include $config->paths->content."common/modals/lightbox-modal.php"; ?>
		<?php include $config->paths->content."common/modals/item-lookup-modal.php"; ?>
    </body>
</html>
