<?php
	$toolbar = false;

    if (has_dpluspermission($user->loginid, 'ci')) {
        $custID = $shipID = '';

        if ($input->urlSegment(1)) {
            $custID = $input->urlSegment(1);
            $shipID = ($input->urlSegment(2)) ? urldecode(str_replace('shipto-', '', $input->urlSegment(2))) : '';

            if (Customer::can_useraccess($custID, $shipID, $user->loginid)) {
				$customer = Customer::load($custID, $shipID);

				if ($customer) {
	                $page->title = 'CI: ' . $customer->generate_title();

	                if (file_exists($config->jsonfilepath.session_id()."-cicustomer.json")) {
	                    if ($customer->has_shipto()) {
	                        $tableformatter = $page->screenformatterfactory->generate_screenformatter('ci-customer-shipto-page');
	                        $buttonsjson = json_decode(file_get_contents($config->jsonfilepath.session_id()."-cistbuttons.json"), true);
	                    } else {
	                        $tableformatter = $page->screenformatterfactory->generate_screenformatter('ci-customer-page');
	                	    $buttonsjson = json_decode(file_get_contents($config->jsonfilepath.session_id()."-cibuttons.json"), true);
	                    }

	                    $tableformatter->process_json();
	                    $toolbar = $config->paths->content."cust-information/toolbar.php";
	                    $config->scripts->append(get_hashedtemplatefileURL('scripts/libs/raphael.js'));
	                    $config->scripts->append(get_hashedtemplatefileURL('scripts/libs/morris.js'));
						$config->scripts->append(get_hashedtemplatefileURL('scripts/libs/datatables.js'));
	            		$config->scripts->append(get_hashedtemplatefileURL('scripts/ci/cust-functions.js'));
	            		$config->scripts->append(get_hashedtemplatefileURL('scripts/ci/cust-info.js'));
	                    $itemlookup->set_customer($customer->custid, $customer->shiptoid);

	                    if ($tableformatter->json['error']) {
	                        $page->title = $tableformatter->json['errormsg'];
	                        $input->get->function = 'ci';
	                        $dplusfunction = 'ci';
	                        $page->body = $config->paths->content."customer/ajax/load/cust-index/search-form.php";
	                    } else {
	                        $page->body = $config->paths->content."cust-information/ci-customer-page.php";
	                        $custshiptos = json_decode(file_get_contents($config->jsonfilepath.session_id()."-cishiptolist.json"), true);
	                    }
	                } else {
	                    $page->body = $page->body = $config->paths->content."cust-information/ci-click-to-load.php";
	                }
	            } else {
	                $toolbar = false;
	                $page->title = "Customer $custID Not Found";
	                $input->get->function = 'ci';
	                $dplusfunction = 'ci';

	                if ($input->urlSegment(2)) {
	                    $page->title = "Customer $custID Ship-to: $shiptoID Not Found";
	                }
	                $page->body = $config->paths->content."customer/ajax/load/cust-index/search-form.php";
	            }
			} else {
				$toolbar = false;
                $page->title = "Customer $custID Not Found";
                $input->get->function = 'ci';
                $dplusfunction = 'ci';

                if ($input->urlSegment(2)) {
                    $page->title = "You don't have access to Customer $custID Ship-to: $shiptoID";
                }
                $page->body = $config->paths->content."customer/ajax/load/cust-index/search-form.php";
			}
            $customer = Customer::load($custID, $shipID);
        } else {
    		$toolbar = false;
            $input->get->function = 'ci';
            $dplusfunction = 'ci';
            $page->body = $config->paths->content."customer/ajax/load/cust-index/search-form.php";
    	}
        include $config->paths->content."common/include-toolbar-page.php";
    } else {
        include $config->paths->content."common/permission-denied-page.php";
    }
