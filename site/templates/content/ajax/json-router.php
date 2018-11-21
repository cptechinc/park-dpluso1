<?php
    switch ($input->urlSegment(1)) {
        case 'get-load-url':
            include $config->paths->content . 'ajax/json/get-load-url.php';
            break;
        case 'dplus-notes':
            include $config->paths->content . 'ajax/json/get-dplus-note.php';
            break;
        case 'get-shipto':
            include $config->paths->content . 'ajax/json/get-shipto.php';
            break;
        case 'order':
            include $config->paths->content . 'ajax/json/order-json-router.php';
            break;
        case 'quote':
            include $config->paths->content . 'ajax/json/quote-json-router.php';
            break;
        case 'cart':
            include $config->paths->content . 'ajax/json/cart-json-router.php';
            break;
        case 'test-json':
            include $config->paths->content."ajax/json/test-json.php";
            break;
        case 'move-file':
            include $config->paths->content."ajax/json/move-file.php";
            break;
        case 'ii':
            include $config->paths->content."ajax/json/ii-json-router.php";
            break;
        case 'ci':
            include $config->paths->content."ajax/json/ci-json-router.php";
            break;
        case 'vi':
            include $config->paths->content."ajax/json/vi-json-router.php";
            break;
        case 'load-action';
            include $config->paths->content."user-actions/crud/read/json.php";
            break;
        case 'vendor-shipfrom':
            include $config->paths->content."ajax/json/vendor-shipfrom.php";
            break;
        case 'products':
            include $config->paths->content."ajax/json/products-json-router.php";
            break;
        case 'warehouse':
            include $config->paths->content."warehouse/json-router.php";
            break;
        default:
            throw new Wire404Exception();
            break;
    }
?>
