$(function() {
	$('#quotehead-form').submit(function(e) {
		e.preventDefault();
		var formid = '#'+$(this).attr('id');
		var qnbr = $(this).find('#qnbr').val();
		if ($(this).formiscomplete('tr')) {
			$(formid).postform({formdata: false, jsoncallback: false}, function() { //{formdata: data/false, jsoncallback: true/false}
				$.notify({
					icon: "glyphicon glyphicon-floppy-disk",
					message: "Your changes have been submitted",
				},{
					type: "info",
					onClose: function() {
						getquoteheadresults(qnbr, formid, function() {

						});
					}
				});
			});
		}
	});

	$(".page").on("change", "#quotehead-form .shipto-select", function(e) {
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

	$(".page").on("click", "#quotehead-form .save-unlock-quotehead", function(e) {
		e.preventDefault();
		var formid = $(this).data('form');
		var form = $(formid);
		var qnbr = form.find('#qnbr').val();
		if (form.formiscomplete('tr')) {
			$(formid).postform({formdata: $(formid).serializeform({ exitquote: 'true'}), jsoncallback: false}, function() { //{formdata: data/false, jsoncallback: true/false}
				$.notify({
					icon: "glyphicon glyphicon-floppy-disk",
					message: "Your quotehead changes have been submitted",
				},{
					type: "info",
					onClose: function() {
						getquoteheadresults(qnbr, formid, function() {
							generateurl(function(url) {
								window.location.href = url;
							});
						});
					}
				});
			});
		}

	});
});



function getquoteheadresults(qnbr, form, callback) {
	console.log(config.urls.json.getquotehead+"?qnbr="+qnbr);
	$.getJSON(config.urls.json.getquotehead+"?qnbr="+qnbr, function( json ) {
		if (json.response.quote.error == 'Y') {
			$(form + ' .response').createalertpanel(json.response.quote.errormsg, "<i span='glyphicon glyphicon-floppy-remove'> </i> Error! ", "danger");
			$('html, body').animate({scrollTop: $(form + ' .response').offset().top - 120}, 1000);
		} else {
			$.notify({
				icon: "glyphicon glyphicon-floppy-saved",
				message: "Your changes have been saved" ,
			},{
				type: "success",
				onClose: function() {
					callback();
				}
			});
		}
	});
}
