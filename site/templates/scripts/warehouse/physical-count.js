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
			update_total_count();
			var valid_form = new SwalError(false, '', '');
			var valid_bin = validate_binID();
			
			if (valid_bin.error) {
				valid_form = valid_bin;
			}
			
			if (valid_form.error) {
				swal({
					type: 'error',
					title: valid_form.title,
					text: valid_form.msg
				});
			} else {
				form.submit();
			}
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
		return new SwalError(error, title, msg);
	}
	
/////////////////////////////////////
// 2. Select Item / Change Bin
////////////////////////////////////
	/**
	 * Validate Bin when we are selecting the item
	 */
	$("#physical-count-item-form").validate({
		submitHandler : function(form) {
			update_total_count();
			var valid_form = new SwalError(false, '', '');
			var valid_bin = validate_binID();
			
			if (valid_bin.error) {
				valid_form = valid_bin;
			}
			
			if (valid_form.error) {
				swal({
					type: 'error',
					title: valid_form.title,
					text: valid_form.msg
				});
			} else {
				form.submit();
			}
		}
	});
	
	/**
	 * If the warehouse Bins are listed then, provide functionality to move between next / previous bins
	 */
	$("body").on("click", ".next-bin", function(e) {
		e.preventDefault();
		add_binindex(1);
	});
	
	$("body").on("click", ".prev-bin", function(e) {
		e.preventDefault();
		subtract_binindex(1);
	});
	
	/**
	 * Sets the Bin ID to the next Bin ID available in the bin list
	 */
	function add_binindex(add) {
		var currentbin = input_bin.val();
		var bins = Object.keys(whsesession.whse.bins.bins);
		var currentindex = bins.indexOf(currentbin);
		input_bin.val(bins[currentindex + add]);
	} 
	
	/**
	 * Sets the Bin ID to the previous Bin ID available in the bin list
	 */
	function subtract_binindex(subtract) {
		var currentbin = input_bin.val();
		var bins = Object.keys(whsesession.whse.bins.bins);
		var currentindex = bins.indexOf(currentbin);
		var difference = currentindex - subtract;
		
		if (difference < 0) {
			difference = 0;
		} 
		input_bin.val(bins[difference]);
	}
	
	
/////////////////////////////////////
// 3. Physical Count Form 
////////////////////////////////////
	/**
	 * If one of the Unit of Measurement Qty Inputs were change we update the total quantity for that pack 
	 * and also update the total quantity for all the pack types
	 * Example a Pack that contains 3, if the qty input is 2, then the total Qty for that pack is 6
	 */
	$("body").on("change", ".uom-value", function(e) {
		e.preventDefault();
		var input = $(this);
		var uomrow = input.closest('.uom-row');
		var unitqty = parseInt(uomrow.find('[data-unitqty]').data('unitqty'));
		var totalqty = unitqty * parseInt(input.val());
		uomrow.find('.uom-total-qty').text(totalqty);
		update_total_count();
	});
	
	/**
	 * When focusing on the qty input field remove value so the user can overwrite it because it goes to the left
	 * of the current input because the field is right-justified
	 */
	$("body").on("focus", ".uom-value", function(e) {
		e.preventDefault();
		var input = $(this);
		input.val('');
	});
	
	/**
	 * When leaving focus we want to recalculate based on the total qty, so if we have a total qty of 6
	 * the pack qty is 3 then we do 6 / 3 equals a input qty of 2
	 */
	$("body").on("focusout", ".uom-value", function(e) {
		e.preventDefault();
		var input = $(this);
		var uomrow = input.closest('.uom-row');
		var unitqty = parseInt(uomrow.find('[data-unitqty]').data('unitqty'));
		var totalqty = parseInt(uomrow.find('.uom-total-qty').text());
		var inputqty = totalqty / unitqty;
		
		if (input.val() == '') {
			input.val(inputqty);
		}
	});
	
	/**
	 * Goes through all the inputs and Updates the total Qtys for all the items
	 */
	function update_total_count() {
		var totalqty = 0;
		var td_total = form_physicalcount.find('.physical-count-total');
		
		form_physicalcount.find('.uom-row').each(function() {
			var row = $(this);
			var row_totalqty = parseInt(row.find('.uom-total-qty').text());
			totalqty += row_totalqty;
		});
		td_total.text(totalqty);
	}
});
