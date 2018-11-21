
var fields = {
    qty: ".qty", margin: ".margin", price: ".price", discountamt: ".discount-amt", discountpercent: ".discount-percent", originalprice: ".originalprice", listprice: ".listprice",
    linenumber: ".linenumber", discountprice: ".discountprice", cost: ".cost", calculatefrom: ".calculate-from", extendedamtspan: ".extended-amount-span", whse: '.item-whse', totalprice: '.totalprice',
    minprice: ".minprice", minpricewarning: ".minpricewarning"
};


$(function() {
    $("body").on("change", ".special-order-select", function() {
        var select = $(this);
        if (select.val() != 'N') {
            $('.special-order-details').removeClass('hidden');
        } else {
            $('.special-order-details').addClass('hidden');
        }
    });

    $("body").on("change", fields.qty, function() {
        calculate_extendedprice();
    });

    $("body").on("change", fields.price, function() {
        calculate_extendedprice();
        if ($(fields.price).val() < $(fields.minprice).val()) {
            if (!config.edit.pricing.allow_belowminprice) {
                $(fields.price).parent().addClass('has-error');
                $('.minpricewarning').removeClass('hidden');
            }
        } else {
            $(fields.price).parent().removeClass('has-error');
            $('.minpricewarning').addClass('hidden');
        }
    });

    $("body").on("click", '.remove-item', function() {
        var button = $(this);
        var form = button.closest('form');
        form.find('input[name=action]').val('remove-line');
        form.submit();
    });
});


function calculate_extendedprice() {
    var price = $(fields.price).val();
    var qty = $(fields.qty).val();
    var extendedamount = price * qty;
    $(fields.totalprice).val(extendedamount.formatMoney(2, '.', ','));
    //$(fields.extendedamtspan).text(extendedamount.formatMoney(2, '.', ','));
}
