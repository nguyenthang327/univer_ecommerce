$(document).ready(function(){
    // $('#formCategory.canShowSubModal').submit(function(e){
    //     e.preventDefault();
    //     let parentNew = $('#formCategory select[name="category_parent_id"]').val();
    //     if(!parentNew){
    //         // submit
    //         console.log(132);
    //         console.log( $('#formCategory'));
    //         $('#formCategory')[0].submit();
    //     }else{
    //         // show modal
    //         $('#modalCategory').modal('show');

    //     }
    // });

    // $('#subFormCate').submit(function(e){
    //     e.preventDefault();
    //     let parentNew = $('#subFormCate select[name="category_parent_id_new"]').val();
    //     $('#formCategory').append(`<input type="hidden" name="category_parent_id_new" value="${parentNew}" /> `);
    //     $('#formCategory')[0].submit();
    // });

    // $("#modalCategory").on('hide.bs.modal', function(){
    //     let categoryParentIdNew = $('#formCategory').find('input[name="category_parent_id_new"]');
    //     if(categoryParentIdNew.length > 0){
    //         categoryParentIdNew.remove();
    //     }
    // });

    $(document).on('click', '#butonAddBrand', function(e){
        e.preventDefault();
        var img = $(this).data('img_default');
        var url = $(this).data('url');

        $('#modalBrand').modal('show');
        $('#modalBrand').find('form').attr('action', url)
        $('#modalBrand').find('#brand_logo_view').attr('src', img);
        $('#modalBrand').find('input[name="brand_name"]').val('');
        if($('div.invalid-alert').length > 0){
            $('div.invalid-alert').remove();
        }
    });

    $(document).on('click', '.edit-brand', function(e){
        e.preventDefault();
        var name = $(this).closest('tr').find('.brand-name').text();
        var img = $(this).closest('tr').find('img').attr('src');
        var url = $(this).data('url');

        $('#modalBrand').modal('show');
        $('#modalBrand').find('form').attr('action', url)
        $('#modalBrand').find('#brand_logo_view').attr('src', img);
        $('#modalBrand').find('#brand_logo').attr('data-origin', img);
        $('#modalBrand').find('input[name="brand_name"]').val(name);
        if($('div.invalid-alert').length > 0){
            $('div.invalid-alert').remove();
        }
    });
})