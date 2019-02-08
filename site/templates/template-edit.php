<?php
	use Dplus\Dpluso\OrderDisplays\EditSalesOrderDisplay, Dplus\Dpluso\OrderDisplays\EditQuoteDisplay;
	use Dplus\Dpluso\Configs\FormFieldsConfig;

	switch ($page->name) { //$page->name is what we are editing
		case 'order':
			if ($input->get->ordn) {
				$ordn = $input->get->text('ordn');
				$custID = SalesOrderHistory::is_saleshistory($ordn) ? SalesOrderHistory::find_custid($ordn) : SalesOrder::find_custid($ordn);
				$editorderdisplay = new EditSalesOrderDisplay(session_id(), $page->fullURL, '#ajax-modal', $ordn);
				$order = $editorderdisplay->get_order();

				if (!$order) {
					$page->title = "Order #" . $ordn . ' failed to load';
					$page->body = false;
				} else {
					$prefix = (!$user->loginid == SalesOrder::get_orderlockuser($ordn)) ? 'Editing' : 'Viewing';
					$page->title = "$prefix Order #" . $ordn . ' for ' . Customer::get_customernamefromid($custID);
					$config->scripts->append(get_hashedtemplatefileURL('scripts/edit/card-validate.js'));
					$config->scripts->append(get_hashedtemplatefileURL('scripts/edit/edit-orders.js'));
					$config->scripts->append(get_hashedtemplatefileURL('scripts/edit/edit-pricing.js'));
					$page->body = $config->paths->content."edit/orders/outline.php";
					$itemlookup->set_customer($order->custid, $order->shiptoid);
					$itemlookup = $itemlookup->set_ordn($ordn);
				}
				$formconfig = new FormFieldsConfig('sales-order');
			} else {
				throw new Wire404Exception();
			}
			break;
		case 'quote':
			if ($input->get->qnbr) {
				$qnbr = $input->get->text('qnbr');
				$editquotedisplay = new EditQuoteDisplay(session_id(), $page->fullURL, '#ajax-modal', $qnbr);
				$quote = $editquotedisplay->get_quote();
				$prefix = $quote->can_edit() ? 'Editing' : 'Viewing';
				$page->title = "$prefix Quote #" . $qnbr . ' for ' . Customer::get_customernamefromid($quote->custid);
				$page->body = $config->paths->content."edit/quotes/outline.php";
				$config->scripts->append(get_hashedtemplatefileURL('scripts/edit/edit-quotes.js'));
				$config->scripts->append(get_hashedtemplatefileURL('scripts/edit/edit-pricing.js'));
				$itemlookup->set_customer($quote->custid, $quote->shiptoid);
				$itemlookup = $itemlookup->set_qnbr($qnbr);
				$formconfig = new FormFieldsConfig('quote');
			} else {
				throw new Wire404Exception();
			}
			break;
		case 'quote-to-order':
			if ($input->get->qnbr) {
				$qnbr = $input->get->text('qnbr');
				$editquotedisplay = new EditQuoteDisplay(session_id(), $page->fullURL, '#ajax-modal', $qnbr);
				$quote = $editquotedisplay->get_quote();
				$page->title = "Creating a Sales Order from Quote #" . $qnbr;
				$page->body = $config->paths->content."edit/quote-to-order/outline.php";
				$config->scripts->append(get_hashedtemplatefileURL('scripts/edit/edit-quotes.js'));
				$config->scripts->append(get_hashedtemplatefileURL('scripts/edit/edit-quote-to-order.js'));
				$config->scripts->append(get_hashedtemplatefileURL('scripts/edit/edit-pricing.js'));
				$itemlookup->set_customer($quote->custid, $quote->shiptoid);
				$itemlookup = $itemlookup->set_qnbr($qnbr);
				$itemlookup->set('to_order', true);
				$formconfig = new FormFieldsConfig('quote');
			} else {
				throw new Wire404Exception();
			}
			break;
		default:
			throw new Wire404Exception();
			break;
	}

	if ($modules->isInstalled('CaseQtyBottle')) {
		$config->scripts->append(get_hashedmodulefileURL('CaseQtyBottle/js/quick-entry.js'));
	} else {
		$config->scripts->append(get_hashedtemplatefileURL('scripts/edit/quick-entry.js'));
	}
	include ($config->paths->content.'edit/include-edit-page.php');
