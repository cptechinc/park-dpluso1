$(function() {
	// BINR FORM INPUTS
	var input_bin = $('input[name=binID]');
	var form_physicalcount = $('.physical-count-form');
	
	/**
	 * The Order of Functions based on Order of Events
	 * 1. Select Bin / Validate BIN
	 * 2. Select Item
	 * 3. Physical Count 
	 */
	
/////////////////////////////////////
// 1. Select Bin
////////////////////////////////////
	/**
	 * Validate Bin form
	 */
	$(".select-bin-form").validate({
		submitHandler : function(form) {
			var valid_form = new SwalError(false, '', '', false);
			var valid_bin = validate_binID();
			
			if (valid_bin.error) {
				valid_form = valid_bin;
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
	 * // NOTE THIS IS USED IN ALL THE STEPS
	 */
	$("body").on("click", ".show-possible-bins", function(e) {
		e.preventDefault();
		var button = $(this);
		
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
					input_bin.val(input);
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
	
	/**
	 * Validates Bin ID and returns with an Swal Error object for details
	 * // NOTE THIS IS USED IN STEPS 1, 2
	 * @return SwalError Error 
	 */
	function validate_binID() {
		var error = false;
		var title = '';
		var msg = '';
		var html = false;
		
		var bin_lower = input_bin.val();
		input_bin.val(bin_lower.toUpperCase());
		
		if (input_bin.val() == '') {
			error = true;
			title = 'Error';
			msg = 'Please Fill in the Bin ID';
		} else if (whsesession.whse.bins.arranged == 'list' && whsesession.whse.bins.bins[input_bin.val()] === undefined) {
			error = true;
			title = 'Invalid Bin ID';
			msg = 'Please Choose a valid bin ID';
		} else if (whsesession.whse.bins.arranged == 'range') {
			error = true;
			title = 'Invalid Bin ID';
			msg = 'Please Enter a valid bin ID';
			html = "<h4>Valid Bin Ranges<h4>"  + create_binrangetable();
			
			whsesession.whse.bins.bins.forEach(function(bin) {
				if (input_bin.val() >= bin.from && input_bin.val() <= bin.through) {
					error = false;
				}
			});
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
