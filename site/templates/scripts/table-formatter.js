var formatterform = '.screen-formatter-form';
$(function() {
	$(formatterform).submit(function(e) {
		e.preventDefault();
		var valid = validate_tableformatter();
		if (valid) {
			var form = $(this);
			form.find('[name=action]').val('save-formatter');
			form.postform({formdata: false, jsoncallback: true, html: true}, function(json) {
				$.notify({
					icon: json.response.icon,
					message: json.response.message,
				},{
					type: json.response.notifytype
				});
			});	
		}
	});
});

function validate_tableformatter() {
	var form = $(formatterform);
	var valid = true;
	var ignore = "0-0";
	var structure = [];
	var errors = [];
	form.find('.tab-pane').each(function() {
		var tab = $(this);
		structure[tab.attr('id')] = [];
		errors[tab.attr('id')] = [];
		
		tab.find('tbody tr').each(function() {
			var row = $(this);
			var line = row.find('.'+tab.attr('id')+'-line').val();
			var column = row.find('.column').val();
			var length = row.find('.column-length').val();
			var label = row.find('.col-label').val();
			var key = line + '-' + column;
			
			if (key !== ignore) {
				if (structure[tab.attr('id')].includes(key)) {
					row.addClass('has-error');
					errors[tab.attr('id')].push(label);
				} else if (parseInt(length) == 0) { 
					errors[tab.attr('id')].push(label);
				} else {
					structure[tab.attr('id')].push(key);
				}
			}
		});
	});
	
	var message = "The following columns have errors : Check Duplicate Columns  <br>";
	
	for (var tabid in errors){
	    if (errors.hasOwnProperty(tabid)) {
			if (errors[tabid].length > 0) {
				valid = false;
				message += "Section " + tabid + ": "; 
				for (var column in errors[tabid]) {
					message += errors[tabid][column] + ",";
				}
				message = message.substring(0, message.length - 1);
				message += "<br>";
			}
			
	    }
	}
	
	if (!valid) {
		$('.formatter-response .message').createalertpanel(message, "<span class='glyphicon glyphicon-warning-sign'></span> Error! ", "danger");
	}
	
	return valid;
}

function preview_tableformatter() {
	var form = $(formatterform);
	form.find('[name=action]').val('preview');
	
	form.postform({jsoncallback: true, html: true}, function(html) {
		var title = form.find('.panel-title').text();
		$(config.modals.ajax).find('.modal-body').addClass('modal-results').html(html);
		$(config.modals.ajax).find('.modal-title').text('Previewing ' + title + ' Formatter');
		$(config.modals.ajax).resizemodal('xl').modal();
	});
}

function save_tableformatterfor(user) {
	var form = $(formatterform);
	var userID = form.find('[name=user]').val();
	form.find('[name=user]').val(user);
	form.find('[name=action]').val('save-formatter');
	form.postform({formdata: false, jsoncallback: true, html: true}, function(json) {
		$.notify({
			icon: json.response.icon,
			message: json.response.message,
		},{
			type: json.response.notifytype,
			onClose: function() {
				form.find('[name=user]').val(userID);
			}
		});
	});	
}
