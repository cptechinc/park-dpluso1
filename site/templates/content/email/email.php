<?php
    
    $send = SimpleMail::make()
    ->setTo('paul@cptechinc.com', 'Paul Gomez')
    ->setFrom('sales@cptechinc.com', 'CPTech Sales')
    ->setSubject('Order Confirmation')
    ->setMessage($page->body)
    ->setReplyTo('sales@cptechinc.com', 'Cptech Sales')
    ->setHtml()
    ->setWrap(100)
    ->send();
    echo ($send) ? 'Email sent successfully' : 'Could not send email';

    echo $page->body;
