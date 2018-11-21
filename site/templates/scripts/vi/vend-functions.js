function vi_payment(vendorID, callback) {
    var url = config.urls.vendor.redir.vi_payment+"&vendorID="+urlencode(vendorID);
    $.get(url, function() { callback();});
}

function vi_openinv(vendorID, callback) {
    var url = config.urls.vendor.redir.vi_openinv+"&vendorID="+urlencode(vendorID);
    $.get(url, function() { callback();});
}

function vi_shipfrom(vendorID, shipfromID, callback) {
    var url = config.urls.vendor.redir.vi_shipfrom+"&vendorID="+urlencode(vendorID)+"&shipfromID="+urlencode(shipfromID);
    $.get(url, function() { callback();});
}

function vi_purchasehist(vendorID, callback) {
    var url = config.urls.vendor.redir.vi_purchasehist+"&vendorID="+urlencode(vendorID);
    $.get(url, function() { callback();});
}

function vi_purchaseorder(vendorID, callback) {
    var url = config.urls.vendor.redir.vi_purchaseorder+"&vendorID="+urlencode(vendorID);
    $.get(url, function() { callback();});
}

function vi_contact(vendorID, callback) {
    var url = config.urls.vendor.redir.vi_contact+"&vendorID="+urlencode(vendorID);
    $.get(url, function() { callback();});
}

function vi_notes(vendorID, callback) {
    var url = config.urls.vendor.redir.vi_notes+"&vendorID="+urlencode(vendorID);
    $.get(url, function() { callback();});
}

function vi_costing(vendorID, itemID, callback) {
    var url = config.urls.vendor.redir.vi_costing+"&vendorID="+urlencode(vendorID)+"&itemID="+urlencode(itemID);
    $.get(url, function() { callback();});
}

function vi_unreleased(vendorID, callback) {
    var url = config.urls.vendor.redir.vi_unreleased+"&vendorID="+urlencode(vendorID);
    $.get(url, function() { callback();});
}

function vi_uninvoiced(vendorID, callback) {
    var url = config.urls.vendor.redir.vi_uninvoiced+"&vendorID="+urlencode(vendorID);
    $.get(url, function() { callback();});
}

function vi_24monthsummary(vendorID, callback) {
    var url = config.urls.vendor.redir.vi_24monthsummary+"&vendorID="+urlencode(vendorID);
    $.get(url, function() { callback();});
}

function vi_docview(vendorID, callback) {
    var url = config.urls.vendor.redir.vi_docview+"&vendorID="+urlencode(vendorID);
    $.get(url, function() { callback();});
}
