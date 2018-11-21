<?php 
    $section = $page->parent()->name;
    include $config->paths->content."$section/screen-formatters/$page->name-formatter.php";
