<?php
    if ($config->ajax) {
        include $config->paths->content."reports/$page->name.php";
    } else {
        $page->body = $config->paths->content."reports/$page->name.php";
        include $config->paths->content.'common/include-page.php';
    }
