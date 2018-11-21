<?php
    if ($input->urlSegment(1)) {
        $configtype = $input->urlSegment(1);
        switch ($input->urlSegment(1)) {
            case 'iio':
                $page->title = "Item Information Configurations";
                $include = $config->paths->content.'salesrep/configs/item-info-config.php';
                break;
            default:
                $include = $config->paths->content.'salesrep/configs/config-menu.php';
                break;
        }
    } else {
        $include = $config->paths->content.'salesrep/configs/config-menu.php';

    }
    $configurations = array(
        'CI Configurations' => 'cio',
        'II Configurations' => 'iio'
    );
?>
<?php include('./_head.php'); // include header markup ?>
    <div class="jumbotron pagetitle">
        <div class="container">
            <h1><?php echo $page->get('pagetitle|headline|title') ; ?></h1>
        </div>
    </div>
    <div class="container page">
        <?php include $include; ?>
    </div>
<?php include('./_foot.php'); // include footer markup ?>
