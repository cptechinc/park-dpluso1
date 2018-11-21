<?php
    $sessionID = $input->get->referenceID ? $input->get->text('referenceID') : session_id();
    $emailer = new Dplus\FileServices\DplusEmailer();
    $emailer->set_fromlogmuser($user->loginid);
    
    if ($input->requestMethod() == "POST") {
        $emailto = Dplus\FileServices\EmailContact::create_fromarray(array('email' => $input->post->text('email'), 'name' => $input->post->text('emailname')));
        $emailer->set_subject($input->post->text('subject'));
        $emailer->add_emailto($emailto);
        $emailer->set_body($input->post->text('message'));
        $emailer->set_selfbcc(true);
    }
    
    switch ($page->name) { //$page->name is what we are printing
        case 'sales-order':
            $ordn = $input->get->text('ordn');
            $orderdisplay = new Dplus\Dpluso\OrderDisplays\SalesOrderDisplay($sessionID, $page->fullURL, '#ajax-modal', $ordn);
            $order = $orderdisplay->get_order(); 
            $printurl = new \Purl\Url($orderdisplay->generate_viewprintpageurl($order));
            break;
        case 'quote':
            $qnbr = $input->get->text('qnbr');
            $quotedisplay = new Dplus\Dpluso\OrderDisplays\QuoteDisplay($sessionID, $page->fullURL, '#ajax-modal', $qnbr);
            $quote = $quotedisplay->get_quote();
            $printurl = new \Purl\Url($quotedisplay->generate_viewprintpageurl($quote));
            break;
    }
    
	$printurl->query->set('referenceID', $sessionID);
	$pdfmaker = new Dplus\FileServices\PDFMaker($sessionID, $page->name, $printurl->getUrl());
	$file = $pdfmaker->process();
    
    if ($file) {
        $error = false;
        $notifytype = 'success';
        $icon = 'fa fa-paper-plane-o';
        $emailer->add_file($file);
        $emailsent = $emailer->send();
        
        if ($emailsent) {
            $msg = "Document was created and emailed";
        } else {
            $error = true;
            $notifytype = 'danger';
            $msg = "Email Failed to Send";
            $icon = "fa fa-exclamation-triangle";
        }
        
        $page->body = array(
            'response' => array (
				'error' => $error,
				'notifytype' => $notifytype,
				'message' => $msg,
				'icon' => $icon,
                'from' => $emailer->emailfrom->email
			)
        );
    } else {
        $page->body = array(
            'response' => array (
				'error' => true,
				'notifytype' => 'danger',
				'message' => "Could not make PDF",
				'icon' => "fa fa-exclamation-triangle",
			)
        );
    }
    
    include $config->paths->content.'common/include-json-page.php';
    
    
