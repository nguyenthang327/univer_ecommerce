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

        const product = $('#form_change_option_value').data('product');
        const dataVariant = product.variants;
        const dataSku =  product.skus;
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
            var url = $(this).data('url');
            var productID = $(this).data('product_id');
            console.log(productSkuID, productID, url);

        })
    });
</script>
