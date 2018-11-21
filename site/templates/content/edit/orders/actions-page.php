<?php $actionpanel = new Dplus\Dpluso\UserActions\SalesOrderActionsPanel(session_id(), $page->fullURL, $input); ?>
<?php $actionpanel->set_ordn($ordn); ?>
<div>
	<?php include $config->paths->content."user-actions/user-actions-panel.php"; ?>
</div>
