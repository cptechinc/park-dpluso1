<?php
    $custID = $shipID = '';
    if (has_dpluspermission($user->loginid, 'ii')) {
        if ($input->get->itemID) {
            $itemID = $input->get->text('itemID');
    		$page->title = 'II: ' . $itemID;
            $tableformatter = $page->screenformatterfactory->generate_screenformatter('ii-item-page');
            $itemjson = json_decode(file_get_contents($config->jsonfilepath.session_id()."-iiitem.json"), true);
            $buttonsjson = json_decode(file_get_contents($config->jsonfilepath.session_id()."-iibuttons.json"), true);
    		$toolbar = $config->paths->content."item-information/toolbar.php";
            $page->body = $config->paths->content.'item-information/ii-page-outline.php';
        } else {
    		$toolbar = false;
            $q = '';
            $page->body = $config->paths->content.'item-information/ii-page-search.php';
    	}

        if ($input->get->custID) {
            $custID = $input->get->text('custID');
            if ($input->get->shipID) {
    			$shipID = $input->get->text('shipID');
            }
        }

        $config->scripts->append(get_hashedtemplatefileURL('scripts/libs/raphael.js'));
        $config->scripts->append(get_hashedtemplatefileURL('scripts/libs/morris.js'));
        $config->scripts->append(get_hashedtemplatefileURL('scripts/libs/datatables.js'));
    	$config->scripts->append(get_hashedtemplatefileURL('scripts/ii/item-functions.js'));
    	$config->scripts->append(get_hashedtemplatefileURL('scripts/ii/item-info.js'));

        include $config->paths->content."common/include-toolbar-page.php";
    } else {
        include $config->paths->content."common/permission-denied-page.php";
    }
