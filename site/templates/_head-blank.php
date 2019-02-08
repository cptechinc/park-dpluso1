<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
		<title><?php echo strip_tags(html_entity_decode($page->get('pagetitle|headline|title'))); ?></title>
       	<link rel="shortcut icon" href="<?php echo $config->urls->files."images/ddplus.ico"; ?>">

        <?php foreach($config->styles->unique() as $css) : ?>
        	<link rel="stylesheet" type="text/css" href="<?php echo $css; ?>" />
        <?php endforeach; ?>

        <script src="<?= get_hashedtemplatefileURL('scripts/libs/jquery.js'); ?>"></script>
		<script src="<?= get_hashedtemplatefileURL('scripts/libs/moment.js'); ?>"></script>
		<script>moment().format();</script>
		<?php include $config->paths->content.'common/phpjs/js-config.js.php'; ?>
	</head>
    <body class="fuelux no-nav">
