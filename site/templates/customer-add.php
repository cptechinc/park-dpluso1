<?php 
    $page->body = $config->paths->content.'customer/add/outline.php';

    if ($config->ajax) {
        if ($config->modal) {
            include $config->paths->content."common/modals/include-ajax-modal.php";
        } else {
            include $page->body;
        }
    } else {
        include $config->paths->templates."_include-page.php";
    }
