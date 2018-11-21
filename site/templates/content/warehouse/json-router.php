<?php
	switch ($input->urlSegment(2)) {
		case 'session':
			include "{$config->paths->content}warehouse/picking/ajax/whsesession.json.php";
			break;
	}
