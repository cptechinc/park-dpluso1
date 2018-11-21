var vendlookupform = "#vi-vend-lookup";

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

	listener.simple_combo("n", function() {toggleshipto();});

	$("body").on("submit", vendlookupform, function(e) {
		e.preventDefault();
		var vendorID = $(this).find('.vendorID').val();
		var modal = config.modals.ajax;
        var loadinto =  modal+" .modal-content";
		var href = URI($(this).attr('action')).addQuery('q', vendorID).addQuery('function', 'vi').addQuery('modal', 'modal').normalizeQuery().toString();
		showajaxloading();
		$(loadinto).loadin(href, function() {
			hideajaxloading();
			$(modal).find('.modal-body').addClass('modal-results');
			$(modal).resizemodal('lg').modal();
		});
	});

	$("body").on("submit", '#vi-purchase-history-form', function(e) {
		e.preventDefault();
		var formid = '#'+$(this).attr('id');
		var vendorID = $(this).find('[name=vendorID]').val();
		var shipfromID = $(this).find('[name=shipfromID]').val();
		var modal = config.modals.ajax;
        var loadinto =  modal+" .modal-content";
		var href = URI(config.urls.vendor.load.vi_purchasehist).addQuery("vendorID", vendorID).addQuery("shipfromID", shipfromID).addQuery('modal', 'modal').toString();
		showajaxloading();
		$(formid).postform({formdata: false, jsoncallback: false}, function() { //form, overwriteformdata, returnjson, callback
			$(modal).modal('hide');
			wait(2000, function() {
				$(loadinto).loadin(href, function() {
					hideajaxloading();
					$(modal).find('.modal-body').addClass('modal-results');
					$(modal).resizemodal('xl').modal();
					listener.listen();
				});
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
});

    // ADD LINE BELOW under vendorID to buttons that pull from both... also addQuery to href in function
    // var shipfromID = $(vendlookupform + " .shipfromID").val();

function payment() {
	var vendorID = $(vendlookupform + " .vendorID").val();
	var modal = config.modals.ajax;
	var loadinto =  modal+" .modal-content";
	var href = URI(config.urls.vendor.load.vi_payment).addQuery("vendorID", vendorID).addQuery('modal', 'modal').toString();
	showajaxloading();
	vi_payment(vendorID, function() {
		$(loadinto).loadin(href, function() {
			hideajaxloading(); console.log(href);
			$(modal).find('.modal-body').addClass('modal-results');
			$(modal).resizemodal('xl').modal();
		});
	});
}

function openinv() {
	var vendorID = $(vendlookupform + " .vendorID").val();
	var modal = config.modals.ajax;
	var loadinto =  modal+" .modal-content";
	console.log(config.urls.vendor.load.vi_openinv);
	var href = URI(config.urls.vendor.load.vi_openinv).addQuery("vendorID", vendorID).addQuery('modal', 'modal').toString();
	showajaxloading();
	vi_openinv(vendorID, function() {
		$(loadinto).loadin(href, function() {
			hideajaxloading(); console.log(href);
			$(modal).find('.modal-body').addClass('modal-results');
			$(modal).resizemodal('lg').modal();
		});
	});
}

function purchasehist() {
	var vendorID = $(vendlookupform + " .vendorID").val();
	var shipfromID = $(vendlookupform + " .shipfromID").val();
	var modal = config.modals.ajax;
	var loadinto =  modal+" .modal-content";
	var href = URI(config.urls.vendor.load.vi_purchasehist_form).addQuery("vendorID", vendorID).addQuery("shipfromID", shipfromID).addQuery('modal', 'modal').toString();
	showajaxloading();
	$(loadinto).loadin(href, function() {
		hideajaxloading(); console.log(href);
		$(modal).find('.modal-body').addClass('modal-results');
		$(modal).resizemodal('sm').modal();
	});
}

function shipfrom() {
	var vendorID = $(vendlookupform + " .vendorID").val();
	var modal = config.modals.ajax;
	var loadinto =  modal+" .modal-content";
	showajaxloading();
    console.log(config.urls.vendor.json.vi_shipfromlist);
    $.getJSON(config.urls.vendor.json.vi_shipfromlist, function(json) {
        if (json.response.error) {
			hideajaxloading();
            swal({
              title: 'Error!',
              text: json.response.errormsg,
              type: 'error',
              confirmButtonText: 'OK'
            }).catch(swal.noop);
        } else {
            console.log(json);
            if (json.response.shipfromlist) {
                var shipfromID = json.response.shipfromlist[1].shipid;
                vi_shipfrom(vendorID, shipfromID, function() {
            		generateurl(function(url) {
                		window.location.href=url;
                	});
            	});
            } else {
				hideajaxloading();
                swal({
                  title: 'Error!',
                  text: 'This vendor has no Ship-Froms',
                  type: 'error',
                  confirmButtonText: 'OK'
                }).catch(swal.noop);
            }
        }
    });
}

function purchaseorder() {
	var vendorID = $(vendlookupform + " .vendorID").val();
	var modal = config.modals.ajax;
	var loadinto =  modal+" .modal-content";
	var href = URI(config.urls.vendor.load.vi_purchaseorder).addQuery("vendorID", vendorID).addQuery('modal', 'modal').toString();
	showajaxloading();
	vi_purchaseorder(vendorID, function() {
		$(loadinto).loadin(href, function() {
			hideajaxloading(); console.log(href);
			$(modal).find('.modal-body').addClass('modal-results');
			$(modal).resizemodal('lg').modal();
		});
	});
}

function contact() {
	var vendorID = $(vendlookupform + " .vendorID").val();
	var modal = config.modals.ajax;
	var loadinto =  modal+" .modal-content";
	var href = URI(config.urls.vendor.load.vi_contact).addQuery("vendorID", vendorID).addQuery('modal', 'modal').toString();
	showajaxloading();
	vi_contact(vendorID, function() {
		$(loadinto).loadin(href, function() {
			hideajaxloading(); console.log(href);
			$(modal).find('.modal-body').addClass('modal-results');
			$(modal).resizemodal('lg').modal();
		});
	});
}

function notes() {
	var vendorID = $(vendlookupform + " .vendorID").val();
	var modal = config.modals.ajax;
	var loadinto =  modal+" .modal-content";
	var href = URI(config.urls.vendor.load.vi_notes).addQuery("vendorID", vendorID).addQuery('modal', 'modal').toString();
	showajaxloading();
	vi_notes(vendorID, function() {
		$(loadinto).loadin(href, function() {
			hideajaxloading(); console.log(href);
			$(modal).find('.modal-body').addClass('modal-results');
			$(modal).resizemodal('lg').modal();
		});
	});
}

function costing() {
	var vendorID = $(vendlookupform + " .vendorID").val();
	var href = URI(config.urls.vendor.load.vi_costingform).addQuery("vendorID", vendorID).addQuery('modal', 'modal').toString();
	var modal = config.modals.ajax;
	var loadinto =  modal+" .modal-content";
	showajaxloading();
	$(loadinto).loadin(href, function() {
		hideajaxloading(); console.log(href);
		$(modal).find('.modal-body').addClass('modal-results');
		$(modal).resizemodal('lg').modal();
	});
}

function choosevicostingitem(itemID) {
	var vendorID = $(vendlookupform + " .vendorID").val();
	var modal = config.modals.ajax;
	var loadinto =  modal+" .modal-content";
	var href = URI(config.urls.vendor.load.vi_costing).addQuery("vendorID", vendorID).addQuery("itemID", itemID).addQuery('modal', 'modal').toString();
	vi_costing(vendorID, itemID, function() {
		$(loadinto).loadin(href, function() {
			hideajaxloading(); console.log(href);
			$(modal).find('.modal-body').addClass('modal-results');
			$(modal).resizemodal('lg').modal();
		});
	});
}

function unreleased() {
	var vendorID = $(vendlookupform + " .vendorID").val();
	var modal = config.modals.ajax;
	var loadinto =  modal+" .modal-content";
	var href = URI(config.urls.vendor.load.vi_unreleased).addQuery("vendorID", vendorID).addQuery('modal', 'modal').toString();
	showajaxloading();
	vi_unreleased(vendorID, function() {
		$(loadinto).loadin(href, function() {
			hideajaxloading(); console.log(href);
			$(modal).find('.modal-body').addClass('modal-results');
			$(modal).resizemodal('lg').modal();
		});
	});
}

function uninvoiced() {
	var vendorID = $(vendlookupform + " .vendorID").val();
	var modal = config.modals.ajax;
	var loadinto =  modal+" .modal-content";
	var href = URI(config.urls.vendor.load.vi_uninvoiced).addQuery("vendorID", vendorID).addQuery('modal', 'modal').toString();
	showajaxloading();
	vi_uninvoiced(vendorID, function() {
		$(loadinto).loadin(href, function() {
			hideajaxloading(); console.log(href);
			$(modal).find('.modal-body').addClass('modal-results');
			$(modal).resizemodal('xl').modal();
		});
	});
}

function monthsummary() {
	var vendorID = $(vendlookupform + " .vendorID").val();
	var modal = config.modals.ajax;
	var loadinto =  modal+" .modal-content";
	var href = URI(config.urls.vendor.load.vi_24monthsummary).addQuery("vendorID", vendorID).addQuery('modal', 'modal').toString();
	showajaxloading();
	vi_24monthsummary(vendorID, function() {
		$(loadinto).loadin(href, function() {
			hideajaxloading(); console.log(href);
			$(modal).find('.modal-body').addClass('modal-results');
			$(modal).resizemodal('xl').modal();
		});
	});
}

function docview() {
	var vendorID = $(vendlookupform + " .vendorID").val();
	var modal = config.modals.ajax;
	var loadinto =  modal+" .modal-content";
	var href = URI(config.urls.vendor.load.vi_docview).addQuery("vendorID", vendorID).addQuery('modal', 'modal').toString();
	showajaxloading();
	vi_docview(vendorID, function() {
		$(loadinto).loadin(href, function() {
			hideajaxloading(); console.log(href);
			$(modal).find('.modal-body').addClass('modal-results');
			$(modal).resizemodal('lg').modal();
		});
	});
}
