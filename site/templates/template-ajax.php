<?php
	if ($input->urlSegment1 == 'json') {
		switch ($input->urlSegment2) {
			case 'get-load-url':
				include $config->paths->content . 'ajax/json/get-load-url.php';
				break;
			case 'dplus-notes':
				include $config->paths->content . 'ajax/json/get-dplus-note.php';
				break;
			case 'get-shipto':
				include $config->paths->content . 'ajax/json/get-shipto.php';
				break;
			case 'order':
				include $config->paths->content . 'ajax/json/order-json-router.php';
				break;
			case 'quote':
				include $config->paths->content . 'ajax/json/quote-json-router.php';
				break;
			case 'test-json':
				include $config->paths->content."ajax/json/test-json.php";
				break;
			case 'move-file':
				include $config->paths->content."ajax/json/move-file.php";
				break;
			case 'ii':
				include $config->paths->content."ajax/json/ii-json-router.php";
				break;
			case 'ci':
				include $config->paths->content."ajax/json/ci-json-router.php";
				break;
			case 'load-action';
				include $config->paths->content."actions/load-action-json.php";
				break;
			case 'vendor-shipfrom':
				include $config->paths->content."ajax/json/vendor-shipfrom.php";
				break;
			default:
				throw new Wire404Exception();
				break;
		}
	} else if ($input->urlSegment1 == 'load') {
		switch ($input->urlSegment2) {
			case 'orders': //ADDED 12/22/2016 $input->urlSegment(3) is going to be cust or salesrep
				include $config->paths->content . 'ajax/orders-router.php';
				break;
			case 'quotes': //ADDED 12/22/2016 $input->urlSegment(3) is going to be cust or salesrep
				include $config->paths->content . 'ajax/quotes-router.php';
				break;
			case 'notes':
				include $config->paths->content . 'ajax/notes-router.php';
				break;
			case 'products':
				include $config->paths->content . 'ajax/products-router.php';
				break;
			case 'edit-detail':
				include $config->paths->content . 'ajax/edit-detail-router.php';
				break;
			case 'view-detail':
				include $config->paths->content . 'ajax/view-detail-router.php';
				break;
			case 'order':
				include $config->paths->content . 'ajax/order-router.php';
				break;
			case 'ii':
				include $config->paths->content . 'ajax/ii-router.php';
				break;
			case 'ci':
				include $config->paths->content . 'ajax/ci-router.php';
				break;
			default:
				throw new Wire404Exception();
				break;
		}
	} else {
		throw new Wire404Exception();
	}

?>
