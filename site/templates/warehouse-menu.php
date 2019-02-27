<?php 
    $permission = (!empty($page->dplusfunction)) ? has_dpluspermission($user->loginid, $page->dplusfunction) : true;
    
    if ($permission) {
        if (!WhseSession::does_sessionexist(session_id())) {
            WhseSession::start_session(session_id());
        }
        $page->body = $config->paths->content."warehouse/menu.php";
        include $config->paths->content."common/include-page.php";
    } else {
        include $config->paths->content."common/permission-denied-page.php";
    }
