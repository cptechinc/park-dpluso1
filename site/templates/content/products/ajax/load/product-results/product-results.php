<?php
    $addtype = $input->urlSegment(3); // cart|order|quote
    $linenumber = $input->get->text('linenumber');
    $addtoform = new stdClass();

    switch($addtype) {
        case 'cart':
            $ordn = '';
            $addtoform->action = $config->pages->cart."redir/";
            $addtoform->rediraction = 'add-to-cart';
            $addtoform->returnpage = $config->pages->cart;
            break;
		case 'order':
            $ordn = $sanitizer->text($input->get->ordn);
            $addtoform->action = $config->pages->orders."redir/";
            $addtoform->rediraction = 'add-to-order';
            $addtoform->returnpage = $config->pages->edit."order/?ordn=".$ordn;
            break;
		case 'quote':
            $qnbr = $sanitizer->text($input->get->qnbr);
            $addtoform->action = $config->pages->quotes."redir/";
            $addtoform->rediraction = 'add-to-quote';
            $addtoform->returnpage = $input->get->order ? $config->pages->edit."quote-to-order/?qnbr=$qnbr" : $config->pages->edit."quote/?qnbr=$qnbr";
            break;
    }
    $items = get_itemsearchresults(session_id(), $config->showonpage, $input->pageNum());
    $totalcount = count_itemsearchresults(session_id());
    $paginator = new Dplus\Content\Paginator($input->pageNum, $totalcount, $page->fullURL, $addtype, 'data-loadinto=".results" data-focus=".results"');

    if ($config->ajax) {
		echo $page->bootstrap->create_element('p', '', $page->bootstrap->generate_printlink($config->filename, 'View Printable Version'));
	}

    echo $page->bootstrap->open('div', 'class=results');
        if ($totalcount > 0) {
            foreach ($items as $item) {
                $pricing = $specs = $item->_toArray();

                switch ($addtype) {
                    case 'cart':
                        if ($modules->isInstalled('CaseQtyBottle')) {
                            include $config->paths->siteModules.'CaseQtyBottle/content/item-search/add-detail/cart.php';
                        } else {
                            include $config->paths->content."products/ajax/load/product-results/product-cart-results.php";
                        }
                        break;
                    case 'order':
                        if ($modules->isInstalled('CaseQtyBottle')) {
                            include $config->paths->siteModules.'CaseQtyBottle/content/item-search/add-detail/sales-order.php';
                        } else {
                            include $config->paths->content."products/ajax/load/product-results/product-order-results.php";
                        }
                        break;
                    case 'quote':
                        if ($modules->isInstalled('CaseQtyBottle')) {
                            include $config->paths->siteModules.'CaseQtyBottle/content/item-search/add-detail/quote.php';
                        } else {
                            include $config->paths->content."products/ajax/load/product-results/product-quote-results.php";
                        }
                        break;
                }
            }
        } else {
            echo $page->bootstrap->h4('', 'No Items found');
        }
    echo $page->bootstrap->close('div');
    echo $paginator;
