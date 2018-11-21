<?php 
	header('Content-Type: application/json'); 
	$docfile = $config->jsonfilepath.session_id()."-docview.json";
	$document = $input->get->text('docnumber');
	if (file_exists($docfile)) {
		$docjson = json_decode(file_get_contents($docfile), true);
		if ($docjson) {
			$file = $docjson['data'][$document]['filepath']."/".$docjson['data'][$document]['filename'];
			if ($file) {
				if (file_exists($config->documentstoragedirectory)) {
					copy($file, $config->documentstoragedirectory.$docjson['data'][$document]['filename']);
					$response = array('response' => array('error' => false, 'message' => 'Your file has been moved', 'file' => $docjson['data'][$document]['filename']));
				} else {
					$response = array('response' => array('error' => true, 'message' => 'Your file could not be found', 'file' => $docjson['data'][$document]['filename']));
				}
			} else {
				$response = array('response' => array('error' => true, 'message' => 'Your file could not be found', 'file' => $docjson['data'][$document]['filename']));
			}
		} else {
			$response = array('response' => array('error' => true, 'message' => 'Document Json file has errors', 'file' => ''));
		}
	} else {
		$response = array('response' => array('error' => true, 'message' => 'The file does not exist', 'file' => ''));
	}

	echo json_encode($response);
