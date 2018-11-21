<?php include($config->paths->templates.'_head.php'); // include header markup ?>
    <div class="jumbotron pagetitle">
        <div class="container">
            <h1><?= $page->get('pagetitle|headline|title') ; ?></h1>
        </div>
    </div>
    <div class="container page">
        <?php include $page->body; ?>
    </div>
<?php include($config->paths->templates.'_foot.php'); // include footer markup ?>
