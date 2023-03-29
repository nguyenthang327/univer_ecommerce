$(document).ready(function(){
    $('#formCategory.canShowSubModal').submit(function(e){
        e.preventDefault();
        let parentNew = $('#formCategory select[name="category_parent_id"]').val();
        if(!parentNew){
            // submit
            console.log(132);
            console.log( $('#formCategory'));
            $('#formCategory')[0].submit();
        }else{
            // show modal
            $('#modalCategory').modal('show');

        }
    });

    $('#subFormCate').submit(function(e){
        e.preventDefault();
        let parentNew = $('#subFormCate select[name="category_parent_id_new"]').val();
        $('#formCategory').append(`<input type="hidden" name="category_parent_id_new" value="${parentNew}" /> `);
        $('#formCategory')[0].submit();
    });

    $("#modalCategory").on('hide.bs.modal', function(){
        let categoryParentIdNew = $('#formCategory').find('input[name="category_parent_id_new"]');
        if(categoryParentIdNew.length > 0){
            categoryParentIdNew.remove();
        }
    });
})