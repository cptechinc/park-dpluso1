<?php
	$this_page = $input->pageNum();

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

<form action="<?php echo $config->filename; ?>" method="get" class="form-inline results-per-page-form" onSubmit="resultsperpage(this)">
    <div class="form-group">
    	<label>Results Per Page &nbsp;</label>
        <input type="hidden" class="display-page" value="<?php echo $results_page_link; ?>">
        <input type="hidden" name="symbol" class="symbol" value="<?php echo $symbol; ?>">
        <select class="form-control results-per-page" name="results-per-page">
        	<?php foreach ($config->showonpageoptions as $val ) : ?>
            	<?php if ($val == $config->showonpage) : ?>
                	<option value="<?php echo $val; ?>" selected><?php echo $val; ?></option>
                <?php else : ?>
                	<option value="<?php echo $val; ?>"><?php echo $val; ?></option>
                <?php endif; ?>
        	<?php endforeach; ?>
        </select>
    </div>
</form>
