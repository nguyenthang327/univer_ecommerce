function changeForm(){
    if($('#login').hasClass('active')){
        $('#login-group').removeClass('d-none');
        $('#register-group').addClass('d-none');
        window.history.replaceState(null, null, '/login');
        
    }else{
        $('#register-group').removeClass('d-none');
        $('#login-group').addClass('d-none');
        window.history.replaceState(null, null, '/register');
    }
}

$(document).ready(function(){

    // change form 
    changeForm();
    $('#login').on('click', function(){
        if(!$(this).hasClass('active')){
            $(this).addClass('active')
        }
        $('#register').removeClass('active');
        changeForm();
    });
    $('#register').on('click', function(){
        if(!$(this).hasClass('active')){
            $(this).addClass('active')
        }
        $('#login').removeClass('active');
        changeForm();
    })

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

    // validate
    $('#register-form').validate({
        onfocusout: function (element, event) {
            $(element).valid();
        },
        submitHandler: function (form) {
            form.submit();
        },
        showErrors: function (errorMap, errorList) {
            var errorForm = this.numberOfInvalids();
            if (errorForm >= 1) {
                $("#register-form button[type='submit']").attr("disabled", true);
            } else {
                $("#register-form button[type='submit']").attr("disabled", false);
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
            first_name: {
                required: true,
                maxlength: 255,
            },
            last_name: {
                required: true,
                maxlength: 255,
            },
            email: {
                required: true,
                email: true
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
            first_name: {
                required: 'Please enter your first name',
                maxlength: 'Your  first name 255 characters ',
            },
            last_name: {
                required: 'Please enter your last name',
                maxlength: 'Your last name must be at max 255 characters long',
            },
            email: {
                required: 'Please enter your email address',
                email: 'Please enter a valid email address'
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

    $('#login-form').validate({
        onfocusout: function (element, event) {
            $(element).valid();
            $('#login-group').find('.alert.alert-danger').remove();
        },
        submitHandler: function (form) {
            form.submit();
        },
        showErrors: function (errorMap, errorList) {
            var errorForm = this.numberOfInvalids();
            if (errorForm >= 1) {
                $("#login-form button[type='submit']").attr("disabled", true);
            } else {
                $("#login-form button[type='submit']").attr("disabled", false);
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
                error.insertAfter(element)
                // element.parent().after(error);
                // $(element).closest('.form-grp').find('.error-commit').focusout().hide();
            }
        },
        rules: {
            email_login: {
                required: true,
                email: true
            },
            password_login: {
                required: true,
                minlength: 6,
                maxlength: 32
            },
        },
        messages: {
            email_login: {
                required: 'Please enter your email address',
                email: 'Please enter a valid email address'
            },
            password_login: {
                required: 'Please enter a password',
                minlength: 'Your password s must be at least 6 characters long',
                maxlength: 'ádf'
            },
        },
    });
});