<?php
    header('Content-Type: application/json');

    $actionID = $input->get->text('id');
    $actiondisplay = new Dplus\Dpluso\UserActions\UserActionDisplay($page->fullURL);
    $action = UserAction::load($actionID);

    if ($action) {
        $urls = array(
            'completion' => $actiondisplay->generate_completionurl($action, 'true'),
            'view' => $actiondisplay->generate_viewactionurl($action),
            'reschedule' => $actiondisplay->generate_rescheduleurl($action)
        );
        $action->urls = $urls;
        echo json_encode(array(
            'response' => array(
                'error' => false,
                'action' => $action->_toArray()
            )
        ));
    } else {
        echo json_encode( array(
            'response' => array(
                'error' => true,
                'message' => 'Error finding Action with ID ' . $actionID
            )
        ));
    }
