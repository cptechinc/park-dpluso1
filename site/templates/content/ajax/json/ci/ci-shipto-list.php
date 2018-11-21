<?php 
	$shiptofile = $config->jsonfilepath.session_id()."-cishiptolist.json";
	$json = file_get_contents($shiptofile);
echo $json; 

?>