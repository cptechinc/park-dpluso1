$(function() {
	// BINR FORM INPUTS
	var form_movecontents = $('.move-contents-form');
	var input_frombin = form_movecontents.find('input[name=from-bin]');
	var input_tobin = form_movecontents.find('input[name=to-bin]');
	
	form_movecontents.validate({
		submitHandler : function(form) {
			var valid_frombin = validate_frombin();
			var valid_tobin = validate_tobin();
			var valid_form = new SwalError(false, '', '', false);
			
			if (valid_frombin.error) {
				valid_form = valid_frombin;
			} else if (valid_tobin.error) {
				valid_form = valid_tobin;
			}
			
			if (valid_form.error) {
				swal({
					type: 'error',
					title: valid_form.title,
					text: valid_form.msg,
					html: valid_form.html
				});
			} else {
				form.submit();
			}
		}
	});
	/**
	 * IF WAREHOUSE HAS A BIN LIST THEN SHOW A DROPDOWN LIST OF THE BIN LIST 
	 * IF IT'S A BIN RANGE THEN WE SHOW THEM WHAT THE BIN RANGE IS
	 */
	$("body").on("click", ".show-possible-bins", function(e) {
		e.preventDefault();
		var button = $(this);
		var formgroup = button.closest('.form-group');
		var bin_input = formgroup.find('input');
		
		if (whsesession.whse.bins.arranged == 'list') {
			var bins = {};
			var binid = '';
			var spacesneeded = 0;
			var spaces = '';
			
			for (var key in whsesession.whse.bins.bins) {
				binid = key;
				spacesneeded = (8 - binid.length);
				spaces = '';
				for (var i = 0; i <= spacesneeded; i++) {
					spaces += '&nbsp;';
				}
				bins[key] = binid + spaces + whsesession.whse.bins.bins[key];
			}
			swal({
				type: 'question',
				title: 'Choose a bin',
				input: 'select',
				inputClass: 'form-control',
				inputOptions: bins,
			}).then(function (input) {
				if (input) {
					bin_input.val(input);
					swal.close();
				} 
			}).catch(swal.noop);
		} else {
			var table = create_binrangetable();
			
			swal({
				type: 'info',
				title: 'Bin Ranges',
				html: table
			}).catch(swal.noop);
		}
	});
	
	
	function validate_frombin() {
		var error = false;
		var title = '';
		var msg = '';
		var html = false;
		var lowercase_frombin = input_frombin.val();
		input_frombin.val(lowercase_frombin.toUpperCase());
		
		if (input_frombin.val() == '') {
			error = true;
			title = 'Error';
			msg = 'Please Fill in the From Bin';
		} else if (whsesession.whse.bins.arranged == 'list' && whsesession.whse.bins.bins[input_frombin.val()] === undefined) {
			error = true;
			title = 'Invalid Bin ID';
			msg = 'Please Choose a valid From bin';
		} else if (whsesession.whse.bins.arranged == 'range') {
			error = true;
			title = 'Invalid Bin ID';
			
			whsesession.whse.bins.bins.forEach(function(bin) {
				if (input_frombin.val() >= bin.from && input_frombin.val() <= bin.through) {
					error = false;
				}
			});
			
			if (error) {
				title = 'Invalid From Bin ID';
				msg = 'Your From Bin ID must between these ranges';
				html = "<h4>Valid Bin Ranges<h4>" + create_binrangetable();
			}
			
		}
		return new SwalError(error, title, msg, html);
	}

	function validate_tobin() {
		var error = false;
		var title = '';
		var msg = '';
		var html = false;
		var lowercase_tobin = input_tobin.val();
		input_tobin.val(lowercase_tobin.toUpperCase());
		
		if (input_tobin.val() == '') {
			error = true;
			title = 'Error';
			msg = 'Please Fill in the To Bin';
		} else if (whsesession.whse.bins.arranged == 'list' && whsesession.whse.bins.bins[input_tobin.val()] === undefined) {
			error = true;
			title = 'Invalid Bin ID';
			msg = 'Please Choose a valid To bin';
		} else if (whsesession.whse.bins.arranged == 'range') {
			error = true;
			
			whsesession.whse.bins.bins.forEach(function(bin) {
				if (input_tobin.val() >= bin.from && input_tobin.val() <= bin.through) {
					error = false;
				}
			});
			
			if (error) {
				title = 'Invalid To Bin ID';
				msg = 'Your To Bin ID must between these ranges';
				html = "<h4>Valid Bin Ranges<h4>" + create_binrangetable();
			}
		}
		return new SwalError(error, title, msg, html);
	}
	
	function create_binrangetable() {
		var bootstrap = new JsContento();
		var table = bootstrap.open('table', 'class=table table-striped table-condensed');
			whsesession.whse.bins.bins.forEach(function(bin) {
				table += bootstrap.open('tr', '');
					table += bootstrap.openandclose('td', '', bin.from);
					table += bootstrap.openandclose('td', '', bin.through);
				table += bootstrap.close('tr');
			});
		table += bootstrap.close('table');
		return table;
	}
});
