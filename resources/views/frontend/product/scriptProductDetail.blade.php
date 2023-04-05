<script>
    function ajaxCall() {
        $.ajax({
            url: url,
            type: "get",
            data: formData,
            dataType: "JSON",
            success: function(response) {
                toastr.success(response.message, {
                    timeOut: 5000
                });
                // $('#wrap_data_sku').load(location.href + ' #wrap_data_sku .table-responsive');
                // $('#wrap_option_and_variant').html(response.html);
                loaderEnd();
            },
            error: function(xhr) {
                let errors = '';
                $('#wrap_data_sku').load(location.href + ' #wrap_data_sku .table-responsive');
                loaderEnd();
            }
        });
    }

    function getPrice(price, discount = null){
        let html = '';
        let type = '$';
        discount = parseFloat(discount) ?? 0;
        html = `${type}${parseFloat(price - (price * discount / 100)).toFixed(2)}`;

        return html;
    }

    function resetProductDetail(priceDisplay, stockDisplay){
        $('.shop-details-price h2').html(priceDisplay);
        $('.product-detail-stock').text(stockDisplay);
    }

    $(document).ready(function() {
        const numOption = $('.pr_variant').length;
        const priceDisplay = $('.shop-details-price h2').html();
        const stockDisplay = $('.product-detail-stock').text();

        const product = $('#form_change_option_value').data('product');
        const dataVariant = product.variants;
        const dataSku =  product.skus;

        $(document).on('click', '.option_value_button', function(e) {
            e.preventDefault();
            $(this).closest('.pr_variant').find('.option_value_button.active').removeClass('active');
            var optionValue = $(this).closest('.pr_variant').find('.option_value');
            if (optionValue.val() == $(this).data('option_value_id')) {
                $(this).closest('.pr_variant').find('.option_value').val(null);
            } else {
                var optionId = $(this).closest('.pr_variant').data('option_id');
                var optionValueId = $(this).data('option_value_id');
                $(this).closest('.pr_variant').find('.option_value').val(optionValueId);

                $(this).closest('.pr_variant').find('.option_value_button.product-variation--disabled').removeClass('product-variation--disabled');
                var listOtherOption = dataVariant.find(option => option.product_option_id != optionId)
                if(listOtherOption){
                    // console.log(optionValueId);
                    var otherOptionID = listOtherOption.product_option_id;
                    // var optionValueID = 

                    var optionValueIDs = $(`.pr_variant.pr-option-${otherOptionID}`).find('.option_value_button');
                    $.each(optionValueIDs, function(index, value){
                        let otherOptionValueID = value.attributes['data-option_value_id'].value;
                        let getSkuIdClickOne = dataVariant
                            .filter(option => option.product_option_value_id == optionValueId || option.product_option_value_id == otherOptionValueID)
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

                        if (getSkuIdClickOne !== undefined) {
                            getSkuIdClickOne = getSkuIdClickOne.sku_id;
                        } else { 
                            getSkuIdClickOne = null;
                        }

                        console.log(getSkuIdClickOne);

                        // console.log(value.attributes['data-option_value_id'].value);
                    });
                    var skuActice = dataSku.find(item => item.id == getSkuIdClickOne && item.price !== null && item.stock > 0);
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

            if (numOption == count) {
                // ajaxCall($('#form_change_option_value').serialize());
                var getSkuId = null;
                if (numOption == 1) {
                    getSkuId = dataVariant.find(item => item.product_option_value_id == formData[0].value).sku_id;
                }

                if (numOption == 2) {
                    getSkuId = dataVariant
                        .filter(option => option.product_option_value_id == formData[0].value || option.product_option_value_id == formData[1].value)
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

                    if (getSkuId !== undefined) {
                        getSkuId = getSkuId.sku_id;
                    } else { 
                        getSkuId = null;
                    }
                }

                if(getSkuId){
                    var sku = dataSku.find(item => item.id == getSkuId && item.price !== null && item.stock > 0);
                    if(sku){
                        $('.shop-details-price h2').html(getPrice(sku.price, product.discount));
                        $('.product-detail-stock').text(sku.stock);
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
    });
</script>
