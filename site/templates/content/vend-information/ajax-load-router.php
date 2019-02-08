<?php
    $shipID = '';
    switch ($input->urlSegment(2)) {
        case 'vi-open-invoices':
            $vendorID = $input->get->text('vendorID');
            $page->title = get_vendorname($vendorID) . ' Open Invoices';
            $tableformatter = $page->screenformatterfactory->generate_screenformatter('vi-open-invoices');
            $page->body = $config->paths->content."vend-information/vi-formatted-screen.php";
            break;
        case 'vi-payments':
            $vendorID = $input->get->text('vendorID');
            $page->title = get_vendorname($vendorID) . ' Payment';
            $tableformatter = $page->screenformatterfactory->generate_screenformatter('vi-payment-history');
            $page->body = $config->paths->content."vend-information/vi-formatted-screen.php";
            break;
        case 'vi-shipfrom':
            $vendorID = $input->get->text('vendorID');
            $page->title = get_vendorname($vendorID) . ' Ship-From Information';
            $page->body = $config->paths->content."vend-information/vend-shipfrom.php";
            break;
        case 'vi-purchase-history':
            $vendorID = $input->get->text('vendorID');
            $shipfromID = $input->get->text('shipfromID');
            if ($input->urlSegment(3) == 'form') {
				$page->title = 'Enter the Starting Report Date ';
				$page->body = $config->paths->content."vend-information/forms/purchase-history-form.php";
			} else {
                $page->title = get_vendorname($vendorID) . ' Purchase History';
                $tableformatter = $page->screenformatterfactory->generate_screenformatter('vi-purchase-history');
                $page->body = $config->paths->content."vend-information/vi-formatted-screen.php";
			}
            break;
        case 'vi-purchase-orders':
            $vendorID = $input->get->text('vendorID');
            $page->title = get_vendorname($vendorID) . ' Purchase Orders';
            $tableformatter = $page->screenformatterfactory->generate_screenformatter('vi-purchase-orders');
            $page->body = $config->paths->content."vend-information/vi-formatted-screen.php";
            break;
        case 'vi-contact':
            $vendorID = $input->get->text('vendorID');
            $page->title = get_vendorname($vendorID) . ' Contacts';
            $page->body = $config->paths->content."vend-information/vend-contact.php";
            break;
        case 'vi-notes':
            $vendorID = $input->get->text('vendorID');
            $page->title = get_vendorname($vendorID) . ' Notes';
            $page->body = $config->paths->content."vend-information/vend-notes.php";
            break;
        case 'vi-costing-search':
            $page->title = 'Search for an Item';
            $action = 'vi-costing';
            $vendorID = $input->get->text('vendorID');
            if ($input->get->q) {$q = $input->get->text('q'); $page->title = "Searching for '$q'";}

			if ($config->modal) {
				$page->body = $config->paths->content."vend-information/forms/item-search-form.php";
			} else {
				$page->body = $config->paths->content."vend-information/item-search-results.php";
			}
            break;
        case 'vi-costing':
            $vendorID = $input->get->text('vendorID');
            $itemID = $input->get->text('itemID');
            $page->title = 'Viewing Pricing for ' . $itemID;
            $page->body = $config->paths->content."vend-information/vend-costing.php";
            break;
        case 'item-search-results':
            $page->title = "Searching items for " . $input->get->text('q');
            $q = $input->get->text('q');
            $page->body = $config->paths->content."vend-information/item-search-results.php";
            break;
        case 'vi-unreleased-purchase-orders':
            $vendorID = $input->get->text('vendorID');
            $page->title = get_vendorname($vendorID) . ' Unreleased Purchase Orders';
            $tableformatter = $page->screenformatterfactory->generate_screenformatter('vi-unreleased-purchase-orders');
            $page->body = $config->paths->content."vend-information/vi-formatted-screen.php";
            break;
        case 'vi-uninvoiced':
            $vendorID = $input->get->text('vendorID');
            $page->title = get_vendorname($vendorID) . ' Uninvoiced';
            $page->body = $config->paths->content."vend-information/vend-uninvoiced.php";
            break;
        case 'vi-24monthsummary':
            $vendorID = $input->get->text('vendorID');
            $page->title = get_vendorname($vendorID) . ' 24-Month Summary';
            $page->body = $config->paths->content."vend-information/vend-24-month-summary.php";
            break;
        case 'vi-docview':
            $vendorID = $input->get->text('vendorID');
            $page->title = get_vendorname($vendorID) . ' Payment';
            $page->body = $config->paths->content."vend-information/vend-documents.php";
            break;
        default:
            $page->title = 'Search for a vendor';
            if ($input->get->q) {$q = $input->get->text('q');}
            $page->body = $config->paths->content."vend-information/forms/vend-page-form.php";
            break;
    }

	if ($config->ajax) {
		if ($config->modal) {
			include $config->paths->content."common/modals/include-ajax-modal.php";
		} else {
			include $page->body;
		}
	} else {
		$config->scripts->append(get_hashedtemplatefileURL('scripts/libs/raphael.js'));
		$config->scripts->append(get_hashedtemplatefileURL('scripts/libs/morris.js'));
		$config->scripts->append(get_hashedtemplatefileURL('scripts/libs/datatables.js'));
		$config->scripts->append(get_hashedtemplatefileURL('scripts/vi/vend-functions.js'));
		$config->scripts->append(get_hashedtemplatefileURL('scripts/vi/vend-info.js'));
		include $config->paths->content."common/include-blank-page.php";
	}
