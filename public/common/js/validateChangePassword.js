$(document).ready(function(){
    $('#change-password-form').validate({
        onfocusout: function (element, event) {
            $(element).valid();
        },
        submitHandler: function (form) {
            form.submit();
        },
        showErrors: function (errorMap, errorList) {
            var errorForm = this.numberOfInvalids();
            if (errorForm >= 1) {
                $("#change-password-form button[type='submit']").attr("disabled", true);
            } else {
                $("#change-password-form button[type='submit']").attr("disabled", false);
            }
            var $errorDiv = $("#errordiv").empty().show();
            this.defaultShowErrors();
            var errorsCombined = "";
            for (var el in errorMap) {
                errorsCombined += "<b>" + el + "</b>" + errorMap[el] + "<br/>";
            }
            $errorDiv.append(errorsCombined);
        },
        invalidHandler: function (event, validator) {
            var errors = validator.numberOfInvalids();
            if (errors) {
    
            }
        },
        errorElement: 'p',
        errorPlacement: function (error, element) {
            var placement = $(element).data('error');
            if (placement) {
                $(element).append(error);
            } else {
                error.insertAfter(element);
                $(element).parent().find('.invalid-alert.text-danger').remove();
                // element.parent().after(error);
                // $(element).closest('.form-grp').find('.error-commit').focusout().hide();
            }
        },
        rules: {
            old_password: {
                required: true,
            },
            password: {
                required: true,
                minlength: 6,
                maxlength: 32
            },
            password_confirmation: {
                required: true,
                equalTo: '#password'
            }
        },
        messages: {
            old_password: {
                required: 'Please enter your old pw',
            },
            password: {
                required: 'Please enter a password',
                minlength: 'Your password must be at least 6 characters long'
            },
            password_confirmation: {
                required: 'Please confirm your password',
                equalTo: 'Your passwords do not match'
            }
        },
    });
    
     // show hide password
     $(".toggle-password").click(function() {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });
})