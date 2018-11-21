/* =============================================================
   II ITEM FUNCTIONS
 ============================================================ */
	function ii_pricing(itemID, custID, shipID, callback) {
		var url = config.urls.products.redir.ii_pricing+"&itemID="+urlencode(itemID)+"&custID="+urlencode(custID)+"&shipID="+urlencode(shipID);
		$.get(url, function() { callback();});
	}

	function ii_select(itemID, custID, callback) {
		var url = config.urls.products.redir.ii_select+"&itemID="+urlencode(itemID)+"&custID="+urlencode(custID);
		$.get(url, function() { callback(); });
	}

	function ii_costing(itemID, callback) {
		var url = config.urls.products.redir.ii_costing+"&itemID="+urlencode(itemID);
		$.get(url, function() { callback();});
	}

	function ii_purchaseorders(itemID, callback) {
		var url = config.urls.products.redir.ii_purchaseorders+"&itemID="+urlencode(itemID);
		$.get(url, function() { callback(); });
	}

	function ii_quotes(itemID, callback) {
		var url = config.urls.products.redir.ii_quotes+"&itemID="+urlencode(itemID);
		$.get(url, function() { callback();});
	}

	function ii_purchasehistory(itemID, callback) {
		var url = config.urls.products.redir.ii_purchasehistory+"&itemID="+urlencode(itemID);
		$.get(url, function() { callback(); });
	}

	function ii_whereused(itemID, callback) {
		var url = config.urls.products.redir.ii_whereused+"&itemID="+urlencode(itemID);
		$.get(url, function() { callback();});
	}

	function ii_bom(itemID, qty, bomtype, callback) {
		var url = config.urls.products.redir.ii_bom+"&itemID="+urlencode(itemID)+"&qty="+urlencode(qty)+"&bom="+bomtype;
		$.get(url, function() { callback();});
	}

	function ii_general(itemID, callback) {
		var url = config.urls.products.redir.ii_general+"&itemID="+urlencode(itemID);
		$.get(url, function() { callback();});
	}

	function ii_usage(itemID, callback) {
		var url = config.urls.products.redir.ii_usage+"&itemID="+urlencode(itemID);
		$.get(url, function() { callback();});
	}

	function ii_misc(itemID, callback) {
		var url = config.urls.products.redir.ii_misc+"&itemID="+urlencode(itemID);
		$.get(url, function() { callback();});
	}

	function ii_notes(itemID, callback) {
		var url = config.urls.products.redir.ii_notes+"&itemID="+urlencode(itemID);
		$.get(url, function() { callback();});
	}

	function ii_requirements(itemID, screentype, whse, callback) {
		var url = config.urls.products.redir.ii_requirements+"&itemID="+urlencode(itemID)+"&screentype="+urlencode(screentype)+"&whse="+urlencode(whse);
		$.get(url, function() {	callback(); });
	}

	function ii_lotserial(itemID, callback) {
		var url = config.urls.products.redir.ii_lotserial+"&itemID="+urlencode(itemID);
		$.get(url, function() { callback();	});
	}

	function ii_salesorder(itemID, callback) {
		var url = config.urls.products.redir.ii_salesorder+"&itemID="+urlencode(itemID);
		$.get(url, function() { callback(); });
	}

	function ii_stock(itemID, callback) {
		var url = config.urls.products.redir.ii_stock+"&itemID="+urlencode(itemID);
		$.get(url, function() { callback(); });
	}

	function ii_substitutes(itemID, callback) {
		var url = config.urls.products.redir.ii_substitutes+"&itemID="+urlencode(itemID);
		$.get(url, function() {	callback(); });
	}

	function ii_documents(itemID, callback) {
		var url = config.urls.products.redir.ii_documents+"&itemID="+urlencode(itemID);
		$.get(url, function() {	callback(); });
	}

	function ii_getorderdocuments(itemID, ordn, type, callback) {
		var url = config.urls.products.redir.ii_order_documents+"&itemID="+urlencode(itemID)+"&ordn="+ordn+"&type="+urlencode(type);
		console.log(url);
		$.get(url, function() {	callback(); });
	}
	
	function ii_getquotedocuments(itemID, qnbr, type, callback) {
		var url = config.urls.products.redir.ii_quote_documents+"&itemID="+urlencode(itemID)+"&ordn="+qnbr+"&type="+urlencode(type);
		console.log(url);
		$.get(url, function() {	callback(); });
	}
