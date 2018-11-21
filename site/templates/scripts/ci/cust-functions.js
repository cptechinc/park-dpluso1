/* =============================================================
   CI ITEM FUNCTIONS
 ============================================================ */
	function ci_shiptos(custID, callback) {
		var url = config.urls.customer.redir.ci_shiptos+"&custID="+urlencode(custID);
		$.get(url, function() { callback();});
	}

	function ci_shiptoinfo(custID, shiptoid, callback) {
		var url = config.urls.customer.redir.ci_shiptoinfo+"&custID="+urlencode(custID)+"&shipID="+urlencode(shiptoid);
		$.get(url, function() { callback();});
	}

	function ci_pricing(custID, itemID, callback) {
		var url = config.urls.customer.redir.ci_pricing+"&custID="+urlencode(custID)+"&itemID="+urlencode(itemID);
		console.log(url);
		$.get(url, function() { callback();});
	}

	function ci_openinvoices(custID, callback) {
		var url = config.urls.customer.redir.ci_openinvoices+"&custID="+urlencode(custID);
		$.get(url, function() { callback();});
	}

	function ci_getorderdocuments(custID, ordn, type, callback) {
		var url = config.urls.customer.redir.ci_orderdocuments+"&ordn="+urlencode(ordn)+'&type='+urlencode(type);
		$.get(url, function() { callback();});
	}
	
	function ci_getquotedocuments(custID, qnbr, type, callback) {
		var url = config.urls.customer.redir.ci_quotedocuments+"&qnbr="+urlencode(qnbr)+'&type='+urlencode(type);
		$.get(url, function() { callback();});
	}

	function ci_standingorders(custID, shiptoid, callback) {
		var url = config.urls.customer.redir.ci_standingorders+"&custID="+urlencode(custID)+"&shipID="+urlencode(shiptoid);
		$.get(url, function() { callback();});
	}

	function ci_paymenthistory(custID, callback) {
		var url = config.urls.customer.redir.ci_paymenthistory+"&custID="+urlencode(custID);
		$.get(url, function() { callback();});
	}

	function ci_documents(custID, callback) {
		var url = config.urls.customer.redir.ci_documents+"&custID="+urlencode(custID);
		$.get(url, function() { callback();});
	}

	function ci_quotes(custID, callback) {
		var url = config.urls.customer.redir.ci_quotes+"&custID="+urlencode(custID);
		$.get(url, function() { callback();});
	}

	function ci_contacts(custID, shipID, callback) {
		var url = config.urls.customer.redir.ci_contacts+"&custID="+urlencode(custID)+'&shipID='+urlencode(shipID);
		$.get(url, function() { callback();});
	}

	function ci_credit(custID, callback) {
		var url = config.urls.customer.redir.ci_credit+"&custID="+urlencode(custID);
		$.get(url, function() { callback();});
	}

	function ci_salesorder(custID, shipID, callback) {
		var url = config.urls.customer.redir.ci_salesorders+"&custID="+urlencode(custID)+"&shipID="+urlencode(shipID);
		$.get(url, function() { callback();});
	}

	function ci_saleshistory(custID, shipID, startdate, callback) {
		var url = config.urls.customer.redir.ci_saleshistory+"&custID="+urlencode(custID)+"&shipID="+urlencode(shipID)+"&startdate="+urlencode(startdate);
		$.get(url, function() { callback();});
	}

	function ci_custpo(custID, shipID, custpo, callback) {
		var url = config.urls.customer.redir.ci_custpo+"&custID="+urlencode(custID)+"&shipID="+urlencode(shipID)+"&custpo="+urlencode(custpo);
		$.get(url, function() { callback();});
	}
