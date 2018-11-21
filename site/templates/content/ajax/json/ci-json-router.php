<?php
	header('Content-Type: application/json');
	switch ($input->urlSegment(2)) {
		case 'ci-shipto-list':
			include $config->paths->content . 'ajax/json/ci/ci-shipto-list.php';
			break;
	}

?>
