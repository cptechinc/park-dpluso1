var custlookupform = "#ci-cust-lookup";

$(function() {
	$("body").on("focus", ".sweet-alert.show-input input", function(event) {
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

	$("body").on("submit", custlookupform, function(e) {
		e.preventDefault();
		var custID = $(this).find('.custID').val();
		var modal = config.modals.ajax;
        var loadinto =  modal+" .modal-content";
		var href = URI($(this).attr('action')).addQuery('q', custID).addQuery('function', 'ci').addQuery('modal', 'modal').normalizeQuery().toString();
		showajaxloading();
		$(loadinto).loadin(href, function() {
			hideajaxloading();
			$(modal).find('.modal-body').addClass('modal-results');
			$(modal).resizemodal('lg').modal();
		});
	});

	$("body").on("submit", "#cust-sales-history-form", function(event) {
		event.preventDefault();
		var form = $(this);
		var custID = form.find('input[name=custID]').val();
		var shipID = form.find('input[name=shipID]').val();
		var startdate = form.find('input[name=date]').val();
		var modal = config.modals.ajax;
		var loadinto =  modal+" .modal-content";
		var href = URI(config.urls.customer.ci.load.ci_saleshistory).addQuery("custID", custID)
																 .addQuery("shipID", shipID)
																 .addQuery("startdate", startdate)
																 .addQuery('modal', 'modal')
																 .toString();
		showajaxloading();
		ci_saleshistory(custID, shipID, startdate, function() {
			$(loadinto).loadin(href, function() {
				hideajaxloading();
				$(modal).find('.modal-body').addClass('modal-results');
				$(modal).resizemodal('xl').modal();
			});
		});
	});

	$("body").on("change", "select#shownotes", function(event) {
		event.preventDefault();
		var select = $(this);
		var shownotesvalue = select.val();
		if (shownotesvalue == 'Y') {
			$('.show-notes').removeClass('hidden');
		} else {
			$('.show-notes').addClass('hidden');
		}
	});

	$("body").on("click", '.load-order-documents', function(e) {
		e.preventDefault();
		var custID = $(this).data('custid');
		var modal = config.modals.ajax;
        var loadinto =  modal+" .modal-content";
		var ordn = $(this).data('ordn');
		var type = $(this).data('type');
		var href = URI($(this).attr('href')).addQuery('modal', 'modal').toString();
		showajaxloading();
		ci_getorderdocuments(custID, ordn, type, function() {
			wait(500, function() {
				$(loadinto).loadin(href, function() {
					console.log(href); hideajaxloading();
					$(modal).find('.modal-body').addClass('modal-results');
					$(modal).resizemodal('lg').modal();
				});
			});
		});
	});

	$("body").on("click", '.load-order-documents', function(e) {
		e.preventDefault();
		var custID = $(this).data('custid');
		var modal = config.modals.ajax;
        var loadinto =  modal+" .modal-content";
		var ordn = $(this).data('ordn');
		var type = $(this).data('type');
		var href = URI($(this).attr('href')).addQuery('modal', 'modal').toString();
		showajaxloading();
		ci_getorderdocuments(custID, ordn, type, function() {
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
		var custID = $(this).data('custid');
		var modal = config.modals.ajax;
        var loadinto =  modal+" .modal-content";
		var qnbr = $(this).data('qnbr');
		var type = $(this).data('type');
		var href = URI($(this).attr('href')).addQuery('modal', 'modal').toString();
		showajaxloading();
		ci_getquotedocuments(custID, qnbr, type, function() {
			wait(500, function() {
				$(loadinto).loadin(href, function() {
					console.log(href); hideajaxloading();
					$(modal).find('.modal-body').addClass('modal-results');
					$(modal).resizemodal('lg').modal();
				});
			});
		});
	});

	$(window).resize(function() {
		if ($(window).width() < 768) {
			$('#show-toolbar').addClass('hidden');
		} else {
			$('#show-toolbar').removeClass('hidden');
		}
	});

	$('#contacts-div').on('shown.bs.collapse', function () {
		if ($(this).data('tableloaded') === "no") {
			$(this).data('tableloaded', "yes");
			var table = $('#contacts-table').DataTable({
				"columnDefs": [
					{ "targets": [ 6 ], "visible": false, "bRegex": true, "bSmart": false },
				]
			});

			$('#limit-shiptos').change(function() {
				if ($(this).is(':checked')) {
					if ($(this).val().length > 0) {
						table.columns( 1 ).search("^" + this.value + "$", true, false, true).draw();
					}
				} else {
					table.columns( 1 ).search('').draw();
				}
			});

			$('#limit-cc').change(function() {
				if ($(this).is(':checked')) {
					table.columns( 6 ).search("^" + 'CC' + "$", true, false, true).draw();
				} else {
					table.columns( 6 ).search('').draw();
				}
			});

			if ($(this).data('shipid') !== '') {
				$('#limit-shiptos').bootstrapToggle('on');
			}
		}
	});
});

function shipto() { //CAN BE USED IF SHIPTO IS DEFINED
	var custID = $(custlookupform + " .custID").val();
	var shipID = $(custlookupform + " .shipID").val();
	var modal = config.modals.ajax;
	var loadinto =  modal+" .modal-content";
	var href = URI(config.urls.customer.ci.load.ci_shiptos).addQuery("custID", custID)
														.addQuery("shipID", shipID)
														.addQuery('modal', 'modal')
														.query(cleanparams)
														.toString();
	showajaxloading();

	$.getJSON(config.urls.customer.ci.json.ci_shiptolist, function( json ) {
		if (json.data) {
			if (Object.keys(json.data).length > 1) {
				$(loadinto).loadin(href, function() {
					hideajaxloading();
					$(modal).find('.modal-body').addClass('modal-results');
					$(modal).resizemodal('lg').modal();
				});
			} else if (Object.keys(json.data).length == 1) {
				var key = 0;
				if (json.data[0]) {key = 0;} else {key = 1;}
				url = URI(config.urls.customer.redir.ci_shiptoinfo).addQuery("custID", custID)
																	.addQuery("shipID", json.data[key].shipid)
																	.addQuery('modal', 'modal')
																	.query(cleanparams)
																	.toString();
				window.location.href = url;
			} else {
				$(loadinto).loadin(href, function() {
					hideajaxloading();
					$(modal).find('.modal-body').addClass('modal-results');
					$(modal).resizemodal('lg').modal();
				});
			}
		} else {
			$(loadinto).loadin(href, function() {
				hideajaxloading();
				$(modal).find('.modal-body').addClass('modal-results');
				$(modal).resizemodal('lg').modal();
			});
		}

	});
}

function contact() {
	var custID = $(custlookupform + " .custID").val();
	var shipID = $(custlookupform + " .shipID").val();
	var modal = config.modals.ajax;
	var loadinto =  modal+" .modal-content";
	var href = URI(config.urls.customer.ci.load.ci_contacts).addQuery("custID", custID).addQuery('shipID', shipID).addQuery('modal', 'modal').query(cleanparams).toString();
	showajaxloading();
	ci_contacts(custID, shipID, function() {
		loadin(href, loadinto, function() {
			hideajaxloading(); console.log(href);
			$(modal).find('.modal-body').addClass('modal-results');
			$(modal).resizemodal('lg').modal();
		});
	});
}

function pricing() {
	var custID = $(custlookupform + " .custID").val();
	var href = URI(config.urls.customer.ci.load.ci_pricingform).addQuery("custID", custID).addQuery('modal', 'modal').toString();
	var modal = config.modals.ajax;
	var loadinto =  modal+" .modal-content";
	showajaxloading();
	$(loadinto).loadin(href, function() {
		hideajaxloading(); console.log(href);
		$(modal).find('.modal-body').addClass('modal-results');
		$(modal).resizemodal('lg').modal();
	});
}

function choosecipricingitem(itemID) {
	var custID = $(custlookupform + " .custID").val();
	var modal = config.modals.ajax;
	var loadinto =  modal+" .modal-content";
	console.log(config.urls.customer.redir.ci_pricing+"&custID="+urlencode(custID)+"&itemID="+urlencode(itemID));
	var href = URI(config.urls.customer.ci.load.ci_pricing).addQuery("custID", custID).addQuery("itemID", itemID).addQuery('modal', 'modal').toString();
	ci_pricing(custID, itemID, function() {
		$(loadinto).loadin(href, function() {
			hideajaxloading();
			$(modal).find('.modal-body').addClass('modal-results');
			$(modal).resizemodal('lg').modal();
		});
	});
}

function salesorder() { //CAN BE USED IF SHIPTO IS DEFINED
	var custID = $(custlookupform + " .custID").val();
	var shipID = $(custlookupform + " .shipID").val();
	var modal = config.modals.ajax;
	var loadinto =  modal+" .modal-content";
	var href = URI(config.urls.customer.ci.load.ci_salesorders).addQuery("custID", custID).addQuery("shipID", shipID).addQuery('modal', 'modal').toString();
	showajaxloading();
	ci_salesorder(custID, shipID, function() {
		$(loadinto).loadin(href, function() {
			hideajaxloading(); console.log(href);
			$(modal).find('.modal-body').addClass('modal-results');
			$(modal).resizemodal('xl').modal();
		});
	});
}

function saleshist() { //CAN BE USED IF SHIPTO IS DEFINED
	var custID = $(custlookupform + " .custID").val();
	var shipID = $(custlookupform + " .shipID").val();
	var modal = config.modals.ajax;
	var loadinto =  modal+" .modal-content";
	var href = URI(config.urls.customer.ci.load.ci_saleshistory+"form/").addQuery("custID", custID)
																	 .addQuery("shipID", shipID)
																	 .addQuery('modal', 'modal')
																	 .toString();
	showajaxloading();
	$(loadinto).loadin(href, function() {
		hideajaxloading();
		$(modal).find('.modal-body').addClass('modal-results');
		$(modal).resizemodal('sm').modal();
	});

}
function custpo() { //CAN BE USED IF SHIPTO IS DEFINED
	var custID = $(custlookupform + " .custID").val();
	var shipID = $(custlookupform + " .shipID").val();
	var modal = config.modals.ajax;
	var loadinto =  modal+" .modal-content";
	var href = URI(config.urls.customer.ci.load.ci_custpo).addQuery("custID", custID).addQuery("shipID", shipID).toString();
	swal({
		title: "Customer PO Inquiry",
	 	text: "Enter a PO:",
		input: 'text',
		showCancelButton: true,
		inputValidator: function (value) {
			return new Promise(function (resolve, reject) {
				if (value === false) {
					reject("You need to write something!");
				} else if (value === "") {
					reject("You need to write something!");
				} else {
					resolve();
				}
			})
		}
	}).then(function (input) {
		if (input) {
			swal.close();
			href = URI(href).addQuery("custpo", input).addQuery('modal', 'modal').toString();
			ci_custpo(custID, shipID, input, function() {
				$(loadinto).loadin(href, function() {
					hideajaxloading();
					$(modal).find('.modal-body').addClass('modal-results');
					$(modal).resizemodal('lg').modal();
				});
			});

		} else {
			listener.listen();
		}
	}).catch(swal.noop);
}

function quotes() {
	var custID = $(custlookupform + " .custID").val();
	var modal = config.modals.ajax;
	var loadinto =  modal+" .modal-content";
	var href = URI(config.urls.customer.ci.load.ci_quotes).addQuery("custID", custID).addQuery('modal', 'modal').toString();
	showajaxloading();
	ci_quotes(custID, function() {
		$(loadinto).loadin(href, function() {
			hideajaxloading();
			$(modal).find('.modal-body').addClass('modal-results');
			$(modal).resizemodal('xl').modal();
		});
	});
}

function openinv() {
	var custID = $(custlookupform + " .custID").val();
	var modal = config.modals.ajax;
	var loadinto =  modal+" .modal-content";
	var href = URI(config.urls.customer.ci.load.ci_openinvoices).addQuery("custID", custID).addQuery('modal', 'modal').toString();
	showajaxloading();
	ci_openinvoices(custID, function() {
		$(loadinto).loadin(href, function() {
			hideajaxloading();
			$(modal).find('.modal-body').addClass('modal-results');
			$(modal).resizemodal('lg').modal();
		});
	});
}

function request_orderdocuments(ordn, type) {
	var custID = $(custlookupform + " .custID").val();
	var modal = config.modals.ajax;
	var loadinto =  modal+" .modal-content";
	var returnpage = new URI().toString();
	var href = URI(config.urls.customer.ci.load.ci_orderdocuments).addQuery("custID", custID).addQuery('ordn', ordn).addQuery('returnpage', returnpage).addQuery('modal', 'modal').toString();
	showajaxloading();
	ci_getorderdocuments(custID, ordn, type, function() {
		wait(500, function() {
			$(loadinto).loadin(href, function() {
				console.log(href); hideajaxloading();
				$(modal).find('.modal-body').addClass('modal-results');
				$(modal).resizemodal('lg').modal();
			});
		});
	});
}

function payment() {
	var custID = $(custlookupform + " .custID").val();
	var modal = config.modals.ajax;
	var loadinto =  modal+" .modal-content";
	var href = URI(config.urls.customer.ci.load.ci_paymenthistory).addQuery("custID", custID).addQuery('modal', 'modal').toString();
	showajaxloading();
	ci_paymenthistory(custID, function() {
		$(loadinto).loadin(href, function() {
			hideajaxloading();
			$(modal).find('.modal-body').addClass('modal-results');
			$(modal).resizemodal('lg').modal();
		});
	});
}

function custcredit() {
	var custID = $(custlookupform + " .custID").val();
	var modal = config.modals.ajax;
	var loadinto =  modal+" .modal-content";
	var href = URI(config.urls.customer.ci.load.ci_credit).addQuery("custID", custID).addQuery('modal', 'modal').toString();
	showajaxloading();
	ci_credit(custID, function() {
		$(loadinto).loadin(href, function() {
			hideajaxloading();
			$(modal).find('.modal-body').addClass('modal-results');
			$(modal).resizemodal('lg').modal();
		});
	});
}

function standorders() { //CAN BE USED IF SHIPTO IS DEFINED
	var custID = $(custlookupform + " .custID").val();
	var shipID = $(custlookupform + " .shipID").val();
	var modal = config.modals.ajax;
	var loadinto =  modal+" .modal-content";
	var href = URI(config.urls.customer.ci.load.ci_standingorders).addQuery("custID", custID)
															   .addQuery("shipID", shipID)
															   .addQuery('modal', 'modal')
															   .toString();
	showajaxloading();
	ci_standingorders(custID, shipID, function() {
		$(loadinto).loadin(href, function() {
			hideajaxloading();
			$(modal).find('.modal-body').addClass('modal-results');
			$(modal).resizemodal('lg').modal();
		});
	});
}
function customerstock() { //CAN BE USED IF SHIPTO IS DEFINED
	//TODO
	generate_notavailablefunction();
}

function notes() { //CAN BE USED IF SHIPTO IS DEFINED
	//TODO
	generate_notavailablefunction();
}

function docview() {
	var custID = $(custlookupform + " .custID").val();
	var modal = config.modals.ajax;
	var loadinto =  modal+" .modal-content";
	var href = URI(config.urls.customer.ci.load.ci_documents).addQuery("custID", custID).addQuery('modal', 'modal').toString();
	showajaxloading();
	ci_documents(custID, function() {
		$(loadinto).loadin(href, function() {
			hideajaxloading();
			$(modal).find('.modal-body').addClass('modal-results');
			$(modal).resizemodal('xl').modal();
		});
	});

}

/*==============================================================
   SUPPLEMENTAL FUNCTIONS
=============================================================*/

function toggleshipto() {
	showajaxloading();
	var custID = $(custlookupform + " .custID").val();
	var nextshipID = '';
	if (!$(custlookupform + " .shipID").val() != '') { nextshipID = $(custlookupform + " .nextshipID").val(); }
	ci_shiptoinfo(custID, nextshipID, function() {
		var href = config.urls.customer.ci.page + "/"+urlencode(custID)+"/";
		if (nextshipID != '') {
			href += 'shipto-'+nextshipID+'/';
		}
		hideajaxloading();
		window.location.href = href;
	});
}


function loadshiptoinfo(custID, shipID) {
	var href = URI(config.urls.customer.ci.load.ci_shiptoinfo).addQuery("custID", custID)
														   .addQuery('shipID', shipID)
														   .toString();
	var modal = config.modals.ajax;
	var loadinto =  modal+" .modal-content";
	showajaxloading();
	ci_shiptoinfo(custID, shipID, function() {
		$(loadinto).loadin(href, function() {
			hideajaxloading(); console.log(href);
			$(modal).resizemodal('lg').modal();
		});
	});
}

function choosecisaleshistoryitem(itemID) {
	var row = $('[href=#'+itemID+']');
	row.siblings().remove();
	$('.ci-history-item-search').val(itemID);
	$('#cust-sales-history-form').submit();
}

function refreshshipto(shipID, custID) {
	var href = URI(config.urls.customer.redir.ci_shiptoinfo).addQuery("custID", custID);

	if (shipID.trim() != '') {
		href.addQuery('shipID', shipID);
	}

	var location = href.toString();
	window.location.href = location;
}
