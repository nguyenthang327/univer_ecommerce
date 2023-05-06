<script>
    const token = $('meta[name="csrf-token"]').length ? $('meta[name="csrf-token"]').attr('content') : '';

    function reloadCart(){
        $(".shop-cart-area.wishlist-area").load(location.href + " .shop-cart-area.wishlist-area");
        $(".header-action.header-cart-mini").load(location.href + " .header-action.header-cart-mini");
    }
    function ajaxRemove(url){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': token
            },
            url: url,
            type: 'DELETE',
            dataType: "JSON",
            // data: btn.data('id'),
            contentType: false,
            cache: false,
            processData: false,
            success: function (response){
                reloadCart();
                // toastr.success(response.message.text, {timeOut: 5000})
                toastr.success('Xóa thành công', {timeOut: 5000});
            },
            error: function (err){
                toastr.error('Có lỗi xảy ra', {timeOut: 5000})
            }
        })
    }

    function ajaxUpdate(url, fd){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': token
            },
            url: url,
            type: 'POST',
            data: fd,
            dataType: "JSON",
            processData: false,
            contentType: false,
            success: function (response){
                reloadCart();
                // toastr.success(response.message.text, {timeOut: 5000})
                toastr.success('Xóa thành công', {timeOut: 5000});
            },
            error: function (err){
                $(".shop-cart-area.wishlist-area").load(location.href + " .shop-cart-area.wishlist-area");
                toastr.error('Có lỗi xảy ra', {timeOut: 5000})
            }
        })
    }

    function ajaxCheckCoupon(url, fd){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': token
            },
            url: url,
            type: 'GET',
            data: fd,
            dataType: "JSON",
            processData: false,
            contentType: false,
            success: function (response){
                reloadCart();
                // toastr.success(response.message.text, {timeOut: 5000})
                toastr.success('Thành công ', {timeOut: 5000});
            },
            error: function (err){
                reloadCart();
                toastr.error(err.responseJSON.message, {timeOut: 5000})
            }
        })
    }

    // click '+' or '-'
    var timeoutId;
    $(document).on('click', '.qtybutton', function(){
        var old = parseInt($(this).parent().find('input[name="quantity"]').data('old'));
        var current = parseInt($(this).parent().find('input[name="quantity"]').val());
        clearTimeout(timeoutId);
        if(old !== current){
            var url = $(this).closest('.cart-plus-minus').data('url');
            var fd = new FormData();
            fd.append('quantity', current);
            fd.append('_method', 'PUT');
            timeoutId = setTimeout(() => {
                ajaxUpdate(url, fd);
            }, 1000);
        }
    });

    // change input
    $(document).on('change', '.cart-plus-minus input[name="quantity"]', function(){
        var old = parseInt($(this).data('old'));
        var current = parseInt($(this).val());

        if(old !== current){
            var url = $(this).closest('.cart-plus-minus').data('url');
            var fd = new FormData();
            fd.append('quantity', current);
            fd.append('_method', 'PUT');
            ajaxUpdate(url, fd);
        }
    });

    $(document).on('click', '.removeItemInCart', function(e){
        e.preventDefault();
        var cartDetailID = $(this).closest('tr.cart-item').data('cart_detail_id');
        var url = $(this).data('url');
        ajaxRemove(url);
        // if(Number.isInteger(cartDetailID)){
        //     toastr.success('Xóa thành công', {timeOut: 5000});
            
        // }else{
        //     toastr.error('Sản phẩm không tồn tại', {timeOut: 5000});
        // }
    });

    $(document).on('submit', '#coupon_form', function(e){
        e.preventDefault();
        var url = $(this).attr('action');
        var fd = $(this).serialize();
        ajaxCheckCoupon(url, fd);
    });
</script>