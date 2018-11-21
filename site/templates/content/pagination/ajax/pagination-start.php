<?php
	if ($input->get->display) {
		$config->showonpage = $input->get->text('display');
		$session->display = $config->showonpage;
	} elseif ($session->display){
		$config->showonpage = $session->display;
	}

	$results_page_link = $page->fullURL->query->remove('display');
	if (strpos($results_page_link, '?') !== FALSE) {
		$symbol = '&';
	} else {
		$symbol = '?';
	}
?>

<form action="<?php echo $ajax->link; //return to itself ?>" method="get" class="form-inline results-per-page-form ajax-load" <?php echo $ajax->data; ?>>
    <div class="form-group">
    	<label>Results Per Page &nbsp;</label>
        <input type="hidden" name="symbol" id="symbol" value="<?php echo $symbol; ?>">
        <input type="hidden" name="ajax" value="true">
        <select class="form-control input-sm results-per-page" name="results-per-page">
        	<?php foreach ($config->showonpageoptions as $val ) : ?>
            	<?php if ($val == $config->showonpage) : ?>
                	<option value="<?php echo $val; ?>" selected><?php echo $val; ?></option>
                <?php else : ?>
                	<option value="<?php echo $val; ?>"><?php echo $val; ?></option>
                <?php endif; ?>
        	<?php endforeach; ?>
        </select>&nbsp;
    </div>
</form>
