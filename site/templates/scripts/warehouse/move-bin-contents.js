$(function() {
	// BINR FORM INPUTS
	var form_movecontents = $('.move-contents-form');
	var input_frombin = form_movecontents.find('input[name=from-bin]');
	var input_tobin = form_movecontents.find('input[name=to-bin]');
	
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
			var msg = 'Warehouse bin range is between ' + whsesession.whse.bins.bins.from + ' and ' + whsesession.whse.bins.bins.through;
			swal({
				type: 'info',
				title: 'Bin Range',
				text: msg
			}).catch(swal.noop);
		}
	});
	
	
	function validate_frombin() {
		var error = false;
		var title = '';
		var msg = '';
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
		} else if (whsesession.whse.bins.arranged == 'list' && input_frombin.val() < whsesession.whse.bins.bins.from || input_frombin.val() > whsesession.whse.bins.bins.through) {
			error = true;
			title = 'Invalid Bin ID';
			msg = 'From Bin must be between ' + whsesession.whse.bins.bins.from + ' and ' + whsesession.whse.bins.bins.through;
		}
		return new SwalError(error, title, msg);
	}

	function validate_tobin() {
		var error = false;
		var title = '';
		var msg = '';
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
		} else if (whsesession.whse.bins.arranged == 'list' && input_tobin.val() < whsesession.whse.bins.bins.from || input_tobin.val() > whsesession.whse.bins.bins.through) {
			error = true;
			title = 'Invalid Bin ID';
			msg = 'To Bin must be between ' + whsesession.whse.bins.bins.from + ' and ' + whsesession.whse.bins.bins.through;
		}
		return new SwalError(error, title, msg);
	}
});
