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
        console.log(input);
        if (input.attr("type") == "password" || input.attr("type") == "password_confirmation") {
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
                $(placement).append(error)
            } else {
                element.parent().after(error);
                $(element).closest('.form-grp').find('.error-commit').focusout().hide();
            }
        },
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 6
            },
            confirmPassword: {
                required: true,
                equalTo: '#password'
            }
        },
        messages: {
            email: {
                required: 'Please enter your email address',
                email: 'Please enter a valid email address'
            },
            password: {
                required: 'Please enter a password',
                minlength: 'Your password must be at least 6 characters long'
            },
            confirmPassword: {
                required: 'Please confirm your password',
                equalTo: 'Your passwords do not match'
            }
        },
    });
});