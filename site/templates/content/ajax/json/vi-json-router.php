<?php
	header('Content-Type: application/json');
	switch ($input->urlSegment(2)) {
		case 'vi-shipfrom-list':
			include $config->paths->content . 'ajax/json/vi/vi-shipfrom-list.php';
			break;
	}
?>
