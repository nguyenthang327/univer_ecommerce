

var productNumber = $('.related-product-active > .col-xl-3').length;
var i = 0;
while(productNumber < 5 && productNumber > 0){
    $('.related-product-active').append(`<div class="col-xl-3">` +  $('.related-product-active > .col-xl-3').eq(i).html() + `</div>`);
    ++productNumber;
    ++i;
    if(i == 4){
        callBackSlider();
        break;
    }
}

/*=============================================
    =         Related Product Active        =
=============================================*/
function callBackSlider(){
    $('.related-product-active').slick({
        dots: false,
        infinite: true,
        speed: 800,
        autoplay: true,
        arrows: true,
        slidesToShow: 4,
        slidesToScroll: 1,
        prevArrow: '<span class="slick-prev"><i class="fas fa-angle-left"></i></span>',
        nextArrow: '<span class="slick-next"><i class="fas fa-angle-right"></i></span>',
        appendArrows: ".slider-nav",
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    infinite: true,
                }
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                }
            },
            {
                breakpoint: 575,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false,
                }
            },
        ]
    });
}
    
/*=============================================
    =         Product Rating Active        =
=============================================*/
function rating(){

    var options = {
        max_value: 5,
        step_size: 1,
        initial_value: 0,
        selected_symbol_type: 'fontawesome_star', // Must be a key from symbols
        cursor: 'default',
        readonly: false,
        change_once: false, // Determines if the rating can only be set once
        ajax_method: 'POST',
        additional_data: {}, // Additional data to send to the server
    }
    $(".rising-rating").rate(options).on('change', function(event, value, caption) {
        // console.log('Bạn đã đánh giá ' + $(this).rate("getValue"));
        $('#rating_product').find('input[name="rating"]').val($(this).rate("getValue"));
    });
}

function ratingAVG(){
    var ratingValue = $('.rating.detail').data('rating_value')
    $('.rating.detail').rate({
        max_value: 5,
        step_size: 1,
        initial_value: ratingValue,
        selected_symbol_type: 'fontawesome_star', // Must be a key from symbols
        cursor: 'default',
        readonly: true,
    })
}
  

function ajaxComment(){
    let token = $('meta[name="csrf-token"]').length ? $('meta[name="csrf-token"]').attr('content') : '';
    var dataArray = $("#rating_product").serializeArray();
    var fd = new FormData();
    dataArray.forEach(function(value){
        fd.append(value.name, value.value);
    })
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": token,
        },
        url: $("#rating_product").attr('action'),
        type: "POST",
        data: fd,
        dataType: "JSON",
        processData: false,
        contentType: false,
        async: false,
        success: function(response) {
            toastr.success(response.message, {
                timeOut: 5000
            });
            $('.product-reviews-wrap .reviews-count-title').load(location.href + ' .product-reviews-wrap .reviews-count-title');
            $('.product-reviews-wrap .product-review-list.blog-comment').load(location.href + ' .product-reviews-wrap .product-review-list.blog-comment');
            $("#content_comment").val('');
            // $('.shop-details-review').load(location.href + ' .shop-details-review');
            // ratingAVG();
            // console.log( $('.rating.detail').data('rating_value'));
        },
        error: function(xhr) {
            if(xhr.status == 401){
                window.location.href = window.location.origin + '/login';
            }else{
                toastr.error(xhr.responseJSON.message, {
                    timeOut: 5000
                });
            }
        }
    });
}

function ajaxWishlist(url, fd){
    let token = $('meta[name="csrf-token"]').length ? $('meta[name="csrf-token"]').attr('content') : '';
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": token,
        },
        url: url,
        type: "POST",
        data: fd,
        dataType: "JSON",
        processData: false,
        contentType: false,
        async: false,
        success: function(response) {
            toastr.success(response.message, {
                timeOut: 5000
            });
            $('.shop-details-content .shop-details-bottom').load(location.href + ' .shop-details-content .shop-details-bottom');
            $('.wishlist-area').load(location.href + ' .wishlist-area')
        },
        error: function(xhr) {
            if(xhr.status == 401){
                window.location.href = window.location.origin + '/login';
            }else{
                toastr.error(xhr.responseJSON.message, {
                    timeOut: 5000
                });
            }
        }
    });
}

$(document).ready(function(){
    ratingAVG();
    rating();

    // validate
    $('#rating_product').validate({
        ignore: [],
        onfocusout: function (element, event) {
            $(element).valid();
        },
        submitHandler: function (form) {
            // form.submit();
            ajaxComment();
            return false;
        },
        showErrors: function (errorMap, errorList) {
            var errorForm = this.numberOfInvalids();
            if (errorForm >= 1) {
                $("#rating_product button[type='submit']").attr("disabled", true);
            } else {
                $("#rating_product button[type='submit']").attr("disabled", false);
            }
            var $errorDiv = $("#errordiv").empty().show();
            this.defaultShowErrors();
            var errorsCombined = "";
            for (var el in errorMap) {
                errorsCombined += "<b>" + el + "</b>" + errorMap[el] + "<br/>";
            }
            $errorDiv.append(errorsCombined);
        },
        invalidHandler: function (event, validator) {
            var errors = validator.numberOfInvalids();
            if (errors) {

            }
        },
        errorElement: 'p',
        errorPlacement: function (error, element) {
            var placement = $(element).data('error');
            if (element.is(":hidden")) {
                // Thêm class "hidden-error" cho thông báo lỗi
                error.addClass("hidden-error");
                // Thêm thông báo lỗi vào sau element: sau hidden input
                error.insertAfter(element);
            }
            if (placement) {
                $(element).append(error);
            } else {
                error.insertAfter(element);
                $(element).parent().find('.invalid-alert.text-danger').remove();
                // element.parent().after(error);
                // $(element).closest('.form-grp').find('.error-commit').focusout().hide();
            }
        },
        rules: {
            rating: {
                required: true,
            },
            content: {
                required: true,
                maxlength: 1000,
            }
        },
        messages: {
            rating: {
                required: 'Vui lòng chọn đánh giá',
                // min: 'Your  first name 255 characters ',
            },
            content: {
                required: 'Vui lòng nhập nội dung',
                maxlength: 'Vui lòng nhập nhỏ hơn 1000 ký tự',
            },
        },
    });

    $(document).on('click', '#add-wishlist', function(e){
        e.preventDefault();
        var errorAll = [];
        var fd = new FormData();

        var url = $(this).data('url');
        var productID = $(this).data('product_id') ?? null;

        if(productID == null || productID.length == 0){
            errorAll.push('Sản phẩm không tồn tại!');
        }else{
            fd.append('product_id', productID);
        }

        if(url == null || url.length == 0){
            errorAll.push('Đường dẫn không tồn tại!');
        }
        if(errorAll.length > 0){
            $.each(errorAll, function(index, value) {
                toastr.error(`${value}`, {timeOut: 5000});
            });
        }else{
            ajaxWishlist(url, fd);
        }
        
    });

})