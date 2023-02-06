let language = $("body").data('locales');
const trans = {
    'vi' : {
        'agree' : 'Đồng ý',
        'cancel' : 'Hủy bỏ',
    },
    'en' : {
        'agree' : 'Agree',
        'cancel' : 'Cancel',
    },
}

function select2Base(selector){
    if ($(selector).length){
        $(selector).select2({
            allowClear: true,
            theme: 'bootstrap4',
            addCssClass : "error",
            language,
        });
        $('.select2-search__field').css('width', '100%');
    }
}

let formatDate = 'dd/mm/yyyy',
    formatMonth = 'mm/yyyy',
    formatTime = 'HH:mm:ss',
    formatDateTime = 'DD/MM/YYYY HH:mm';

// switch (language){
//     case 'vi':
//         formatDate = 'dd/mm/yyyy',
//         formatMonth = 'mm/yyyy';
//         formatTime = 'HH:mm:ss';
//         formatDateTime = 'DD/MM/YYYY HH:mm';
//         break;
//     case 'en':
//         formatDate = 'yyyy-mm-dd',
//         formatMonth = 'yyyy-mm';
//         formatTime = 'HH:mm:ss';
//         formatDateTime = 'YYYY-MM-DD HH:mm';
//         break;
//     default:
//         break;
// }

function datePicker(selector) {
    if ($(selector).length){
        $(selector).datepicker({
            format: formatDate,
            todayHighlight : true,
            autoClose: true,
        }).on('changeDate', function(ev){
            $(this).datepicker('hide');
        });
    } else
        return false;
}

function dynamicSelectOption(){
    let select = $(this),
        url = select.data('url'),
        val = select.val(),
        child = select.data('child'),
        selectChild = $(child);
    selectChild.trigger('change');
    $.ajax({
        url: url,
        data: {
            id: val
        },
        method: 'GET',
        success: function (data){
            if (data.status === 200){
                selectChild.html('<option></option>');
                data.options.forEach((option, index) => {
                    selectChild.append(`<option value="${option.value}">${option.text}</option>`);
                });
                selectChild.select2('destroy');
                select2Base(child);
            }else {
                // console.log(data.msg);
            }
        },
        error: function (err){
            console.log(err);
        }
    })
}

function checkTypeFileImage(that) {
    let fileExtension = ['png', 'gif', 'jpg', 'jpeg'];
    let fileExtentionCurrent = $(that).val().split('.').pop().toLowerCase();
    if ($.inArray(fileExtentionCurrent, fileExtension) == -1) {
        return false
    }else return true
}

function readFileImage() {
    let that = this,
        $that = $(that),
        checkType = checkTypeFileImage(that),
        img = $('#' + $that.attr('id') + '_view'),
        imgDefault = $that.data('origin') ? $that.data('origin') : '/images/placeholder.png';
    if($that.val()){
        if (that.files && that.files[0]) {
            let reader = new FileReader();
            reader.readAsDataURL(that.files[0]);
            reader.onload = function (e) {
                if (checkType){
                    img.attr('src', e.target.result);
                }else {
                    img.attr('src', imgDefault);
                }
            };
        }
    }else {
        img.attr('src', imgDefault);
    }
}

//hanlding reset form
function handleResetForm(){
    $('form').each(function () {
        let form = $(this),
            reset = form.find(':reset');

        let resetForm = () => {
            setTimeout(function () {
                let inputs = form.find(':input');

                if (form.find('.summernote').length){
                    form.find('.summernote').each(function (){
                        $(this).summernote("code", $(this).val());
                    })
                }
                form.find('input[type="text"]').val('');
                form.find('textarea').val('');
                form.find('input[type="email"]').val('');
                inputs.trigger('change');
            }, 50);
        }
        reset.on('click', resetForm);
    });
}

// fancybox
function fancybox2(selector){
    if($(selector).length){
        $(selector).fancybox({
            cyclic: true,
            padding: 5,
            transitionIn: 'elastic',
            transitionOut: 'elastic',
        });
    }
}

function deleteOrRestoreRowTable(e, btn){
    e.preventDefault();
    swal({
        title: btn.data('title'),
        html: btn.data('text'),
        type: btn.data('icon'),
        showCancelButton: true,
        confirmButtonText: trans[language].agree,
        cancelButtonText: trans[language].cancel,
    }).then((result) => {
        if (result.value) {
            let token = $('meta[name="csrf-token"]').length ? $('meta[name="csrf-token"]').attr('content') : '';
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': token
                },
                url: btn.data('url'),
                type: btn.data('method'),
                dataType: "JSON",
                data: btn.data('id'),
                contentType: false,
                cache: false,
                processData: false,
                success: function (response){
                    $(".table-responsive").load(location.href + " .table-responsive");
                    toastr.success(response.message.text, {timeOut: 5000})
                },
                error: function (err){
                    toastr.error('Có lỗi xảy ra', {timeOut: 5000})
                }
            })
        }
    })
}

$(function (){
    $(document).on('change', '.form-image__file', readFileImage);

    select2Base('.select2-base');
    datePicker('[data-picker="date"]');
    $(document).on('change', '.dynamic-select-option', dynamicSelectOption);

    //reset Form
    handleResetForm();

    // fancybox2 plugin
    fancybox2('.fancybox2');

    $(document).on('click', '.delete-row-table', function(e){
        let btn = $(this);
        deleteOrRestoreRowTable(e, btn);
    })

})