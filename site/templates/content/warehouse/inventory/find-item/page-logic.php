<?php
	$whsesession = WhseSession::load(session_id());
	$whsesession->init();
	$whseconfig = WhseConfig::load($whsesession->whseid);

	if ($input->get->scan) {
		$scan = $input->get->text('scan');
		$page->title = "Find Item Inquiry for $scan";
		$resultscount = InventorySearchItem::count_distinct_itemid(session_id());
		$items = InventorySearchItem::get_all_distinct_itemid(session_id());
	}
	
	$page->body = __DIR__."/inventory-results.php";
	$toolbar = false;
	include $config->paths->content."common/include-toolbar-page.php";
