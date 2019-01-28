<?php
	use Dplus\Warehouse\Binr;

	$binID = '';
	$whsesession = WhseSession::load(session_id());
	$whsesession->init();
	$binr = new Binr();
	$config->scripts->append(hash_templatefile('scripts/warehouse/binr.js'));

	if ($input->get->scan) {
		$page->fullURL->query->remove('scan');
		$scan = $input->get->text('scan');
		$resultscount = InventorySearchItem::count_all(session_id());

		if ($resultscount == 0) {
			$page->body = $config->paths->content."{$page->path}inventory-results.php";
		} elseif ($resultscount == 1) {
			$item = InventorySearchItem::load_first(session_id());
			$pageurl = $page->fullURL->getUrl();
			header("Location: {$config->pages->menu_binr}redir/?action=search-item-bins&itemID=$item->itemid&page=$pageurl");
		} else {
			$items = InventorySearchItem::get_all(session_id());
			$page->body = $config->paths->content."{$page->path}inventory-results.php";
		}
	} elseif (!empty($input->get->serialnbr) | !empty($input->get->lotnbr) | !empty($input->get->itemID)) {
		$binID  = $input->get->text('binID');

		if ($input->get->serialnbr) {
			$serialnbr = $input->get->text('serialnbr');
			$resultscount = InventorySearchItem::count_from_lotserial(session_id(), $serialnbr);
			$item = $resultscount == 1 ? InventorySearchItem::load_from_lotserial(session_id(), $serialnbr) : false;
		} elseif ($input->get->lotnbr) {
			$lotnbr = $input->get->text('lotnbr');
			$resultscount = InventorySearchItem::count_from_lotserial(session_id(), $lotnbr, $binID);
			$item = $resultscount == 1 ? InventorySearchItem::load_from_lotserial(session_id(), $lotnbr, $binID) : false;
		} elseif ($input->get->itemID) {
			$itemID = $input->get->text('itemID');
			$resultscount = InventorySearchItem::count_from_itemid(session_id(), $itemID, $binID);
			$item = $resultscount == 1 ? InventorySearchItem::load_from_itemid(session_id(), $itemID, $binID) : false;
		}

		if ($resultscount == 1) {
			$page->body = $config->paths->content."{$page->path}binr-form.php";
		} else {
			$items = InventorySearchItem::get_all(session_id());
			$page->body = $config->paths->content."{$page->path}inventory-results.php";
		}
	} else {
		$page->body = $config->paths->content."{$page->path}item-form.php";
	}
	$toolbar = false;
	include $config->paths->content."common/include-toolbar-page.php";
