function select2BaseNoClear(selector){
    if ($(selector).length){
        $(selector).select2({
            theme: 'bootstrap4',
            addCssClass : "error",
            language,
        });
        $('.select2-search__field').css('width', '100%');
    }
}

$(function (){
    select2BaseNoClear('.select2-base-no-clear');
})