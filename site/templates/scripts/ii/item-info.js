var itemlookupform = "#ii-item-lookup";

$(function() {
	//listener.simple_combo("u", function() {iicust()});
	listener.simple_combo("c", function() {costing();});
	listener.simple_combo("d", function() {purchorder();});
	listener.simple_combo("e", function() {docview();});
	listener.simple_combo("i", function() {compinq();});
	listener.simple_combo("h", function() {saleshist();});
	listener.simple_combo("k", function() {whsestock();});
	listener.simple_combo("n", function() {general();});
	listener.simple_combo("o", function() {salesorder();});
	listener.simple_combo("p", function() {pricing();});
	listener.simple_combo("q", function() {quotes();});
	listener.simple_combo("r", function() {requirements();});
	listener.simple_combo("s", function() {seriallot();});
	listener.simple_combo("t", function() {purchhist();});
	listener.simple_combo("u", function() {substitute();});
	listener.simple_combo("v", function() {activity();});
	listener.simple_combo("w", function() {whereused();});
	listener.simple_combo("pageup", function() {previousitem();});
	listener.simple_combo("pagedown", function() {nextitem();});

	$("body").on("focus", ".swal2-container .swal2-input", function(event) {
		console.log('focused');
		listener.stop_listening();
	});

	$(config.modals.ajax).on('hide.bs.modal', function(event) {
		listener.listen();
	});

	$(config.modals.ajax).on('shown.bs.modal', function(event) {
		listener.stop_listening();
		hidetoolbar();
	});

	$("body").on("submit", "#ii-search-item", function(e) {
		e.preventDefault();
	});

	$("body").on("submit", itemlookupform, function(e) {
		e.preventDefault();
		var itemID = $(this).find('.itemID').val();
		var custID = $(itemlookupform + " .custID").val();
		var modal = config.modals.ajax;
		var loadinto =  modal+" .modal-content";
		var href = URI($(this).attr('action')).addQuery('q', itemID)
											  .addQuery("custID", custID)
											  .addQuery('modal', 'modal')
											  .normalizeQuery().toString();
		showajaxloading();
		$(loadinto).loadin(href, function() {
			hideajaxloading();
			$(modal).find('.modal-body').addClass('modal-results');
			$(modal).resizemodal('lg').modal();
		});
	});


	$("body").on("submit", "#ii-item-activity-form", function(e) {
		e.preventDefault();
		var formid = '#'+$(this).attr('id');
		var modal = config.modals.ajax;
		var loadinto =  modal+" .modal-content";
		var itemID = $(itemlookupform + " .itemID").val();
		var custID = $(itemlookupform + " .custID").val();
		var href = URI(config.urls.products.ii.load.ii_activity).addQuery("itemID", itemID)
													.addQuery("custID", custID)
													.addQuery("startdate", $(this).find('.date-input').val())
													.addQuery('modal', 'modal')
													.query(cleanparams)
													.toString();
		showajaxloading();
		$(formid).postform({formdata: false, jsoncallback: false}, function() { //form, overwriteformdata, returnjson, callback
			$(modal).modal('hide');
			wait(500, function() {
				$(loadinto).loadin(href, function() {
					hideajaxloading();
					$(modal).find('.modal-body').addClass('modal-results');
					$(modal).resizemodal('xl').modal();
					listener.listen();
				});
			});
		});
	});

	$("body").on("submit", "#ii-sales-history-form", function(e) {
		e.preventDefault();
		var form = $(this);
		var modal = config.modals.ajax;
		var loadinto = modal+" .modal-content";
		var itemID = $(itemlookupform + " .itemID").val();
		var custID = $(itemlookupform + " .custID").val();
		var href = URI(config.urls.products.ii.load.ii_saleshistory).addQuery("itemID", itemID)
																	.addQuery("custID", custID)
																	.addQuery('modal', 'modal')
																	.query(cleanparams)
																	.toString();
		showajaxloading();
		form.postform({}, function() { //form, overwriteformdata, returnjson, callback
			$(modal).modal('hide');
			$(loadinto).loadin(href, function() {
				hideajaxloading();
				$(modal).find('.modal-body').addClass('modal-results');
				$(modal).resizemodal('xl').modal();
				listener.listen();
			});
		});
	});

	$("body").on("click", '.load-order-documents', function(e) {
		e.preventDefault();
		var itemID = $(this).data('itemid');
		var modal = config.modals.ajax;
        var loadinto =  modal+" .modal-content";
		var ordn = $(this).data('ordn');
		var type = $(this).data('type');
		var href = URI($(this).attr('href')).addQuery('modal', 'modal').toString();
		showajaxloading();
		ii_getorderdocuments(itemID, ordn, type, function() {
			wait(500, function() {
				$(loadinto).loadin(href, function() {
					console.log(href); hideajaxloading();
					$(modal).find('.modal-body').addClass('modal-results');
					$(modal).resizemodal('lg').modal();
				});
			});
		});
	});
	
	$("body").on("click", '.load-quote-documents', function(e) {
		e.preventDefault();
		var itemID = $(this).data('itemid');
		var modal = config.modals.ajax;
        var loadinto =  modal+" .modal-content";
		var qnbr = $(this).data('qnbr');
		var type = $(this).data('type');
		var href = URI($(this).attr('href')).addQuery('modal', 'modal').toString();
		showajaxloading();
		ii_getquotedocuments(itemID, qnbr, type, function() {
			wait(500, function() {
				$(loadinto).loadin(href, function() {
					console.log(href); hideajaxloading();
					$(modal).find('.modal-body').addClass('modal-results');
					$(modal).resizemodal('lg').modal();
				});
			});
		});
	});

	$("body").on("focus", '.ii-item-search', function() {
		listener.stop_listening();
	});

	$('.ii-item-search').focus();
});

/*==============================================================
   ITEM INFO FUNCTIONS
 =============================================================*/
	function pricing() {
		var custID = $(itemlookupform+' .custID').val();
		var shipID = $(itemlookupform+' .shipID').val();
		var itemID = $(itemlookupform+' .itemID').val();
		if (custID.length > 0) {
			iipricing(custID, shipID, itemID);
		} else {
			iicust('ii-pricing');
		}
	}

	function costing() {
		var itemID = $(itemlookupform + " .itemID").val();
		var modal = config.modals.ajax;
		var loadinto =  modal+" .modal-content";
		var href = URI(config.urls.products.ii.load.ii_costing).addQuery("itemID", itemID).addQuery('modal', 'modal').toString();
		showajaxloading();
		ii_costing(itemID, function() {
			$(loadinto).loadin(href, function() {
				hideajaxloading();
				$(modal).find('.modal-body').addClass('modal-results');
				$(modal).resizemodal('lg').modal();
			});
		});
	}

	function purchorder() {
		var itemID = $(itemlookupform + " .itemID").val();
		var modal = config.modals.ajax;
		var loadinto =  modal+" .modal-content";
		var href = URI(config.urls.products.ii.load.ii_purchaseorders).addQuery("itemID", itemID).addQuery('modal', 'modal').toString();
		showajaxloading();
		ii_purchaseorders(itemID, function() {
			$(loadinto).loadin(href, function() {
				hideajaxloading();
				$(modal).find('.modal-body').addClass('modal-results');
				$(modal).resizemodal('xl').modal();
			});
		});
	}

	function quotes() {
		var itemID = $(itemlookupform + " .itemID").val();
		var custID = $(itemlookupform+' .custID').val();
		var modal = config.modals.ajax;
		var loadinto = modal+" .modal-content";
		var href = URI(config.urls.products.ii.load.ii_quotes).addQuery("itemID", itemID)
												  .addQuery("custID", custID)
												  .addQuery('modal', 'modal')
												  .query(cleanparams)
												  .toString();
		showajaxloading();
		ii_quotes(itemID, function() {
			$(loadinto).loadin(href, function() {
				hideajaxloading();
				$(modal).find('.modal-body').addClass('modal-results');
				$(modal).resizemodal('xl').modal();
			});
		});
	}

	function purchhist() {
		var itemID = $(itemlookupform + " .itemID").val();
		var modal = config.modals.ajax;
		var loadinto =  modal+" .modal-content";
		var href = URI(config.urls.products.ii.load.ii_purchasehistory).addQuery("itemID", itemID).addQuery('modal', 'modal').toString();
		showajaxloading();
		ii_purchasehistory(itemID, function() {
			$(loadinto).loadin(href, function() {
				hideajaxloading();
				$(modal).find('.modal-body').addClass('modal-results');
				$(modal).resizemodal('xl').modal();
			});
		});
	}

	function whereused() {
		var itemID = $(itemlookupform + " .itemID").val();
		var modal = config.modals.ajax;
		var loadinto =  modal+" .modal-content";
		var href = URI(config.urls.products.ii.load.ii_whereused).addQuery("itemID", itemID).addQuery('modal', 'modal').toString();
		showajaxloading();
		ii_whereused(itemID, function() {
			$(loadinto).loadin(href, function() {
				hideajaxloading();
				$(modal).find('.modal-body').addClass('modal-results');
				$(modal).resizemodal('lg').modal();
			});
		});
	}

	function compinq() {
		var itemID = $(itemlookupform + " .itemID").val();
		var loadinto =  config.modals.ajax+" .modal-content";

		if (config.appconfig.ii.option_kitorbom == 'K') {
			askkitqtyneeded(itemID);
		} else if (config.appconfig.ii.option_kitorbom == 'B') {
			askbomqtyneed(itemID);
		} else {
			ask_kitorbom();
		}
	}

	function ask_kitorbom() {
		var itemID = $(itemlookupform + " .itemID").val();
		var loadinto =  config.modals.ajax+" .modal-content";
		swal({
			title: "Component Inquiry Selection",
			text: "Kit or BOM Inquiry Type in (K/B)",
			input: 'text',
			showCancelButton: true,
			inputValidator: function (value) {
				return new Promise(function (resolve, reject) {
					if (value.toUpperCase() == 'K') {
						resolve();
					} else if (value.toUpperCase() == 'B') {
						resolve();
					} else {
						reject('You need to write something!');
					}
				})
			}
		}).then(function (input) {
			if (input) {
				if (input.toUpperCase() == 'K') {
					askkitqtyneeded(itemID);
				} else if (input.toUpperCase() == 'B') {
					askbomqtyneed(itemID);
				}
			} else {
				listener.listen();
			}
		}).catch(swal.noop);
	}

	function general() {
		var itemID = $(itemlookupform + " .itemID").val();
		var modal = config.modals.ajax;
		var loadinto =  modal+" .modal-content";
		var href = URI(config.urls.products.ii.load.ii_general).addQuery("itemID", itemID).addQuery('modal', 'modal').toString();
		showajaxloading();
		ii_notes(itemID, function() {
			ii_misc(itemID, function() {
				ii_usage(itemID, function() {
					$(loadinto).loadin(href, function() {
						hideajaxloading();
						$(modal).find('.modal-body').addClass('modal-results');
						$(modal).resizemodal('lg').modal();
					});
				});
			});
		});
	}

	function activity() {
		var itemID = $(itemlookupform + " .itemID").val();
		var custID = $(itemlookupform + " .custID").val();
		var modal = config.modals.ajax;
		var loadinto =  modal+" .modal-content";
		var href = URI(config.urls.products.ii.load.ii_activityform).addQuery("itemID", itemID)
														.addQuery("custID", custID)
														.addQuery('modal', 'modal')
														.query(cleanparams)
														.toString();
		$(loadinto).loadin(href, function() {
			listener.stop_listening();
			$(modal).find('.modal-body').addClass('modal-results');
			$(modal).resizemodal('sm').modal();
			setTimeout(function (){ $(modal).find('.datepicker').focus();}, 500);
		});
	}

	function requirements(screentype, whse, loadajax, itemID) {
		if (typeof screentype === 'undefined' || screentype === false) { screentype = ''; } else {whse = $('.item-requirements-whse').val();}
		if (typeof whse === 'undefined' || whse === false) { whse = ''; } else {screentype = $('.item-requirements-screentype').val();}
		if (typeof refreshpage === 'undefined') { loadajax = true; }
		if (typeof itemID === 'undefined' || itemID === false) { itemID = $(itemlookupform + " .itemID").val();}
		console.log(screentype);
		console.log(whse);
		var modal = config.modals.ajax;
		var loadinto =  modal+" .modal-content";
		var href = URI(config.urls.products.ii.load.ii_requirements).addQuery("itemID", itemID).addQuery('modal', 'modal').toString();
		showajaxloading();
		ii_requirements(itemID, screentype, whse, function() {
			if (!loadajax) {
				hideajaxloading();
				window.location.reload(false);
			} else {
				$(loadinto).loadin(href, function() {
					hideajaxloading();
					$(modal).find('.modal-body').addClass('modal-results');
					listener.stop_listening();
					$(modal).resizemodal('lg').modal();
				});
			}
		});
	}

	function seriallot() {
		var itemID = $(itemlookupform + " .itemID").val();
		var modal = config.modals.ajax;
		var loadinto =  modal+" .modal-content";
		var href = URI(config.urls.products.ii.load.ii_lotserial).addQuery("itemID", itemID).addQuery('modal', 'modal').toString();
		showajaxloading();
		ii_lotserial(itemID, function() {
			$(loadinto).loadin(href, function() {
				hideajaxloading();
				$(modal).find('.modal-body').addClass('modal-results');
				$(modal).resizemodal('lg').modal();
			});
		});
	}

	function salesorder() {
		var itemID = $(itemlookupform + " .itemID").val();
		var modal = config.modals.ajax;
		var loadinto =  modal+" .modal-content";
		var href = URI(config.urls.products.ii.load.ii_salesorder).addQuery("itemID", itemID).addQuery('modal', 'modal').toString();
		showajaxloading();
		ii_salesorder(itemID, function() {
			$(loadinto).loadin(href, function() {
				hideajaxloading();
				$(modal).find('.modal-body').addClass('modal-results');
				listener.stop_listening();
				setTimeout(function (){ $(modal).resizemodal('xl').modal();}, 500);
			});
		});
	}

	function saleshist() {
		console.log('sales-history');
		var itemID = $(itemlookupform + " .itemID").val();
		var custID = $(itemlookupform + " .custID").val();
		var modal = config.modals.ajax;
		var loadinto =  modal+" .modal-content";
		var href = URI(config.urls.products.ii.load.ii_saleshistoryform).addQuery("itemID", itemID).addQuery("custID", custID).addQuery('modal', 'modal').toString();
		console.log(href);
		$(loadinto).loadin(href, function() {
			listener.stop_listening();
			$(modal).find('.modal-body').addClass('modal-results');
			$(modal).resizemodal('sm').modal();
			setTimeout(function (){ $(modal).find('.datepicker').focus();}, 500);
		});
	}

	function whsestock() {
		var itemID = $(itemlookupform + " .itemID").val();
		var modal = config.modals.ajax;
		var loadinto =  modal+" .modal-content";
		var href = URI(config.urls.products.ii.load.ii_stock).addQuery("itemID", itemID).addQuery('modal', 'modal').toString();
		showajaxloading();
		ii_stock(itemID, function() {
			$(loadinto).loadin(href, function() {
				hideajaxloading();
				$(modal).find('.modal-body').addClass('modal-results');
				$(modal).resizemodal('lg').modal();
			});
		})
	}

	function substitute() {
		var itemID = $(itemlookupform + " .itemID").val();
		var modal = config.modals.ajax;
		var loadinto =  modal+" .modal-content";
		var href = URI(config.urls.products.ii.load.ii_substitutes).addQuery("itemID", itemID).addQuery('modal', 'modal').toString();
		showajaxloading();
		ii_substitutes(itemID, function() {
			$(loadinto).loadin(href, function() {
				hideajaxloading();
				$(modal).find('.modal-body').addClass('modal-results');
				$(modal).resizemodal('xl').modal();
			});
		});
	}

	function iicust(dplusfunction) {
		if (typeof dplusfunction === 'undefined' || dplusfunction === false) { dplusfunction = 'ii'; }
		var modal = config.modals.ajax;
		var loadinto =  modal+" .modal-content";
		var href = URI(config.urls.customer.load.loadindex).addQuery('function', dplusfunction).addQuery('modal', 'modal').normalizeQuery().toString();
		
		$(loadinto).loadin(href, function() {
			$(modal).find('.modal-body').addClass('modal-results');
			$(modal).resizemodal('lg').modal();
			setTimeout(function (){ $(modal).find('.query').focus();}, 500);
		});
	}

	function docview() {
		var itemID = $(itemlookupform + " .itemID").val();
		var modal = config.modals.ajax;
		var loadinto =  modal+" .modal-content";
		var href = URI(config.urls.products.ii.load.ii_documents).addQuery("itemID", itemID).addQuery('modal', 'modal').toString();
		showajaxloading();
		ii_documents(itemID, function() {
			$(loadinto).loadin(href, function() {
				hideajaxloading();
				$(modal).find('.modal-body').addClass('modal-results');
				$(modal).resizemodal('xl').modal();
			});
		});
	}

/*==============================================================
   EXTENSION FUNCTIONS
 =============================================================*/
	 function askkitqtyneeded(itemID) {
		var href = URI(iiurl(config.urls.products.ii.load.ii_kit, itemID, false, false)).addQuery('modal', 'modal').toString();
		var modal = config.modals.ajax;
		var loadinto =  modal+" .modal-content";
		swal({
			title: "Kit Quantity",
			text: "Enter the Kit Quantity Needed",
			input: 'text',
			showCancelButton: true,
			inputValidator: function (value) {
				return new Promise(function (resolve, reject) {
					if (!isNaN(value)) {
						resolve();
					} else {
						reject("Your input is not numeric");
					}
				})
			}
		}).then(function (input) {
			if (input) {
				var qty = input;
				swal.close();
				showajaxloading();
				ii_kitcomponents(itemID, qty, function() {
					$(loadinto).loadin(href, function() {
						hideajaxloading();
						$(modal).find('.modal-body').addClass('modal-results');
						$(modal).resizemodal('lg').modal();
						listener.listen();
					});
				});
			} else {
				listener.listen();
			}
		}).catch(swal.noop);

	}

	function askbomqtyneed(itemID) {
		swal({
			title: "Bill of Material Inquiry",
			text: "Enter the Bill of Material Qty Needed",
			input: 'text',
			showCancelButton: true,
			inputValidator: function (value) {
				return new Promise(function (resolve, reject) {
					if (!isNaN(value)) {
						resolve();
					} else {
						reject("Your input is not numeric");
					}
				})
			}
		}).then(function (input) {
			if (input) {
				var qty = input;
				askbomsingleconsolided(itemID, qty);
			} else {
				listener.listen();
			}
		}).catch(swal.noop);
	}

	function askbomsingleconsolided(itemID, qty) {
		var href = iiurl(config.urls.products.ii.load.ii_bom, itemID, false, false);
		var modal = config.modals.ajax;
		var loadinto =  modal+" .modal-content";
		swal({
			title: "Bill of Material Inquiry",
			text: "Single or Consolidated Inquiry (S/C)",
			input: 'text',
			showCancelButton: true,
			inputValidator: function (value) {
				return new Promise(function (resolve, reject) {
					if (value.toUpperCase() == 'S') { //Single
						resolve();
					} else if (value.toUpperCase() == 'C') { //Consolidated
						resolve();
					} else {
						reject("The accepted values are S or C");
					}

				})
			}
		}).then(function (input) {
			if (input) {
				var bom = "single";
				if (input.toUpperCase() == 'S') { //Single
					bom = "single";
				} else if (input.toUpperCase() == 'C') { //Consolidated
					bom = "consolidated";
				}
				href = URI(href).addQuery('bom', bom).addQuery('modal', 'modal').normalizeQuery().toString();
				ii_bom(itemID, qty, bom, function() {
					swal.close();
					showajaxloading();
					$(loadinto).loadin(href, function() {
						hideajaxloading();
						$(modal).find('.modal-body').addClass('modal-results');
						$(modal).resizemodal('lg').modal();
						listener.listen();
					});
				});
			} else {
				listener.listen();
			}
		}).catch(swal.noop);

	}

	function ii_customer(custID) { //WAS ii_customer
		var itemID = $(itemlookupform+' .itemID').val();
		showajaxloading();
		ii_select(itemID, custID, function() {
			hideajaxloading();
			$(this).closest('.modal').modal('hide');
			window.location.href = iiurl(config.urls.products.iteminfo, itemID, custID, false);
		});
	}

	function choosecust() {
		iicust();
	}

	function previousitem() {
		var itemID = $(itemlookupform+' .prev-itemID').val();
		var custID = $(itemlookupform+' .custID').val();
		showajaxloading();
		ii_select(itemID, custID, function() {
			hideajaxloading();
			window.location.href = iiurl(config.urls.products.iteminfo, itemID, custID, false);
		});
	}

	function nextitem() {
		var itemID = $(itemlookupform+' .next-itemID').val();
		var custID = $(itemlookupform+' .custID').val();
		showajaxloading();
		ii_select(itemID, custID, function() {
			hideajaxloading();
			window.location.href = iiurl(config.urls.products.iteminfo, itemID, custID, false);
		});
	}

	function chooseiihistorycust(custID, shipID) {
		var itemID = $(itemlookupform+' .itemID').val();
		$('.modal').modal('hide');
		showajaxloading();
		ii_select(itemID, custID, function() {
			hideajaxloading();
			loadiipage(custID, shipID, itemID, function() {
				saleshist();
			});
		});
	}

	function chooseiipricingcust(custID, shipID) {
		var itemID = $(itemlookupform+' .itemID').val();
		$('.modal').modal('hide');
		showajaxloading();
		ii_select(itemID, custID, function() {
			hideajaxloading();
			loadiipage(custID, shipID, itemID, function() {
				iipricing(custID, shipID, itemID);
			});
		});
	}

	function loadiipage(custID, shipID, itemID, callback) {
		var loadinto = ".page";
		var href = iiurl(config.urls.products.iteminfo, itemID, custID, shipID);
		var msg = "Viewing item "+itemID+" info for " + custID;
		$(loadinto).load(href+" "+loadinto, function() {
			window.history.pushState({ id: 35 }, msg, href);
			callback();
		});
	}

	function iipricing(custID, shipID, itemID) {
		var href = URI(iiurl(config.urls.products.ii.load.ii_pricing, itemID, custID, shipID)).addQuery('modal', 'modal').toString();
		var modal = config.modals.ajax;
		var loadinto =  modal+" .modal-content";
		$('.modal').modal('hide');
		showajaxloading();
		ii_pricing(itemID, custID, shipID, function() {
			hideajaxloading();
			$(loadinto).loadin(href, function() {
				hideajaxloading();
				$(modal).find('.modal-body').addClass('modal-results');
				$(modal).resizemodal('lg').modal();
			});
		});
	}

	function iiurl(url, itemID, custID, shipID) {
		var uri = URI(url).addQuery("itemID", itemID);
		uri.search(function(data){
			if (custID) {
				if (custID != "") {
					data.custID = custID;
				}
			}
			if (shipID) {
				if (shipID != "") {
					data.shipID = shipID;
				}
			}
		});
		return uri.normalizeQuery().toString();
	}

	function request_orderdocuments(ordn, type) {
		var itemID = $(itemlookupform + " .itemID").val();
		var modal = config.modals.ajax;
		var loadinto = modal+" .modal-content";
		var returnpage = new URI().toString();
		var href = URI(config.urls.products.ii.json.ii_order_documents).addQuery("itemID", itemID).addQuery("ordn", ordn).addQuery('returnpage', returnpage).addQuery('modal', 'modal').toString();
		showajaxloading();
		ii_order_documents(itemID, ordn, type, function() {
			$(loadinto).loadin(href, function() {
				hideajaxloading();
				$(modal).find('.modal-body').addClass('modal-results');
				$(modal).resizemodal('lg').modal();
			});
		});
	}
