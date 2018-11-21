<?php include $config->paths->templates.'_head-blank.php'; // include header markup ?>
    <div class="container page">
       <h2 class="text-center"><?= $page->title; ?></h2>
        <?php include $page->body; ?>
    </div>
<?php include($config->paths->templates.'_foot-blank.php'); // include footer markup ?>
