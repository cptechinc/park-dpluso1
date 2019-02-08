<?php
    $cartdisplay = new Dplus\Dpluso\OrderDisplays\CartDisplay(session_id(), $page->fullURL, '#ajax-modal');
    $cart = $cartdisplay->get_cartquote();

    if (!(empty($cart->custid))) {
        $custID = $cart->custid;
        $shipID = $cart->shiptoid;
        $itemlookup->set_customer($custID, $shipID);
        $page->pagetitle = "Quick Entry for ".Customer::get_customernamefromid($custID);
        $noteurl = $config->pages->notes.'redir/?action=get-cart-notes';
        $config->scripts->append(get_hashedtemplatefileURL('scripts/pages/cart.js'));
    	$config->scripts->append(get_hashedtemplatefileURL('scripts/edit/edit-pricing.js'));

        if ($modules->isInstalled('CaseQtyBottle')) {
            $config->scripts->append(get_hashedmodulefileURL('CaseQtyBottle/js/quick-entry.js'));
        } else {
            $config->scripts->append(get_hashedtemplatefileURL('scripts/edit/quick-entry.js'));
        }
    	$page->body = $config->paths->content.'cart/cart-outline.php';
    } else {
        $page->pagetitle = 'Choose a Customer';
        $input->get->function = 'cart';
        $dplusfunction = 'ca';
        $page->body = $config->paths->content."customer/ajax/load/cust-index/search-form.php";
    }

	include $config->paths->content."common/include-page.php";
?>
