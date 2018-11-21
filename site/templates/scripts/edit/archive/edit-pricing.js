
var fields = {
    qty: ".qty", margin: ".margin", price: ".price", discountamt: ".discount-amt", discountpercent: ".discount-percent", originalprice: ".originalprice", listprice: ".listprice",
    linenumber: ".linenumber", discountprice: ".discountprice", cost: ".cost", calculatefrom: ".calculate-from", extendedamtspan: ".extended-amount-span", whse: '.item-whse'
};


$(function() {
    //$(".page").on("click", ".update-line", function(e) { It's now defined in scripts.js




    $("body").on("change", fields.qty, function() {
        calculateextendedprice();
    });

    $("body").on("click", '.remove-item', function() {
        var button = $(this);
        var form = button.closest('form');
        form.find('input[name=action]').val('remove-line');
        form.submit();
    });
});

/*
$("body").on("change", fields.price, function() {
    calculateprice();

    calculatemargin(function(margin) {
        $(fields.margin).val(margin);
    });
});

 $("body").on("change", fields.discountpercent, function() {
     var disc_pct = $(this).val() / 100;
     var listprice = $(fields.listprice).val();
     var discountamount = disc_pct * listprice;
     var price = listprice - discountamount;
     $(fields.calculatefrom).val('percent');
     $(fields.price).val(price).change();
 });

 $("body").on("change", fields.margin, function() {
     var margin = $(this).val();
     var cost = $(fields.cost).val();
     var price = calculate_price_from_margin(margin, cost);
     $(item_price).val(price).change();
 });

 $("body").on("change", fields.qty, function() {
     $(fields.price).change();
     alert('stuff');
 });
*/



function calculateextendedprice() {
    var price = $(fields.price).val();
    var qty = $(fields.qty).val();
    var extendedamount = price * qty;
    $(fields.extendedamtspan).text(extendedamount.formatMoney(2, '.', ','));
}

function calculateprice() {
    var itemprice = $(fields.price).val();
    var listprice = $(fields.listprice).val();

    if (listprice == 0.00) {
        var totalprice = itemprice * $(qty).val();
    } else {
        var calculatefrom = $(fields.calculatefrom).val();
        var discountamount = '';
        var discountpercent = '';
        if (calculatefrom == 'percent') {
            discountpercent = $(fields.discountpercent).val();
            discountamount = discountpercent ^ itemprice;
        } else if (calculatefrom == 'amount') {
            discountamount = $(fields.discountamount).val()
            discountpercent = discountamount / itemprice;

        }
        if (discountpercent < 0) {
           discountpercent = '';
       }
       $(fields.discountpercent).val(discountpercent.formatMoney(2, '.', ','));
       if (discountamount < 0) {
           discountamount = 0.00;
           $(fields.price).val(itemprice).formatMoney(2, '.', ',');
       } else {
           alert('');
			$(fields.price).val(listprice - discountamount).formatMoney(2, '.', ',');
		}

        $(fields.discountamt).val(discountamount).formatMoney(2, '.', ',');
        $(fields.totalprice).val(itemprice * $(fields.qty).val());
    }
}

function calculatemargin(callback) {
    var price = $(item_price).val().replace('$','');
    var cost = $(cost_output).text().replace('$','');
    var margin = ((price - cost) / price * 100);
    callback(margin);
}

function calculate_price_from_margin(margin, cost) {
    var price = ((cost) / (1 - (margin / 100)));
    return price;
}
