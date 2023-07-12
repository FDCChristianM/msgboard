$(function() {
    $(document).on('submit', '#registerForm', function(e) {
        e.preventDefault()

        const errorMessage = $('.error-message ul')
        let errorList = ''

        let form = $(this).serializeArray()
        let res = sendAjax(base_url + 'users/registerUser', form)

        if(res){
            if(res.status == 'error'){
                $.each(res.errors, function(field, messages) {
                    $.each(messages, function(index, message) {
                        errorList += '<li><p class="small fw-bold pt-1 mb-0">' + message + '</p></li>'
                    })
                })
                errorMessage.html(errorList)
            }else{
                window.location.href = base_url + 'users/thankyou'
            }
        }else{
            errorMessage.html('<li><p class="small fw-bold pt-1 mb-0">Ooops! Something went wrong. Please try again later</p></li>')
        }
    });

    $(document).on('submit', '#loginForm', function(e) {
        e.preventDefault()

        let form = $(this).serializeArray()
        let res = sendAjax(base_url + 'users/login', form)
    });

    $(document).on('change', '#upload-profile', function(e) {
        var input = this;
        if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function(e) {
            $('#profile-container').find('.img-account-profile').attr('src', e.target.result);
          }
          reader.readAsDataURL(input.files[0]);
        }
    });

    $("#birthdate").datepicker({
        dateFormat: "MM d, yy",
        changeMonth: true,
        changeYear: true,
        yearRange: "1900:c",
        maxDate: "0",
    });

    $(document).on('submit', '#editProfileForm', function(e) {
        e.preventDefault();
    
        const errorMessage = $('.error-message ul');
        let errorList = '';
    
        let fileInput = $('#upload-profile').val();
        let file = fileInput.replace(/^.*[\\\/]/, '');
    
        let formData = new FormData($(this)[0]);
        formData.append('photo', file);
    
        // Check and update hubby value
        let hubby = formData.get('hubby');
        if (hubby === 'Please set your hubby') {
            formData.set('hubby', ''); // Set hubby to an empty string
        }
    
        let res = formAjax(base_url + 'users/updateProfile', formData);
    
        if (res) {
            if (res.status === 'error' || res.status === 500) {
                if (res.errors) {
                    $.each(res.errors, function(field, messages) {
                        $.each(messages, function(index, message) {
                            errorList += '<li><p class="small fw-bold pt-1 mb-0">' + message + '</p></li>';
                        });
                    });
                } else {
                    errorList += '<li><p class="small fw-bold pt-1 mb-0">An error occurred. Please try again.</p></li>';
                }
                errorMessage.html(errorList);
            } else {
                window.location.href = base_url + 'users/myProfile'
            }
        } else {
            errorMessage.html('<li><p class="small fw-bold pt-1 mb-0">Oops! Something went wrong. Please try again later.</p></li>');
        }
    });

    $(document).on('submit', '#editAccountForm', function(e) {
        e.preventDefault();
        
        let form = $(this).serializeArray()
        const errorMessage = $('.error-message ul');
        let errorList = '';
    
    
        let res = sendAjax(base_url + 'users/updateAccount', form);
    
        if (res) {
            if (res.status === 'error' || res.status === 500) {
                if (res.errors) {
                    $.each(res.errors, function(field, messages) {
                        $.each(messages, function(index, message) {
                            errorList += '<li><p class="small fw-bold pt-1 mb-0">' + message + '</p></li>';
                        });
                    });
                } else {
                    errorList += '<li><p class="small fw-bold pt-1 mb-0">An error occurred. Please try again.</p></li>';
                }
                errorMessage.html(errorList);
            } else {
                window.location.href = base_url + 'users/myProfile'
            }
        } else {
            errorMessage.html('<li><p class="small fw-bold pt-1 mb-0">Oops! Something went wrong. Please try again later.</p></li>');
        }
    });
});
