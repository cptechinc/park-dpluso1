<?php
    switch ($input->urlSegment(1)) {
        case 'customers':
            include $config->paths->content . 'ajax/load/cust-router.php';
            break;
		case 'sales-orders': //ADDED 12/22/2016 $input->urlSegment(3) is going to be cust or salesrep
            include $config->paths->content . 'ajax/load/orders-router.php';
            break;
		case 'sales-history':
			include $config->paths->content . 'ajax/load/sales-history-router.php';
			break;
        case 'quotes': //ADDED 12/22/2016 $input->urlSegment(3) is going to be cust or salesrep
            include $config->paths->content . 'ajax/load/quotes-router.php';
            break;
		case 'bookings':
			include $config->paths->content . 'ajax/load/bookings-router.php';
			break;
        case 'notes':
            include $config->paths->content . 'ajax/load/notes-router.php';
            break;
        case 'products':
            include $config->paths->content . 'ajax/load/products-router.php';
            break;
        case 'edit-detail':
            include $config->paths->content . 'ajax/load/edit-detail-router.php';
            break;
        case 'add-detail':
            include $config->paths->content . 'ajax/load/add-detail-router.php';
            break;
        case 'view-detail':
            include $config->paths->content . 'ajax/load/view-detail-router.php';
            break;
        case 'order':
            include $config->paths->content . 'ajax/load/order-router.php';
            break;
        case 'ii':
            include $config->paths->content . 'item-information/ajax-load-router.php';
            break;
        case 'ci':
            include $config->paths->content . 'cust-information/ajax-load-router.php';
            break;
        case 'vi':
            include $config->paths->content . 'vend-information/ajax-load-router.php';
            break;
        case 'vendors':
            include $config->paths->content . 'ajax/load/vendor-router.php';
            break;
        case 'email':
            include $config->paths->content . 'email/ajax-load-router.php';
            break;
        default:
            throw new Wire404Exception();
            break;
    }
