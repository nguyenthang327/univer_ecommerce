function select2Base(selector){
    console.log(234);
    if ($(selector).length){
        $(selector).select2({
            theme: 'bootstrap4',
            addCssClass : "error",
        });
        $('.select2-search__field').css('width', '100%');
    }
}

let formatDate = 'dd/mm/yyyy',
    formatMonth = 'mm/yyyy',
    formatTime = 'HH:mm:ss',
    formatDateTime = 'DD/MM/YYYY HH:mm';

function datePicker(selector) {
    if ($(selector).length){
        $(selector).datepicker({
            format: formatDate,
            todayHighlight : true,
            autoClose: true
        }).on('changeDate', function(ev){
            $(this).datepicker('hide');
        });
    } else
        return false;
}

$(function (){
    select2Base('.select2-base');
    datePicker('[data-picker="date"]');
})