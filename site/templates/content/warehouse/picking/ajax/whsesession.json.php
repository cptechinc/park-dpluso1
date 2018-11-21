<?php 
    header('Content-Type: application/json'); 
    $whsesession = WhseSession::load(session_id());
    echo json_encode(
        array(
            "response" => array(
                'session' => $whsesession->_toArray()
            )
        )
    );
