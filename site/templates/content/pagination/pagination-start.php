<?php
	if ($input->get->page) {
		$inputpage = $input->get->text('page');
	} else {
		$this_page = 1;
	}

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

<form action="<?php echo $config->filename; ?>" method="get" class="form-inline" id="pagination-form">
    <div class="form-group">
    	<label>Results Per Page &nbsp;</label>
        <input type="hidden" id="pagination-page" value="<?php echo $results_page_link; ?>">
        <input type="hidden" name="symbol" id="symbol" value="<?php echo $symbol; ?>">
        <select class="form-control" name="results-per-page" id="results-per-page">
        	<?php foreach ($config->results_array as $val ) : ?>
            	<?php if ($val == $config->showonpage) : ?>
                	<option value="<?php echo $val; ?>" selected><?php echo $val; ?></option>
                <?php else : ?>
                	<option value="<?php echo $val; ?>"><?php echo $val; ?></option>
                <?php endif; ?>
        	<?php endforeach; ?>
        </select>&nbsp;
        <input type="hidden" name="symbol" value="<?php echo $symbol; ?>">
    </div>
</form>
