<?php
	switch ($input->urlSegment(2)) {
		case 'ii-move-document':
			include $config->paths->content . 'ajax/json/ii/move-file.php';
			break;
	}

?>
