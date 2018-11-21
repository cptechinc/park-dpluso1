$(function() {
    $('.create-order').on('click', function(e) {
        e.preventDefault();
        var href = $(this).attr('href');
        var type = $(this).data('type');
        if ($('.cart-item').length) {
            window.location.href = href;
        } else {
            swal({
                title: 'Error',
                text: "You don't have items to create your " + type,
                type: 'error',
            }).catch(swal.noop);
        }
    });
});
