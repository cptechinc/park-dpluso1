var cardfields = { number: '#cardnumber', status: '#credit-status', image: '.credit-img', cardtype: '#cctype' };
var expirefields = {date: '#expire', status: '#expire-status'};
var cvvfields = {number: '#cvv'};

$(cardfields.number).payment('formatCardNumber'); $(cvvfields.number).payment('formatCardCVC'); $(expirefields.date).payment('formatCardExpiry');

$(function() {
	$(".page").on("change", "#orderhead-form .email", function(e) {
		var validemail = validate_email($(this).val());
		if (validemail) {
			$(this).closest('tr').removeClass("has-error").addClass("has-success");
		} else {
			$(this).closest('tr').removeClass("has-success").addClass("has-error");
		}
	});

	$(".page").on("change", "#orderhead-form .shipto-select", function(e) {
		e.preventDefault();
		var custID = $(this).data('custid');
		var shipID = $(this).val();
		var jsonurl = URI(config.urls.json.getshipto).addQuery("custID", custID).addQuery("shipID", shipID).toString();
		$.get(jsonurl, function(json) {
			var shipto = json.response.shipto;
			$('.shipto-select').val(shipID); $('.shipto-name').val(shipto.name); $('.shipto-address').val(shipto.addr1);
			$('.shipto-address2').val(shipto.addr2);
			$('.shipto-city').val(shipto.city); $('.shipto-state').val(shipto.state); $('.shipto-zip').val(shipto.zip);
		});
	});

	$(".page").on("submit", "#orderhead-form", function(e) {
		e.preventDefault();
		var formid = '#'+$(this).attr('id');
		var ordn = $(this).data('ordn');
		if ($(this).formiscomplete('tr')) {
			$(formid).postform({formdata: false, jsoncallback: false}, function() { //{formdata: data/false, jsoncallback: true/false}
				$.notify({
					icon: "glyphicon glyphicon-floppy-disk",
					message: "Your changes have been submitted",
				},{
					type: "info",
					onClose: function() {
						get_orderheadresults(ordn, formid, function() {
							$('#salesdetail-link').click();
						});
					}
				});
			});
		}
	});

	$('body').on('click', '.save-unlock-order', function(e) {
		e.preventDefault();
		var href = $(this).attr('href');
		var formid = $(this).data('form');
		var ordn = $('#ordn').val();
		if ($(formid).formiscomplete('tr')) {
			$(formid).postform({formdata: $(formid).serializeform({ exitorder: 'true'}), jsoncallback: false}, function() { //{formdata: data/false, jsoncallback: true/false}
				$.notify({
					icon: "glyphicon glyphicon-floppy-disk",
					message: "Your orderhead changes have been submitted",
				},{
					type: "info",
					onClose: function() {
						console.log($(formid).serializeform({ exitorder: 'true'}));
						get_orderheadresults(ordn, formid, function() {
							generateurl(function(url) {
								console.log(url);
								window.location.href = href;
							});
						});
					}
				});
			});
		} else {
			$('#orderhead-link').click();
		}
	});
	
	$(".page").on("click", ".load-sales-docs, .load-sales-tracking", function(e) {
		e.preventDefault();
		var loadinto = $(this).data('loadinto');
		var focuson = $(this).data('focus');
		var geturl = URI($(this).attr('href')).addQuery('page', 'edit').toString();
		var clickon = $(this).data('click');
		
		$.get(geturl, function() {
			generateurl(function(url) {
				loadin(url, loadinto, function() {
					$(clickon).click();
					if (focuson.length > 0) { 
						$('html, body').animate({scrollTop: $(focuson).offset().top - 60}, 1000); 
					}
				});
			});
		});
	});
	
	$(expirefields.date).change(function() {
		var datearray = $(expirefields.date).val().split(' / ');
		var month = datearray[0]; var year = datearray[1];
		var valid = $.payment.validateCardExpiry(month, year);
		if (!valid) {
			$(expirefields.date).closest('tr').removeClass('has-success').addClass('has-error');
			$(expirefields.status).removeClass("has-success").addClass("has-error");
			$(expirefields.status).text('Expiration date is invalid');
		} else {
			$(expirefields.status).removeClass("has-error").addClass("has-success");
			$(expirefields.status).text('');
			$(expirefields.date).closest('tr').removeClass("has-error").addClass("has-success");
		}
	});
	
	$(cardfields.number).validateCreditCard(function(result) {
		if (result.card_type !== null && $(cardfields.number).val().length > 3) {
			if ($(cardfields.number).val().length >= 3 && result.length_valid === false) {
				$(cardfields.number).closest('tr').removeClass("has-success").addClass("has-error");
				$(cardfields.status).removeClass("has-success").addClass("has-error");
				$(cardfields.status).text('Credit Card Number must be 16 digits long');
				$(cardfields.image).html('');
			}  else if ($(cardfields.number).val().length >= 10 && result.luhn_valid === false) {
				$(cardfields.number).closest('tr').removeClass("has-success").addClass("has-error");
				$(cardfields.status).text('Please check your Credit Card Number');
				$(cardfields.image).html('');
			}  else if ($(cardfields.number).val().length === 0) {
				$(cardfields.status).removeClass("has-success").addClass("has-error");
				$(cardfields.status).text('Credit Card Number must be 16 digits long');
				$(cardfields.image).html('');
			}  else {
				$(cardfields.number).closest('tr').removeClass("has-error").addClass("has-success");
				$(cardfields.status).removeClass("has-error").addClass("has-success");
				$(cardfields.status).text('Card recognized as ' + result.card_type.display);
				$(cardfields.cardtype).val(result.card_type.code);
				$(cardfields.image).html('<img src="'+config.paths.assets.images+'credit/'+result.card_type.code+'-logo.png" height="33">');
			}
		} else if (result.card_type === null && $(cardfields.number).val().length > 6 ) {
			$(cardfields.status).removeClass("has-success").addClass("has-error");
			$(cardfields.status).text('Card Type Not recognized, please try again');
			$(cardfields.image).html('');
		}
	}, { 
		accept: ['mastercard', 'visa' , 'discover', 'amex'] 
	});
});

/* =============================================================
	FUNCTIONS
============================================================ */
	

	function show_phone(intlYN) {
		if (intlYN == 'Y') {
			$('.international').removeClass('hidden');
			$('.domestic').addClass('hidden');
		} else {
			$('.domestic').removeClass('hidden');
			$('.international').addClass('hidden');
		}
	}

	window.addDashes = function addDashes(f) {
		var r = /(\D+)/g; var npa = ''; var nxx = ''; var last4 = '';
		f.value = f.value.replace(r, '');
		npa = f.value.substr(0, 3);
		nxx = f.value.substr(3, 3);
		last4 = f.value.substr(6, 4);
		f.value = npa + '-' + nxx + '-' + last4;
	};

	function show_credit(showcreditval) {
		if (showcreditval === 'cc') {
			$('#credit').removeClass('hidden');
		} else {
			$('#credit').addClass('hidden');
		}
	}

	function get_orderheadresults(ordn, form, callback) {
		$.getJSON(config.urls.json.getorderhead+"?ordn="+ordn, function( json ) {
			if (json.response.order.error === 'Y') {
				$(form + ' .response').createalertpanel(json.response.order.errormsg, "<i span='glyphicon glyphicon-floppy-remove'> </i> Error! ", "danger");
				$('html, body').animate({scrollTop: $(form + ' .response').offset().top - 120}, 1000);
			} else {
				$.notify({
					icon: "glyphicon glyphicon-floppy-saved",
					message: "Your changes have been saved" ,
				},{
					type: "success",
					onShow: function() {
						callback();
					}
				});
			}
		});
	}
