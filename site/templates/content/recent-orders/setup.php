<?php

	if ($input->get->orderby) {
		$orderby_array = explode('-', $input->get->orderby);
		$orderby = $orderby_array[0];
		if ($orderby_array[0] != '') {
			$sortrule = $orderby_array[1];
			$nextorder = get_sorting_rule($orderby, $sortrule, $orderby);
		} else {
			$sortrule = "ASC";
			$nextorder = "DESC";
		}
		$sortlinkaddon = "&orderby=".$input->get->orderby;
	} else {
		$orderby = false;
		$sortrule = false;
		$nextorder = "ASC";
		$sortlinkaddon = '';
	}

	$linkaddon = $sortlinkaddon;


	$orderno_sym = get_symbols($orderby, "orderno", $sortrule);
	$custpo_sym =  get_symbols($orderby, "custpo", $sortrule);
	$orderdate_sym = get_symbols($orderby, "orderdate", $sortrule);
	$status_sym =  get_symbols($orderby, "status", $sortrule);
	$shipto_sym = get_symbols($orderby, "shiptoid", $sortrule);
	$cust_sym =  get_symbols($orderby, "custid", $sortrule);
	$total_sym =  get_symbols($orderby, "subtotal", $sortrule);



	$legendcontent = "<span class='glyphicon glyphicon-shopping-cart' title='re-order'></span> = Re-order whole order <br>";
	$legendcontent .= "<span class='glyphicon glyphicon-folder-open' title='Click to view Documents'></span> &nbsp; = Documents <br>";
	$legendcontent .= "<span class='glyphicon glyphicon-plane hover' title='Click to view Tracking'></span> = Tracking <br>";
	$legendcontent .= "<span class='glyphicon glyphicon-list-alt' title='View notes'></span> = Notes <br>";
	$legendcontent .= "<span class='glyphicon glyphicon-pencil' title='Edit this Order'></span> = Edit Order<br>";
	$legendiconcontent = 'class="btn btn-sm btn-info" role="button" data-toggle="popover" data-placement="bottom" data-trigger="focus" data-html="true" title="Icon Definition"';
