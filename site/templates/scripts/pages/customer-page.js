$(function() {
	$('#contacts-div').on('shown.bs.collapse', function () {
		if ($(this).data('tableloaded') === "no") {
			$(this).data('tableloaded', "yes");
			var table = $('#contacts-table').DataTable({
				"columnDefs": [
					{ "targets": [ 5 ], "visible": false, "bRegex": true, "bSmart": false },
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
					table.columns( 5 ).search("^" + 'CC' + "$", true, false, true).draw();
				} else {
					table.columns( 5 ).search('').draw();
				}
			});
			if ($(this).data('shipid') !== '') {
				$('#limit-shiptos').bootstrapToggle('on');
			}
		}
	});
});




function refreshshipto(shipID, custID) {
	var href = new URI();
	href.segment(-1, ""); // GETS RID OF LAST SLASH
	var lastsegment = href.segment(-1);
	
	if (lastsegment.indexOf('shipto') !== -1) {
		href.segment(-1, "");
	} 
	
	if (shipID.trim() != '') {
		href.segment('shipto-'+shipID);
	} 
	href.segment('');
	var location = href.toString();
	window.location.href = location;
}
