<?php
    $showcost = $appconfig->show_cost;

    if (!$showcost) {
        if ($users->get("name=$user->loginid")->count) {
            $showcost = $users->get("name=".$user->loginid)->hasPermission('can-view-cost');
        }
    }

    $config->js('pwuser', [
        'permissions' => [
            'show_cost' => $showcost
        ]
    ]);

    $config->js('pwconfig', [
        'appconfig' => [
            'cptechcustomer' => $config->cptechcustomer,
			'ii' => [
				'option_kitorbom' => $appconfig->child('name=item-information')->option_kitorbom->value,
			],
            'useractions' => [
                'types' => UserAction::$types
            ]
        ],
        'edit' => [
            'pricing' => [
                'allow_belowminprice' => $appconfig->allow_belowminprice
            ]
        ],
        'products' => [
            'nonstockitems' => [
                'N' => 'N'
            ]
        ],
        'urls' => [
    		'index' => $config->pages->index,
    		'cart' => [
                'page' => $config->pages->cart,
                'redir' => [
                    'reorder' => $config->pages->cart."redir/?action=reorder-items"
                ]
            ],
    		'orderfiles' => $config->pages->documentstorage,
    		'customer' => [
    			'page' => $config->pages->customer,
    			'ci' => [
                    'page' => $config->pages->custinfo,
                    'load' => [
        				'ci_customer'       => "",
        				'ci_buttons'        => "",
        				'ci_shiptos'        => $config->pages->ajaxload."ci/ci-shiptos/",
        				'ci_shiptoinfo'     => $config->pages->ajaxload."ci/ci-shipto-info/",
                        'ci_pricing'        => $config->pages->ajaxload."ci/ci-pricing/",
                        'ci_pricingform'    => $config->pages->ajaxload."ci/ci-pricing-search/",
        				'ci_shiptobuttons'  => "",
        				'ci_contacts'       => $config->pages->ajaxload."ci/ci-contacts/",
        				'ci_documents'      => $config->pages->ajaxload."ci/ci-documents/",
        				'ci_standingorders' => $config->pages->ajaxload."ci/ci-standing-orders/",
        				'ci_credit'         => $config->pages->ajaxload."ci/ci-credit/",
        				'ci_openinvoices'   => $config->pages->ajaxload."ci/ci-open-invoices/",
                        'ci_orderdocuments' => $config->pages->ajaxload."ci/ci-documents/order/",
                        'ci_quotedocuments' => $config->pages->ajaxload."ci/ci-documents/quote/",
        				'ci_paymenthistory' => $config->pages->ajaxload."ci/ci-payment-history/",
        				'ci_quotes'         => $config->pages->ajaxload."ci/ci-quotes/",
                        'ci_salesorders'    => $config->pages->ajaxload."ci/ci-sales-orders/",
                        'ci_saleshistory'   => $config->pages->ajaxload."ci/ci-sales-history/",
                        'ci_custpo'         => $config->pages->ajaxload."ci/ci-custpo/"
                    ],
                    'json' => [
                        'ci_shiptolist' => $config->pages->ajaxjson."ci/ci-shipto-list/"
                    ]
                ],
    			'redir' => [
    				'ci_customer'       => $config->pages->customer."redir/?action=ci-customer",
    				'ci_buttons'        => $config->pages->customer."redir/?action=ci-buttons",
    				'ci_shiptos'        => $config->pages->customer."redir/?action=ci-shiptos",
    				'ci_shiptoinfo'     => $config->pages->customer."redir/?action=ci-shipto-info",
                    'ci_pricing'        => $config->pages->customer."redir/?action=ci-pricing",
    				'ci_shiptobuttons'  => $config->pages->customer."redir/?action=ci-shipto-buttons",
    				'ci_contacts'       => $config->pages->customer."redir/?action=ci-contacts",
    				'ci_documents'      => $config->pages->customer."redir/?action=ci-documents",
    				'ci_standingorders' => $config->pages->customer."redir/?action=ci-standing-orders",
    				'ci_credit'         => $config->pages->customer."redir/?action=ci-credit",
    				'ci_openinvoices'   => $config->pages->customer."redir/?action=ci-open-invoices",
                    'ci_orderdocuments' => $config->pages->customer."redir/?action=ci-order-documents",
                    'ci_quotedocuments' => $config->pages->customer."redir/?action=ci-quote-documents",
    				'ci_paymenthistory' => $config->pages->customer."redir/?action=ci-payments",
    				'ci_quotes'         => $config->pages->customer."redir/?action=ci-quotes",
                    'ci_salesorders'    => $config->pages->customer."redir/?action=ci-sales-orders",
                    'ci_saleshistory'   => $config->pages->customer."redir/?action=ci-sales-history",
                    'ci_custpo'         => $config->pages->customer."redir/?action=ci-custpo"
    			],
    			'load' => [
    				'loadindex'      =>  $config->pages->ajaxload."customers/cust-index/",
					'searchcontacts' => $config->pages->ajaxload."customers/contacts/"
    			]
    		],
    		'products' => [
    			'page' => $config->pages->products,
    			'iteminfo' => $config->pages->iteminfo,
                'ii' => [
                    'page' => $config->pages->iteminfo,
                    'load' => [
                        'ii_productresults'   => $config->pages->ajaxload."ii/search-results/",
            			'ii_select'           => "", // NOT USED
            			'ii_pricing'          => $config->pages->ajaxload."ii/ii-pricing/",
                        'ii_costing'          => $config->pages->ajaxload."ii/ii-costing/",
                        'ii_purchaseorders'   => $config->pages->ajaxload."ii/ii-purchase-orders/",
            			'ii_quotes'           => $config->pages->ajaxload."ii/ii-quotes/",
            			'ii_purchasehistory'  => $config->pages->ajaxload."ii/ii-purchase-history/",
            			'ii_whereused'        => $config->pages->ajaxload."ii/ii-where-used/",
                        'ii_kit'              => $config->pages->ajaxload."ii/ii-kit/",
            			'ii_bom'              => $config->pages->ajaxload."ii/ii-bom/",
            			'ii_general'          => $config->pages->ajaxload."ii/ii-general/",
            			'ii_usage'            => $config->pages->ajaxload."ii-usage/", //NOT USED part of ii_general
            			'ii_notes'            => $config->pages->ajaxload."ii-notes/", //NOT USED part of ii_general
            			'ii_misc'             => $config->pages->ajaxload."ii-misc/", //NOT USED part of ii_general
            			'ii_activity'         => $config->pages->ajaxload."ii/ii-activity/",
            			'ii_activityform'     => $config->pages->ajaxload."ii/ii-activity/form/",
            			'ii_requirements'     => $config->pages->ajaxload."ii/ii-requirements/",
            			'ii_lotserial'        => $config->pages->ajaxload."ii/ii-lot-serial/",
            			'ii_salesorder'       => $config->pages->ajaxload."ii/ii-sales-orders/",
            			'ii_saleshistory'     => $config->pages->ajaxload."ii/ii-sales-history/",
            			'ii_saleshistoryform' => $config->pages->ajaxload."ii/ii-sales-history/form/", // NOT USED
            			'ii_stock'            => $config->pages->ajaxload."ii/ii-stock/",
            			'ii_substitutes'      => $config->pages->ajaxload."ii/ii-substitutes/",
            			'ii_documents'        => $config->pages->ajaxload."ii/ii-documents/",
                        'ii_order_documents'  => $config->pages->ajaxload."ii/ii-documents/order/",
                        'ii_quote_documents'  => $config->pages->ajaxload."ii/ii-documents/quote/"
                    ],
                    'json' => [
                        'ii_moveitemdoc' => $config->pages->ajaxjson."ii/ii-move-document/",
                    ]
                ],
    			'redir' => [
    				'getitempricing'      => $config->pages->products."redir/?action=get-item-price",
                    'itemsearch'          => $config->pages->products."redir/?action=item-search",
    				'ii_select'           => $config->pages->products."redir/?action=ii-select",
    				'ii_pricing'          => $config->pages->products."redir/?action=ii-pricing",
                    'ii_costing'          => $config->pages->products."redir/?action=ii-costing",
                    'ii_purchaseorders'   => $config->pages->products."redir/?action=ii-purchase-order",
    				'ii_quotes'           => $config->pages->products."redir/?action=ii-quotes",
    				'ii_purchasehistory'  => $config->pages->products."redir/?action=ii-purchase-history",
    				'ii_whereused'        => $config->pages->products."redir/?action=ii-where-used",
                    'ii_kit'              => $config->pages->products."redir/?action=ii-kit",
    				'ii_bom'              => $config->pages->products."redir/?action=ii-bom",
    				'ii_general'          => "", //NOT USED THE MISC, NOTES, AND, USAGE
    				'ii_usage'            => $config->pages->products."redir/?action=ii-usage",
    				'ii_notes'            => $config->pages->products."redir/?action=ii-notes",
    				'ii_misc'             => $config->pages->products."redir/?action=ii-misc",
    				'ii_activity'         => $config->pages->products."redir/?action=ii-activity", //NOT USED, ACTIVITY FORM USES POSTFORM
    				'ii_activityform'     => "", //NOT USED, ACTIVITY FORM USES POSTFORM
    				'ii_requirements'     => $config->pages->products."redir/?action=ii-requirements",
    				'ii_lotserial'        => $config->pages->products."redir/?action=ii-lot-serial",
    				'ii_salesorder'       => $config->pages->products."redir/?action=ii-sales-orders",
    				'ii_saleshistoryform' => "", // NOT USED
    				'ii_stock'            => $config->pages->products."redir/?action=ii-stock",
    				'ii_substitutes'      => $config->pages->products."redir/?action=ii-substitutes",
    				'ii_documents'        => $config->pages->products."redir/?action=ii-documents",
                    'ii_order_documents'  => $config->pages->products."redir/?action=ii-order-documents",
                    'ii_quote_documents'  => $config->pages->products."redir/?action=ii-quote-documents"
    			]
    		],
    		'json' => [
    			'getloadurl'      => $config->pages->ajaxjson."get-load-url/",
    			'dplusnotes'      => $config->pages->ajaxjson."dplus-notes/",
    			'loadtask'        => $config->pages->ajaxjson."load-task/",
                'loadaction'      => $config->pages->ajaxjson."load-action/",
    			'getshipto'       => $config->pages->ajaxjson."get-shipto/",
    			'getorderhead'    => $config->pages->ajaxjson."order/orderhead/",
    			'getorderdetails' => $config->pages->ajaxjson."order/details/",
    			'getquotehead'    => $config->pages->ajaxjson."quote/quotehead/",
                'getquotedetails' => $config->pages->ajaxjson."quote/details/",
                'vendorshipfrom'  => $config->pages->ajaxjson."vendor-shipfrom/",
                'validateitemid'  => $config->pages->ajaxjson."products/validate-itemid/",
                'validateitems'   => $config->pages->ajaxjson."products/validate-items/"
    		],
    		'load' => [
    			'productresults'           => $config->pages->ajaxload."products/item-search-results/",
                'quickentry_searchresults' => $config->pages->ajaxload."products/quick-entry-search/",
    			'editdetail'               => $config->pages->ajaxload."edit-detail/", //DEPRECATED
    		],
            'vendor' => [
                'redir' => [
                    'vi_shipfrom'       => $config->pages->vendor."redir/?action=vi-shipfrom",
                    'vi_payment'        => $config->pages->vendor."redir/?action=vi-payments",
                    'vi_openinv'        => $config->pages->vendor."redir/?action=vi-open-invoices",
                    'vi_purchasehist'   => $config->pages->vendor."redir/?action=vi-purchase-history",
                    'vi_purchaseorder'  => $config->pages->vendor."redir/?action=vi-purchase-orders",
                    'vi_contact'        => $config->pages->vendor."redir/?action=vi-contact",
                    'vi_notes'          => $config->pages->vendor."redir/?action=vi-notes",
                    'vi_costing'        => $config->pages->vendor."redir/?action=vi-costing",
                    'vi_unreleased'     => $config->pages->vendor."redir/?action=vi-unreleased-purchase-orders",
                    'vi_uninvoiced'     => $config->pages->vendor."redir/?action=vi-uninvoiced",
                    'vi_24monthsummary' => $config->pages->vendor."redir/?action=vi-24monthsummary",
                    'vi_docview'        => $config->pages->vendor."redir/?action=vi-docview"
                ],
                'load' => [
                    'vi_shipfrom'          => $config->pages->ajaxload."vi/vi-shipfrom/",
                    'vi_payment'           => $config->pages->ajaxload."vi/vi-payments/",
                    'vi_openinv'           => $config->pages->ajaxload."vi/vi-open-invoices/",
                    'vi_purchasehist'      => $config->pages->ajaxload."vi/vi-purchase-history/",
                    'vi_purchasehist_form' => $config->pages->ajaxload."vi/vi-purchase-history/form/",
                    'vi_purchaseorder'     => $config->pages->ajaxload."vi/vi-purchase-orders/",
                    'vi_contact'           => $config->pages->ajaxload."vi/vi-contact/",
                    'vi_notes'             => $config->pages->ajaxload."vi/vi-notes/",
                    'vi_costing'           => $config->pages->ajaxload."vi/vi-costing/",
                    'vi_costingform'       => $config->pages->ajaxload."vi/vi-costing-search/",
                    'vi_unreleased'        => $config->pages->ajaxload."vi/vi-unreleased-purchase-orders/",
                    'vi_uninvoiced'        => $config->pages->ajaxload."vi/vi-uninvoiced/",
                    'vi_24monthsummary'    => $config->pages->ajaxload."vi/vi-24monthsummary/",
                    'vi_docview'           => $config->pages->ajaxload."vi/vi-docview/"
                ],
                'json' => [
                    'vi_shipfromlist' => $config->pages->ajaxjson."vi/vi-shipfrom-list/"
                ]
            ],
            'sales_order' => [
                'load' => [
                    'page'     => $config->pages->ajaxload."order/",
                    'docs'     => $config->pages->ajaxload."order/documents/",
                    'tracking' => $config->pages->ajaxload."order/tracking/"
                ]
            ],
            'warehouse' => [
                'json' => [
                    'session' => "{$config->pages->ajaxjson}warehouse/session/"
                ],
                'picking' => [
                    'sales_order' => [
                        'redir' => [
                            'redir'        => $config->pages->salesorderpicking."redir/",
                            'cancel_order' => $config->pages->salesorderpicking."redir/?action=cancel-order"
                        ]
                    ]
                ],
                'inventory' => [
                    'bin_inquiry' => $config->pages->inventory_bininquiry,
                    'redir' => [
                        'redir'        => $config->pages->menu_inventory . "redir/",
                        'bin_inquiry'  => $config->pages->menu_inventory . "redir/?action=bin-inquiry"
                    ]
                ]
            ]
    	],
        'paths' => [
    		'assets' => [
    			'images' =>  $config->pages->index."site/assets/files/images/"
    		]
    	],
    	'modals' => [
    		'pricing'    => '#pricing-modal',
        	'ajax'       => '#ajax-modal',
    		'lightbox'   => '#lightbox-modal',
            'itemlookup' => '#item-lookup-modal',
    		'gradients'  => [
    			'default' => 'icarus',
    			'tribute' => 'tribute'
    		]
    	],
    	'toolbar' => [
    		'toolbar' => '#function-toolbar',
    		'button'  => '#show-toolbar'
    	]
    ]);
