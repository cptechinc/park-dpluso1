<?php
    use Dplus\Dpluso\General\SigninLog;
    
    $signinlog = new SigninLog(session_id(), $page->fullURL, '#user-signin-table', '#user-signin-table');
    $day = $input->get->day ? date('m/d/Y', strtotime($input->get->text('day'))) : $day = date('m/d/Y');
    $signinlog->generate_filter($input);
    $url = new Purl\Url($page->fullURL->getUrl());
?>

<div class="row form-group">
    <div class="col-md-12">
        <button class="btn btn-primary pull-right" type="button" data-toggle="collapse" data-target="#signin-search-div" aria-expanded="false" aria-controls="signin-search-div">Toggle Search <i class="fa fa-search" aria-hidden="true"></i></button>
    </div>
</div>

<div id="signin-search-div" class="<?= (empty($signinlog->filters)) ? 'collapse' : ''; ?>">
    <form action="<?= $url->getUrl(); ?>" method="get" data-loadinto="#user-signin-table" data-focus="#user-signin-table" data-modal="#ajax-modal" class="signin-search-form allow-enterkey-submit">
    	<input type="hidden" name="filter" value="filter">
    	<div class="row">
            <div class="col-sm-2">
    			<h4>Date</h4>
    			<?php $name = 'date[]'; $value = $signinlog->get_filtervalue('date'); ?>
    			<?php include $config->paths->content."common/date-picker.php"; ?>
    			<label class="small text-muted">From Date </label>

    			<?php $name = 'date[]'; $value = $signinlog->get_filtervalue('date', 1);?>
    			<?php include $config->paths->content."common/date-picker.php"; ?>
    			<label class="small text-muted">Through Date </label>
    		</div>
            <div class="col-sm-2">
                <h4>User</h4>
                <?php $logmusers = LogmUser::load_userlist(); ?>
                <select name="user[]" class="selectpicker show-tick form-control input-sm" aria-labelledby="#actions-assignedto" data-style="btn-default btn-sm" multiple>
                    <?php foreach ($logmusers as $logmuser) : ?>
                        <?php $selected = ($signinlog->has_filtervalue('user', $logmuser->loginid)) ? 'selected' : ''; ?>
                        <option value="<?= $logmuser->loginid; ?>" <?= $selected; ?>><?= $logmuser->name; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
    	</div>
    	</br>
    	<div class="form-group">
    		<button class="btn btn-success btn-block" type="submit">Search <i class="fa fa-search" aria-hidden="true"></i></button>
    	</div>
        <div class="form-group">
            <?php if ($input->get->filter) : ?>
        		<div>
        			<?= $signinlog->generate_clearsearchlink(); ?>
        		</div>
        	<?php endif; ?>
        </div>
    </form>
</div>

<table class="table table-striped table-bordered table-condensed" id="user-signin-table">
	<thead>
		<th>Date</th>
        <th>Time</th>
        <th>User</th>
	</thead>
	<tbody>
        <?php $signinlog->get_signinlog(); ?>
		<?php foreach ($signinlog->logs as $log) : ?>
    		<tr>
                <td><?= Dplus\Base\DplusDateTime::format_date($log['date']); ?></td>
                <td><?= Dplus\Base\DplusDateTime::format_date($log['date'], "H:i A"); ?></td>
    			<td><?= LogmUser::find_username($log['user']); ?></td>
    		</tr>
        <?php endforeach; ?>
	</tbody>
</table>

<script type="text/javascript">
    $(function() {

        <?php if (!empty($signinlog->filters['user'])) : ?>
			$('.selectpicker[name="user[]"]').selectpicker('val', <?= json_encode($signinlog->filters['user']); ?>);
		<?php endif; ?>

        <?php if ($config->ajax) : ?>
            $('.selectpicker[name="user[]"]').selectpicker();
        <?php endif; ?>

        $("body").on("submit", ".signin-search-form", function(e)  { //FIXME Barbara - changed from order-search-form
            e.preventDefault();
            var form = $(this);
            var loadinto = form.data('loadinto');
            var focuson = form.data('focus');
            var action = URI(form.attr('action'));
            var queries = URI.parseQuery(URI(action).search())
            var orderby = queries.orderby; // Keep the orderby param value before clearing it
            var href = action.query('').query(form.serialize()).query(cleanparams).query(remove_emptyparams);
            if (Object.keys(href.query(true)).length == 1) {
                href.query('');
            }

            if (orderby) {
                href = href.addQuery('orderby', orderby);
            }
            href = href.toString(); // Add orderby param

            $(loadinto).loadin(href, function() {
                if (focuson.length > 0) {
                    $('html, body').animate({scrollTop: $(focuson).offset().top - 60}, 1000);
                }
            });
        });
    });
</script>
