<?php 
	$config->user_roles = array(
		'default' => array(
			'dplus-code' => '',
			'label' => 'Default',
			'homepage' => $config->pages->dashboard
		),
		'sales-manager' => array(
			'dplus-code' => 'slsmgr',
			'label' => 'Sales Manager',
			'homepage' => $config->pages->dashboard
		),
		'sales-rep' => array(
			'dplus-code' => 'slsrep',
			'label' => 'Sales Rep',
			'homepage' => $config->pages->dashboard
		),
		'warehouse' => array(
			'dplus-code' => 'whse',
			'label' => 'Warehouse',
			'homepage' => $config->pages->warehouse
		),
		'warehouse-manager' => array(
			'dplus-code' => 'whsmgr',
			'label' => 'Warehouse Manager',
			'homepage' => $config->pages->warehouse
		),
	);
	
	$config->dplus_dplusoroles = array(
		'slsrep' => 'sales-rep',
		'slsmgr' => 'sales-manager',
		'whse'   => 'warehouse',
		'whsmgr' => 'warehouse-manager'
	);
