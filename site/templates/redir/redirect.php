<?php
	$user->loggedin = is_validlogin(session_id());
	$url = !empty($session->loc) ? $session->loc : $config->pages->index;
	$session->remove('loc');

	// Check if user was trying to log in, then handle redirect of login
	if ($session->loggingin) {
		$session->remove('loggingin');

		if (!$user->loggedin) {
			$url = $config->pages->login;
		} else {
			if (in_array($user->mainrole, array_keys($config->user_roles))) {
				$url = $config->user_roles[$user->mainrole]['homepage']; 
			} else {
				$url = $config->user_roles['default']['homepage']; 
			}
		}
	}

	header("Location: $url");
	exit;
