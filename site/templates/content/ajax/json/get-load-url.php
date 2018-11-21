<?php 
	header('Content-Type: application/json'); 
	$json = array("from-redirect" => $session->{'from-redirect'}, "url" => $session->loc, "root" => $config->urls->root);
	
	echo json_encode(array("response" => $json));
		
?>