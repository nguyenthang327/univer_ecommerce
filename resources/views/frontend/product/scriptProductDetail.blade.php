<script>
    function ajaxCall(url, fd) {
        if(url){
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
                success: function(response) {
                    toastr.success(response.message, {
                        timeOut: 5000
                    });
                    // $('#wrap_data_sku').load(location.href + ' #wrap_data_sku .table-responsive');
                    // $('#wrap_option_and_variant').html(response.html);
                    // loaderEnd();
                    $(".header-action.header-cart-mini").load(location.href + " .header-action.header-cart-mini");
                },
                error: function(xhr) {
                    if(xhr.status == 401){
                            window.location.href = window.location.origin + '/login';
                    }else{
                        toastr.error(xhr.responseJSON.message, {
                            timeOut: 5000
                        });
                    }
                    // loaderEnd();
                }
            });
        }
    }

    function getPrice(price, discount = null){
        let language = $("body").data('locales') ?? 'vi';
        let html = '';
        discount = discount ? parseFloat(discount) : 0
        if(language == 'vi'){
            html = `${(parseFloat(price - (price * discount / 100))*23000).toLocaleString('en-US', {style : 'currency', currency : 'VND'})}`;
        }else{
            html = `${parseFloat(price - (price * discount / 100)).toLocaleString('en-US', { style: 'currency', currency: 'USD' })}`;
        }

        return html;
    }

    function resetProductDetail(priceDisplay, stockDisplay){
        $('.shop-details-price h2').html(priceDisplay);
        $('.product-detail-stock').text(stockDisplay);
        $('.cart-plus-minus input[name="quantity"]').data('max', stockDisplay);
    }

    function getSkuByOptionValueID(dataVariant, optionValue1, optionValue2){
        let getSku = dataVariant
            .filter(option => option.product_option_value_id == optionValue1 || option.product_option_value_id == optionValue2)
            .reduce((acc, current) => {
                var obj = acc.find(item => item.sku_id === current.sku_id); // Tìm kiếm đối tượng ở trong acc
                if (!obj) { // Nếu sku_id này chưa tồn tại trong acc
                    acc.push({
                        sku_id: current.sku_id,
                        count: 1
                    }); 
                } else { // Nếu đã tồn tại sku_id này trong acc
                    obj.count++; 
                }
                return acc;
            }, [])
            .find(obj => obj.count === 2);
        return getSku;
    }

    $(document).ready(function() {
        const numOption = $('.pr_variant').length;
        const priceDisplay = $('.shop-details-price h2').html();
        const stockDisplay = $('.product-detail-stock').text();

        const product = $('#form_change_option_value').data('product') ?? null;
        var dataVariant =  product ? product.variants : null;
        var dataSku =  product ? product.skus : null;
        var productSkuID = null;

        $(document).on('click', '.option_value_button', function(e) {
            e.preventDefault();
            productSkuID = null;
            if($(this).hasClass('product-variation--disabled') || $(this).hasClass('product-variation-important--disabled')){
                return true;
            }
            $(this).closest('.pr_variant').find('.option_value_button.active').removeClass('active');
            var optionValue = $(this).closest('.pr_variant').find('.option_value');
            if (optionValue.val() == $(this).data('option_value_id')) {
                $(this).closest('.pr_variant').find('.option_value').val(null);
            } else {
                var optionId = $(this).closest('.pr_variant').data('option_id');
                var optionValueId = $(this).data('option_value_id');
                $(this).closest('.pr_variant').find('.option_value').val(optionValueId);

                var listOtherOption = dataVariant.find(option => option.product_option_id != optionId)
                if(listOtherOption){
                    var otherOptionID = listOtherOption.product_option_id;

                    var optionValueIDs = $(`.pr_variant.pr-option-${otherOptionID}`).find('.option_value_button');
                    $.each(optionValueIDs, function(index, value){
                        let otherOptionValueID = value.attributes['data-option_value_id'].value;
                        let getSkuIdClickOne = getSkuByOptionValueID(dataVariant, optionValueId, otherOptionValueID);

                        if (getSkuIdClickOne !== undefined) {
                            getSkuIdClickOne = getSkuIdClickOne.sku_id;
                            let skuActice = dataSku.find(item => item.id == getSkuIdClickOne && item.price !== null && item.stock > 0);
                            if(skuActice){
                                $(`.pr_variant.pr-option-${otherOptionID} .option_value_button[data-option_value_id='${otherOptionValueID}'] `).removeClass(`product-variation--disabled`)
                            }else{
                                $(`.pr_variant.pr-option-${otherOptionID} .option_value_button[data-option_value_id='${otherOptionValueID}'] `).addClass(`product-variation--disabled`);
                            }
                        } else {
                            $(`.pr_variant.pr-option-${otherOptionID} .option_value_button[data-option_value_id='${otherOptionValueID}'] `).addClass(`product-variation--disabled`);
                        }
                    });
                }

                $(this).addClass('active');
            }
            var formData = $('#form_change_option_value').serializeArray();
            var count = 0;
            $.each(formData, function(index, value) {
                if (value.value != null && value.value != undefined && value.value != '') {
                    count++;
                }
            });

            if(count == 0){
                // Back to default
                $(`#form_change_option_value`).find('.option_value_button').removeClass(`product-variation--disabled`);
            }

            if (numOption == count) {
                // ajaxCall($('#form_change_option_value').serialize());
                $('.shop-details-content input[name="quantity"]').val(1);
                var getSkuId = null;
                if (numOption == 1) {
                    getSkuId = dataVariant.find(item => item.product_option_value_id == formData[0].value).sku_id;
                    productSkuID = getSkuId;
                }

                if (numOption == 2) {
                    getSkuId = getSkuByOptionValueID(dataVariant, formData[0].value, formData[1].value);

                    if (getSkuId !== undefined) {
                        getSkuId = getSkuId.sku_id;
                        productSkuID = getSkuId;
                    } else { 
                        getSkuId = null;
                    }
                }

                if(getSkuId){
                    var sku = dataSku.find(item => item.id == getSkuId && item.price !== null && item.stock > 0);
                    if(sku){
                        $('.shop-details-price h2').html(getPrice(sku.price, product.discount));
                        $('.product-detail-stock').text(sku.stock);
                        $('.cart-plus-minus input[name="quantity"]').data('max', sku.stock);
                    }else{
                        resetProductDetail(priceDisplay, stockDisplay);
                    }
                }else{
                    resetProductDetail(priceDisplay, stockDisplay);
                }
            } else {
                resetProductDetail(priceDisplay, stockDisplay);
            }
        });

        $(document).on('click', '#add-cart', function(e){
            e.preventDefault();
            var errorAll = [];
            var fd = new FormData();

            var url = $(this).data('url');
            var productID = $(this).data('product_id') ?? null;
            var quantity = $(this).closest('.perched-info').find('input[name="quantity"]').val();
            var formVariant = $('#form_change_option_value').serialize();

            if(productID == null || productID.length == 0){
                errorAll.push('Sản phẩm không tồn tại!');
            }else{
                fd.append('product_id', productID);
            }

            if(url == null || url.length == 0){
                errorAll.push('Đường dẫn không tồn tại!');
            }

            if(formVariant.length > 0){
                if(productSkuID == null){
                    errorAll.push('Vui lòng chọn đầy đủ thuộc tính!');
                }else{
                    fd.append('sku_id', productSkuID);
                }
            }

            if(errorAll.length > 0){
                $.each(errorAll, function(index, value) {
                    toastr.error(`${value}`, {timeOut: 5000});
                });
            }else{
                fd.append('quantity', quantity)
                ajaxCall(url, fd)
            }
            
        });

        // $("#rating_product").on('submit', function(e){
        //     e.preventDefault();
        //     var dat = $('#rating_product').serialize();
        //     console.log(dat);
        // })

        // $(document).on('click', '.rising-rating .fa', function(){
        //     var rating = $(this).index() + 1;
        //     console.log('Bạn đã đánh giá ' + rating + ' sao');
        // });
    });
</script>
