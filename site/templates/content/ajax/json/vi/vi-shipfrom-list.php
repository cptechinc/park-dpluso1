<?php
    header('Content-Type: application/json');
    $shipfromfile = $config->jsonfilepath.session_id()."-vishipfromlist.json";

    // JSON FILE will be false if an error occured during file get or json decode
    $shipfromjson = json_decode(convertfiletojson($shipfromfile), true);

    if ($shipfromjson) {
        if ($shipfromjson['error']) {
            echo json_encode(array('response' => array('error' => true, 'errormsg' => $shipfromjson['errormsg'])));
        } else {
            echo json_encode(array('response' => array('error' => false, 'shipfromlist' => $shipfromjson['data'])));
        }
    } else {
        echo json_encode(array('response' => array('error' => true, 'errormsg' => 'The VI Ship-From List JSON contains errors. JSON ERROR: ' . json_last_error())));
    }
