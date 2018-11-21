<form action="<?= $config->pages->ajax."load/customers/contacts/"; ?>" method="POST" id="cust-contact-search-form" class="allow-enterkey-submit">
	<input type="hidden" name="custID" value="<?= $input->get->text('custID'); ?>">
	<input type="hidden" name="shipID" value="<?= $input->get->text('shipID'); ?>">
    <div class="form-group">
        <?php if ($input->get->function) : ?>
        	<input type="hidden" name="function" class="function" value="<?= $input->get->text('function'); ?>">
        <?php endif; ?>
        <div class="input-group">
            <input type="text" class="form-control" name="q" placeholder="Type customer phone, name, ID, contact">
            <span class="input-group-btn">
            	<button type="submit" class="btn btn-default not-round"> <span class="glyphicon glyphicon-search" aria-hidden="true"></span> <span class="sr-only">Search</span> </button>
            </span>
        </div>
    </div>
    <div>
        <?php
            if (!empty($input->get->q) || !empty($input->get->function)) {
                switch ($function) {
                    case 'eqo-contact':
                        include $config->paths->content."customer/ajax/load/contacts/order-contacts-list.php";
                        break;
					case 'eso-contact':
						include $config->paths->content."customer/ajax/load/contacts/order-contacts-list.php";
						break;
                }
            } else {
                include $config->paths->content."customer/ajax/load/contacts/order-contacts-list.php";
            }
        ?>
    </div>
</form>
