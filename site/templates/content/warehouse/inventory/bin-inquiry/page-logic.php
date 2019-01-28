<?php
	$whsesession = WhseSession::load(session_id());
	$whsesession->init();
	$whseconfig = WhseConfig::load($whsesession->whseid);
	
	if ($input->get->binID) {
		$binID = $input->get->text('binID');
		// GETS CUSTOMER CONFIGS FOR THIS FUNCTION / MENU AREA
		$functionconfig = $pages->get('/config/warehouse/inventory/');

		$resultscount = InventorySearchItem::count_distinct_itemid(session_id());
		$items = InventorySearchItem::get_all_distinct_itemid(session_id());
		$page->title = "Bin Inquiry for $binID";
		$page->body = __DIR__."/inventory-results.php";
	} else {
		$page->body = __DIR__."/bin-form.php";
	}
	
	
	$toolbar = false;
	$config->scripts->append(hash_templatefile('scripts/warehouse/bin-inquiry.js'));
	include $config->paths->content."common/include-toolbar-page.php";
