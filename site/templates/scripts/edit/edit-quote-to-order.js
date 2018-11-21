$(function() {
    $('.select-item').change(function() {
        var checkbox = $(this);
        var form = $('#select-items-form');

        if (checkbox.is(':checked')) {
            var input = '<input type="checkbox" class="hidden" name="linenbr[]" value="'+checkbox.val()+'" checked>;'
            form.append(input);
            checkbox.closest('.detail-line').removeClass('item-not-selected');
        } else {
            form.find("input[name='linenbr[]'][value='"+checkbox.val()+"']").detach();
            checkbox.closest('.detail-line').addClass('item-not-selected');
        }
    });

    $('#select-all').change(function() {
        var checkbox = $(this);
        if (checkbox.is(':checked')) {
            console.log('is checked');
            $('.select-item').prop('checked', true).change();;
        } else {
            $('.select-item').prop('checked', false).change();
        }
    });

    $("body").on("submit", "#select-items-form", function(e) {
        e.preventDefault();
        var form = $(this);
        if ($('.quote-details').find('.item-not-selected').length == $('.quote-details').find('.detail').length) {
            swal({
                title: 'Error!',
                text: 'No items are selected to send to order',
                type: 'error',
                animation: false,
                customClass: 'animated tada'
            });
        } else {
            form.postform({}, function() {
                showajaxloading();
                generateurl(function(url) {
                    window.location.href = url;
                });
            })
        }
    });
});

function validate_selection() {
    var form = $("#select-items-form");
}
