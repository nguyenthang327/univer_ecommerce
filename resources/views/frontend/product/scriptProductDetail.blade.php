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
            console.log(formData[0]);
            var count = 0;
            $.each(formData, function(index, value){
                console.log(value.value);
                if(value.value != null && value.value != undefined && value.value != ''){
                    count++;
                }
            });
            if(numOption == count){
                ajaxCall($('#form_change_option_value').serialize());
            }
        });
        
    });
</script>