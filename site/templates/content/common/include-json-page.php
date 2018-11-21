<?php 
    header('Content-Type: application/json');
    if (is_object($page->body)) {
        echo json_encode($page->body);
    } elseif (is_array($page->body)) {
        echo json_encode($page->body);
    } else {
        echo $page->body;
    }
