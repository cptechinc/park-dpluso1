<?php
    $custID = ($input->get->custID) ? $input->get->text('custID') : '';
    $shipID = ($input->get->shipID) ? $input->get->text('shipID') : '';
    $contactID = ($input->get->contactID) ? $input->get->text('contactID') : '';
    $ordn = ($input->get->ordn) ? $input->get->text('ordn') : '';
    $qnbr = ($input->get->qnbr) ? $qnbr = $input->get->text('qnbr') : '';
    $actionID = ($input->get->actionID) ? $input->get->text('actionID') : '';
    $assigneduserID = ($input->get->assignedto) ? $input->get->text('assignedto') : $user->loginid;
    
	include $config->paths->content.'user-actions/crud-router.php';
