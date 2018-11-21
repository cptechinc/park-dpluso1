<?php
    use Dplus\Dpluso\OrderDisplays\EditSalesOrderDisplay;
    use Dplus\Dpluso\OrderDisplays\QuoteDisplay;
    
    switch ($page->parent->name) { //$page->name is what we are editing
        case 'order':
            $ordn = $input->get->text('ordn');
            $orderdisplay = new EditSalesOrderDisplay(session_id(), $page->fullURL, '#ajax-modal', $ordn);
            $order = $orderdisplay->get_order(); 
            $page->title = 'Summary for Order # '.$ordn;
            $page->body = $config->paths->content."confirm/orders/outline.php";
            break;
        case 'quote':
            $qnbr = $input->get->text('qnbr');
            $quotedisplay = new QuoteDisplay(session_id(), $page->fullURL, '#ajax-modal', $qnbr);
            $quote = $quotedisplay->get_quote();
            $page->title = 'Summary for Quote # '.$qnbr;
            $page->body = $config->paths->content."confirm/quotes/outline.php";
            break;
    }
 ?>
 <?php include('./_head.php'); // include header markup ?>
    <div class="jumbotron pagetitle">
        <div class="container">
            <h1><?php echo $page->get('pagetitle|headline|title') ; ?></h1>
        </div>
    </div>
     <div class="container page" id="edit-page">
        <?php include ($page->body); ?>
     </div>
 <?php include('./_foot.php'); // include footer markup ?>
