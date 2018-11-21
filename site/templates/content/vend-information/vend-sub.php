<?php 
    $subfile = $config->jsonfilepath.session_id()."-visub.json";
    // $subfile = $config->jsonfilepath."visub-visub.json";

    if (file_exists($subfile)) {
        // JSON file will be false if an error occurred during file_get_contents or json_decode
        $subjson = json_decode(file_get_contents($subfile), true);
        $subjson = $subjson ? $subjson : array('error' => true, 'errormsg' => 'The Item Cost JSON contains errors. JSON ERROR: ' . json_last_error());
        
        if ($subjson['error']) {
            echo $page->bootstrap->alertpanel('warning', $subjson['errormsg']);
        } else {
            include $config->paths->content."vend-information/tables/sub-table.php";
            
            echo $subtable;
            echo "<h3>Substitutions</h3>";
            if (!empty($subitemstable)) {
                echo $subitemstable;
            } else {
                echo $page->bootstrap->alertpanel('info', 'No Substitutions');
            }
            echo "<h3>Internal Notes</h3>";
            if (!empty($notestable)) {
                echo $notestable;
            } else {
                echo $page->bootstrap->alertpanel('info', 'No Internal Notes');
            }
        }
    } else {
        echo $page->bootstrap->alertpanel('warning', 'Information Not Available');
    }
    
    
?>
