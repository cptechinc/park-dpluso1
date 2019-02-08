<?php
    if (does_systemconfigexist($user->loginid, 'iio')) {
        $iiconfig = json_decode(get_systemconfiguration($user->loginid, $configtype, false), true);
    } else {
        $iiconfig = json_decode(file_get_contents($config->paths->content."salesrep/configs/item-info-options.json"), true);
    }

    if ($input->get->itemID) {
        $itemID = $input->get->text('itemID');
    }

    switch ($input->urlSegment(2)) { //Parts of order to load
        case 'search-results':
            $q = $input->get->text('q');
            $page->title = "Searching for '$q'";
			switch ($input->urlSegment(3)) {
				case 'modal':
                    $custID = $input->get->text('custID');
					$page->body = $config->paths->content."item-information/forms/item-search-form.php";
					break;
				default:
					$page->body = $config->paths->content."item-information/item-search-results.php";
					break;
			}
            break;
		case 'ii-pricing': // $itemID provided by $input->get
			$custID = $input->get->text('custID');
            $page->title = $itemID. ' Price Inquiry for ' . $custID;
            $tableformatter = $page->screenformatterfactory->generate_screenformatter('ii-pricing');
            $page->body = $config->paths->content."item-information/ii-formatted-screen.php";
            break;
        case 'ii-costing': // $itemID provided by $input->get
            $page->title = $itemID .' Cost Inquiry';
			$tableformatter = $page->screenformatterfactory->generate_screenformatter('ii-costing');
            $page->body = $config->paths->content."item-information/ii-formatted-screen.php";
            break;
        case 'ii-purchase-orders': // $itemID provided by $input->get
            $page->title = $itemID. ' Purchase Order Inquiry';
            $tableformatter = $page->screenformatterfactory->generate_screenformatter('ii-purchase-orders');
            $page->body = $config->paths->content."item-information/ii-formatted-screen.php";
            break;
		case 'ii-quotes': // $itemID provided by $input->get
            $page->title = 'Viewing ' .$itemID . ' Quotes';
            $tableformatter = $page->screenformatterfactory->generate_screenformatter('ii-quotes');
            $page->body = $config->paths->content."item-information/ii-formatted-screen.php";
            break;
		 case 'ii-purchase-history': // $itemID provided by $input->get
            $page->title = $itemID.' Purchase History Inquiry';
            $tableformatter = $page->screenformatterfactory->generate_screenformatter('ii-purchase-history');
            $page->body = $config->paths->content."item-information/ii-formatted-screen.php";
            break;
		case 'ii-where-used': // $itemID provided by $input->get
            $page->title = $itemID.' Where Used Inquiry';
            $page->body = $config->paths->content."item-information/item-where-used.php";
            break;
		case 'ii-kit': // $itemID provided by $input->get
            $page->title = $itemID.' Kit Component Inquiry ';
            $tableformatter = $page->screenformatterfactory->generate_screenformatter('ii-kit');
            $page->body = $config->paths->content."item-information/ii-formatted-screen.php";
            break;
		case 'ii-bom': // $itemID provided by $input->get
			$bom = $input->get->text('bom');
            $page->title = $itemID.' BOM Item Inquiry ';
            $page->body = $config->paths->content."item-information/item-bom-".$bom.".php";
            break;
		case 'ii-general': // $itemID provided by $input->get
            $page->title = $itemID . ' General Item Inquiry';
            $page->body = $config->paths->content."item-information/item-general.php";
            break;
		case 'ii-activity': // $itemID provided by $input->get
			if ($input->urlSegment(3) == 'form') {
				$page->title = 'Enter the Starting Report Date ';
				$page->body = $config->paths->content."item-information/forms/item-activity-form.php";
			} else {
                $startdate = $input->get->text('startdate');
				$page->title = $itemID.' Activity Inquiry Start Date: ' . $startdate;
                $tableformatter = $page->screenformatterfactory->generate_screenformatter('ii-activity');
				$page->body = $config->paths->content."item-information/ii-formatted-screen.php";
			}
            break;
		case 'ii-requirements': // $itemID provided by $input->get
            $page->title = $itemID. ' Requirements Inquiry';
            $tableformatter = $page->screenformatterfactory->generate_screenformatter('ii-requirements');
            $page->body = $config->paths->content."item-information/ii-formatted-screen.php";
            break;
		case 'ii-lot-serial': // $itemID provided by $input->get
            $page->title = 'Viewing ' .$itemID. ' Lot/Serial Inquiry';
            $tableformatter = $page->screenformatterfactory->generate_screenformatter('ii-lot-serial');
            $page->body = $config->paths->content."item-information/ii-formatted-screen.php";
            break;
		case 'ii-sales-orders':
            $page->title = $itemID . ' Sales Order Inquiry';
            $tableformatter = $page->screenformatterfactory->generate_screenformatter('ii-sales-orders');
            $page->body = $config->paths->content."item-information/ii-formatted-screen.php";
            break;
		case 'ii-sales-history': // $itemID provided by $input->get
            $custID = ($input->get->custID) ? $input->get->text('custID') : '';
			if ($input->urlSegment(3) == 'form') {
				$page->title = 'Search Item History';
				$page->body = $config->paths->content."item-information/forms/item-history-form.php";
			} else {
                $tableformatter = $page->screenformatterfactory->generate_screenformatter('ii-sales-history');
				$page->title = $itemID. ' Sales History Inquiry';
				$page->body = $config->paths->content."item-information/ii-formatted-screen.php";
			}
			break;
		case 'ii-stock': // $itemID provided by $input->get
            $page->title = $itemID. ' Stock by Warehouse Inquiry';
            $tableformatter = $page->screenformatterfactory->generate_screenformatter('ii-stock');
            $page->body = $config->paths->content."item-information/ii-formatted-screen.php";
            break;
		case 'ii-substitutes': // $itemID provided by $input->get
            $page->title = 'Viewing Item Substitutes for ' .$itemID;
            $tableformatter = $page->screenformatterfactory->generate_screenformatter('ii-substitutes');
            $page->body = $config->paths->content."item-information/ii-formatted-screen.php";
            break;
		case 'ii-documents': // $itemID provided by $input->get
            switch ($input->urlSegment(3)) {
                case 'order':
                    $page->title = "Order #" . $input->get->text('ordn'). ' Documents';
                    break;
                default:
                    $page->title = 'Viewing Item Documents for ' .$itemID;
                    break;
            }
            $tableformatter = $page->screenformatterfactory->generate_screenformatter('ii-documents');
            $page->body = $config->paths->content."item-information/ii-formatted-screen.php";
            break;
        default:
            $page->title = 'Search for an item';
            if ($input->get->q) {$q = $input->get->text('q');}
            $page->body = $config->paths->content."item-information/forms/item-search-form.php";
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
		$config->scripts->append(get_hashedtemplatefileURL('scripts/ii/item-functions.js'));
		$config->scripts->append(get_hashedtemplatefileURL('scripts/ii/item-info.js'));
		include $config->paths->content."common/include-blank-page.php";
	}
