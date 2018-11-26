$(function() {
    $("body").on("submit", ".sales-order-entry-form", function(e) {
        e.preventDefault();
        var form = $(this);
        form.postform({}, function() {
            console.log(config.urls.warehouse.json.session);
            $.getJSON(config.urls.warehouse.json.session, function(json) {
                if (json.response.session.promptfunction.toUpperCase() == 'Y') {
                    swal({
                        title: 'Are you sure you want to use '+json.response.session.function+' for this order?',
                        text: json.response.session.status,
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonClass: 'btn btn-success',
                        cancelButtonClass: 'btn btn-danger',
                        buttonsStyling: false,
                        confirmButtonText: 'Use ' + json.response.session.function,
                        cancelButtonText: 'Exit Order'
                    }).then(function (result) {
                        if (result) {
                            generateurl(function(url) {
                                window.location.href = url;
                            });
                        } else {
                            var page = URI().toString();
                            var url = URI(config.urls.warehouse.picking.sales_order.redir.cancel_order).addQuery('page', page);
                            window.location.href = url.toString();
                        }
                    });
                } else {
                    generateurl(function(url) {
                        window.location.href = url;
                    });
                }
            });
        });
    });
    
    $("body").on("click", ".finish-item", function(e) {
        e.preventDefault();
        var button = $(this);
        
        if (pickitem.item.qty.remaining > 0) {
            swal({
                title: 'Are you sure?',
                text: "You have not met the Quantity Requirments",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                confirmButtonText: 'Yes!'
            }).then(function (result) {
                if (result) {
                    window.location.href = button.attr('href');
                }
            }).catch(swal.noop);
        } else if (pickitem.item.qty.remaining < 0) {
            swal({
                title: 'Are you sure?',
                text: "You have picked too much",
                type: 'warning',
                confirmButtonClass: 'btn btn-success',
                buttonsStyling: false,
                confirmButtonText: 'Continue'
            });
        } else if (pickitem.item.qty.expected < pickitem.item.qty.picked) { 
            swal({
                title: 'Bin Error',
                text: "You have picked more than expected bin qty",
                type: 'warning',
                confirmButtonClass: 'btn btn-success',
                buttonsStyling: false,
                confirmButtonText: 'Continue'
            });
        } else {
            window.location.href = button.attr('href');
        }
    });
    
    $("body").on("click", ".exit-order", function(e) {
        e.preventDefault();
        var button = $(this);
        
        swal({
            title: 'Are you sure?',
            text: "You are trying to leave this order",
            type: 'warning',
            showCancelButton: true,
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false,
            confirmButtonText: 'Yes!'
        }).then(function (result) {
            console.log(result);
            if (result) {
                window.location.href = button.attr('href');
            }
        }).catch(swal.noop);
    });
    
    $("body").on("click", ".change-bin", function(e) {
        e.preventDefault();
        var button = $(this);
        
        if (pickitem.item.qty.remaining > 0 && pickitem.item.qty.total_picked > 0) {
            swal({
                title: 'Are you sure?',
                text: "You are trying to leave this bin without fulfilling bin item",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                confirmButtonText: 'Yes!'
            }).then(function (result) {
                if (result) {
                    swal_changebin();
                }
            }).catch(swal.noop);
        } else {
            swal_changebin();
        }
    });
    
    $("body").on("click", ".remove-sales-order-locks", function(e) {
        e.preventDefault();
        
        swal({
			title: "Enter the Order Number you'd like to erase locks for",
			text: "Order Number",
			input: 'text',
			showCancelButton: true,
			inputValidator: function (value) {
				return new Promise(function (resolve, reject) {
					if (value) {
						resolve();
					} else {
						reject('You need to write something!');
					}
				})
			}
		}).then(function (input) {
			if (input) {
				var ordn = input;
                var pageurl = URI();
                var uri = URI(config.urls.warehouse.picking.sales_order.redir.redir);
                uri.addQuery('action', 'remove-order-locks').addQuery('ordn', ordn);
                window.location.href = uri.toString();
			}
		}).catch(swal.noop);
    });
    
    $("body").on("change", ".change-pallet", function(e) {
        e.preventDefault();
        var select = $(this);
        var form = select.parent('form');
        form.submit();
    });
});

function swal_changebin() {
    swal({
        title: "Enter the Bin you'd like to change to",
        text: "Bin ID",
        input: 'text',
        showCancelButton: true,
        inputValidator: function (value) {
            return new Promise(function (resolve, reject) {
                if (value) {
                    resolve();
                } else {
                    reject('You need to write something!');
                }
            })
        }
    }).then(function (input) {
        if (input) {
            var binID = input;
            var pageurl = URI();
            var uri = URI(config.urls.warehouse.picking.sales_order.redir.redir);
            uri.addQuery('action', 'select-bin').addQuery('bin', binID).addQuery('page', pageurl);
            window.location.href = uri.toString();
        }
    }).catch(swal.noop);
}
