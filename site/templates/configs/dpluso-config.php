<?php
	$config->yesnoarray = array('No' => 'N', 'Yes' => 'Y');
	$config->buyertypes = array('P' => 'Primary', 'Y' => 'Yes', 'N' => 'No');
	$config->nonstockitems = array('N');
	$config->fob_array = array('Origin' => 'O', 'Delivery' => 'D');
	$config->dplusnotes = array(
		'sales-order' => array(
			'width' => '35', 'type' => 'SORD', 'forms' => 4, 'form1' => 'Pick Ticket', 'form2' => 'Pack Ticket', 'form3' => 'Invoice', 'form4' => 'Acknowledgement'
		),
		'quote' => array(
			'width' => '35', 'type' => 'QUOT', 'forms' => 5, 'form1' => 'Quote', 'form2' => 'Pick Ticket', 'form3' => 'Pack Ticket', 'form4' => 'Invoice', 'form5' => 'Acknowledgement'
		),
		'cart' => array(
			'width' => '35', 'type' => 'CART', 'forms' => 5, 'form1' => 'Quote', 'form2' => 'Pick Ticket', 'form3' => 'Pack Ticket', 'form4' => 'Invoice', 'form5' => 'Acknowledgement'
		)
	);
	$config->textjustify = array('r' => 'text-right', 'c' => 'text-center', 'l' => 'text-left', 'u' => '');
	$config->formattypes = array('N' => 'number', 'I' => 'integer', 'C' => 'text', 'D' => 'date');
	$config->specialordertypes = array('S' => 'Special Order', 'N' => 'Normal', 'D' => 'Dropship');
	$config->documentstoragetypes = array(
		'ii-sales-history' => 'AR',
		'ii-sales-orders' => 'SO',
		'ii' => 'IT',
		'ii-purchase-orders' => 'PO',
		'ii-purchase-history' => 'AP',
		'ci-sales-history' => 'AR',
		'ci-sales-orders' => 'SO',
		'vi' => 'VI',
		'ci-quotes' => 'QT',
		'ii-quotes' => 'QT'
	);
	
	$config->roles = array(
		'sales-rep' => 'slsrep',
		'sales-manager' => 'slsmgr',
		'warehouse' => 'whse'
	);
