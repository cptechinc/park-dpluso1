<?php include($config->paths->templates.'_head.php'); // include header markup ?>
    <div class="jumbotron pagetitle">
        <div class="container">
            <h1><?= $page->get('pagetitle|headline|title') ; ?></h1>
        </div>
    </div>
    <div class="container page">
        <h2><i class="fa fa-5x fa-exclamation-triangle" aria-hidden="true"></i> You do not have access to this function</h2>
    </div>
<?php include($config->paths->templates.'_foot.php'); // include footer markup ?>
