<?php 
    $vendorID = $shipfromID = '';
    if (has_dpluspermission($user->loginid, 'vi')) {
        if ($input->urlSegment(1)) { // Vendor ID provided
            $vendorID = $input->urlSegment(1);

            if ($input->urlSegment(2)) { // ShipfromID is provided
                $shipfromID = urldecode(str_replace('shipfrom-', '', $input->urlSegment(2)));
            }

            $vendor = Vendor::load($vendorID, $shipfromID);

            if ($vendor) {
                $page->title = 'VI: ' . $vendor->generate_title();

                if ($vendor->has_shipfrom()) {
                    $buttonsjson = json_decode(file_get_contents($config->jsonfilepath.session_id()."-visfbuttons.json"), true);
                    $page->body = $config->paths->content."vend-information/vend-shipfrom.php";
                } else {
                    $buttonsjson = json_decode(file_get_contents($config->jsonfilepath.session_id()."-vibuttons.json"), true);
                    $page->body = $config->paths->content."vend-information/vend-info-outline.php";
                }
                $toolbar = $config->paths->content."vend-information/toolbar.php";
                $config->scripts->append(get_hashedtemplatefileURL('scripts/vi/vend-functions.js'));
                $config->scripts->append(get_hashedtemplatefileURL('scripts/vi/vend-info.js'));
                $config->scripts->append(get_hashedtemplatefileURL('scripts/libs/raphael.js'));
                $config->scripts->append(get_hashedtemplatefileURL('scripts/libs/morris.js'));
            } else {
                $page->title = ($input->urlSegment(2)) ? "Vendor $vendorID Shipfrom: $shipfromID Not Found" : "Vendor $vendorID Not Found";
                $toolbar = false;
                $input->get->function = 'vi';
                $page->body = $config->paths->content."vendor/ajax/load/vend-index/search-form.php";
            }
        } else {
            $toolbar = false;
            $input->get->function = 'vi';
            $page->body = $config->paths->content."vendor/ajax/load/vend-index/search-form.php";
        }
        include $config->paths->content."common/include-toolbar-page.php";
    } else {
        include $config->paths->content."common/permission-denied-page.php";
    }
