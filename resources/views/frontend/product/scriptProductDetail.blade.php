<script>

    function ajaxCall(){
        $.ajax({
            url: url,
            type: "get",
            data: formData,
            dataType: "JSON",
            success: function(response) {
                toastr.success(response.message, {timeOut: 5000});
                // $('#wrap_data_sku').load(location.href + ' #wrap_data_sku .table-responsive');
                // $('#wrap_option_and_variant').html(response.html);
                loaderEnd();
            },
            error: function(xhr){
                let errors = '';
                $('#wrap_data_sku').load(location.href + ' #wrap_data_sku .table-responsive');
                loaderEnd();
            }
        });
    }


    $(document).ready(function(){
        var numOption = $('.pr_variant').length;
        const product = $('#form_change_option_value').data('product');
        const dataVariant = product.variants;
        // var filteredData = dataVariant.filter(item => item.product_option_value_id === 1 || item.product_option_value_id === 4);
        const priceDisplay = $('.shop-details-price h2').html();
        // console.log($('.shop-details-price h2').html());
        // console.log(filteredData);
        // // Lấy ra sku_id của phần tử đầu tiên có product_option_value_id = 1 hoặc 4
        // var sku_id = filteredData.find(
        //     item => 
        //         item.product_option_value_id === 1 && 
        //         filteredData.some(x => x.product_option_value_id === 4) && 
        //         item.sku_id === filteredData.find(x => x.product_option_value_id === 4).sku_id
        //     ).sku_id;

        // console.log(sku_id);
        // console.log(product.variants, product.skus);

        $(document).on('click', '.option_value_button', function(e){
            e.preventDefault();
            $(this).closest('.pr_variant').find('.option_value_button.active').removeClass('active');
            var optionValue = $(this).closest('.pr_variant').find('.option_value');
            if(optionValue.val() == $(this).data('option_value_id')){
                $(this).closest('.pr_variant').find('.option_value').val(null);
            }else{
                $(this).closest('.pr_variant').find('.option_value').val($(this).data('option_value_id'));
                $(this).addClass('active');
            }
            var formData = $('#form_change_option_value').serializeArray();
            var count = 0;
            $.each(formData, function(index, value){
                if(value.value != null && value.value != undefined && value.value != ''){
                    count++;
                }
            });
// console.log(formData);
            // console.log(numOption, count);
            if(numOption == count){
                // ajaxCall($('#form_change_option_value').serialize());
                if(numOption == 1){
                    var sku_id = dataVariant.find(item => item.product_option_value_id == formData[0].value).sku_id;
                }

                if(numOption == 2){
                    // var filteredData = dataVariant.filter(item => item.product_option_value_id == formData[0].value || item.product_option_value_id == formData[1].value);
                    // console.log(filteredData, formData[0].value, formData[1].value);
                    // console.log(filteredData.filter(x => x.product_option_value_id == formData[1].value));
                    // var sku_id = filteredData.find(
                    //     item => 
                    //         item.product_option_value_id == formData[0].value && 
                    //         filteredData.some(x => x.product_option_value_id == formData[1].value) && 
                    //         item.sku_id == filteredData.find(x => x.product_option_value_id == formData[1].value).sku_id
                    //     ).sku_id;



                    console.log(filteredItems);
                }
                // $('.shop-details-content').
            }else{
                $('.shop-details-price h2').html(priceDisplay);
            }
        });
        
    });
</script>