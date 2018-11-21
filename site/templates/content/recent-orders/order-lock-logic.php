<?php
	/*
		ORDER LOCK LOGIC
		-------------------------------------
		N = PICKED, INVOICED, ETC CANNOT EDIT
		Y = CAN EDIT
		L = YOU'VE LOCKED THIS ORDER
	*/




	if ($order['editord'] == 'Y') {
		$editlink = $config->pages->orders."redir/?action=get-order-details&ordn=".$on."&custID=".$order['custid']."&lock=lock";
		$span = "<span class='glyphicon glyphicon-pencil'></span>";
		$atitle = "Edit this Order";
	} elseif ($order['editord'] == 'L') {
		if ($user->hasqorderlocked) {
			if ($on == $user->lockedordn) {
				$editlink = $config->pages->orders."redir/?action=get-order-details&ordn=".$on."&custID=".$order->custid."&lock=lock";
				$span = "<span class='glyphicon glyphicon-wrench'></span>";
				$atitle = "Edit this Order";
			} else {
				$editlink = $config->pages->customer."redir/?action=get-order-details&ordn=".$on."&readonly=readonly";
				$span = "<i class='material-icons md-36'>&#xE897;</i>";
				$atitle = "You have this order locked, but you can still view it";
			}
		} else {
			$editlink = $config->pages->customer."redir/?action=get-order-details&ordn=".$on."&readonly=readonly";
			$span = "<i class='material-icons md-36'>&#xE897;</i>";
			$atitle = "You have this order locked, but you can still view it";
		}

	} else {
		$editlink = $config->pages->customer."redir/?action=get-order-details&ordn=".$on."&readonly=readonly";
		$span = "<span class='glyphicon glyphicon-eye-open'></span>";
		$atitle = "Open in read-only mode";
	}

	
	$onclick = " href='$editlink' class='edit-order' title='$atitle'";


	$editordericon = '<span class="h3"><a '.$onclick.'> '.$span.'</a></span>';
