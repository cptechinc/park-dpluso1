<?php 
    $section = $page->parent()->name;
    $formattercode = $page->name;
    
    // Directory and File location 
    $formatterdirectory = $config->paths->content."$section/screen-formatters/";
    $formatterfile = $formatterdirectory."$page->name.php";
    
    /**
     *  If there's an existing formatter file then we'll include it
      * else  we wil use the default formatter under that directory
     * @var string $formatterfile path to to the formatter file
     */
    if (file_exists($formatterfile)) {
        include $formatterfile;
    } else {
        include $formatterdirectory."_formatter.php";
    }
