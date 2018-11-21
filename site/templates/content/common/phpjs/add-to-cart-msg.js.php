<?php if ($session->addtocart) : ?>
	<script>
        $(function() {
            $.notify({
                icon: "glyphicon glyphicon-shopping-cart",
                message: "<?= $session->addtocart; ?> <br> (Click this Message to go to the cart.)" ,
                url: "<?= $config->pages->cart; ?>",
                target: '_self'
            },{
                type: "success",
                url_target: '_self'
            });
        });
    </script>
    <?php $session->remove('addtocart'); ?>
<?php endif; ?>
