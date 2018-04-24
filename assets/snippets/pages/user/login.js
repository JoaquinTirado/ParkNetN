//== Class Definition
var SnippetLogin = function() {

    var login = $('#m_login');

    var showErrorMsg = function(form, type, msg) {
        var alert = $('<div class="m-alert m-alert--outline alert alert-' + type + ' alert-dismissible" role="alert">\
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>\
			<span></span>\
		</div>');

        form.find('.alert').remove();
        alert.prependTo(form);
        alert.animateClass('fadeIn animated');
        alert.find('span').html(msg);
    }

    //== Private Functions

    var displaySignUpForm = function() {
        login.removeClass('m-login--forget-password');
        login.removeClass('m-login--signin');

        login.addClass('m-login--signup');
        login.find('.m-login__signup').animateClass('flipInX animated');
    }

    var displaySignInForm = function() {
        login.removeClass('m-login--forget-password');
        login.removeClass('m-login--signup');

        login.addClass('m-login--signin');
        login.find('.m-login__signin').animateClass('flipInX animated');
    }

    var displayForgetPasswordForm = function() {
        login.removeClass('m-login--signin');
        login.removeClass('m-login--signup');

        login.addClass('m-login--forget-password');
        login.find('.m-login__forget-password').animateClass('flipInX animated');
    }

    var handleFormSwitch = function() {
        $('#m_login_forget_password').click(function(e) {
            e.preventDefault();
            displayForgetPasswordForm();
        });

        $('#m_login_forget_password_cancel').click(function(e) {
            e.preventDefault();
            displaySignInForm();
        });

        $('#m_login_signup').click(function(e) {
            e.preventDefault();
            displaySignUpForm();
        });

        $('#m_login_signup_cancel').click(function(e) {
            e.preventDefault();
            displaySignInForm();
        });
    }

    var handleSignInFormSubmit = function() {
        $('#m_login_signin_submit').click(function(e) {
            e.preventDefault();
            var btn = $(this);
            var form = $(this).closest('form');

            form.validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true
                    }
                }
            });

            if (!form.valid()) {
                return;
            }

            btn.addClass('m-loader m-loader--right m-loader--light').attr('disabled', true);

            var email = document.getElementById('login_email').value;
            var password = document.getElementById('login_password').value;

            post_data = {
              'action'     : 'login',
              'email'      : email,
              'password'   : password
            };

            form.ajaxSubmit({
                type: 'POST',
                url:  '../controllers/login.php',
                data: post_data,
                success: function(response, status, xhr, $form) {
                  var data = JSON.parse(response);
                  console.log(response);
                  if (data.success == 2) {
                    document.getElementById('user-old-password').value = data.password;
                    document.getElementById('user-email').value = data.email;
                    $('#m_modal_2').modal('show');
                  } else if (data.success == 3) {
                    $('#m_modal_3').modal('show');
                  } else if (data.success == 1){
                    window.location.href = "../index.php";
                  } else {
                    // similate 2s delay
                  	setTimeout(function() {
  	                    btn.removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
  	                    showErrorMsg(form, 'danger', 'Incorrect username or password. Please try again.');
                      }, 2000);
                  }
                }, error: function() {
                    // similate 2s delay
                    setTimeout(function() {
                        btn.removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
                        showErrorMsg(form, 'danger', 'Incorrect username or password. Please try again.');
                      }, 2000);
                }
            });
        });
    }

    var handleChangePasswordSubmit = function() {
        $('#m_change_password_submit').click(function(e) {
            e.preventDefault();
            var btn_2 = $(this);
            var form_2 = $('#changePassword');
            
            form_2.validate({
                rules: {
                    password: {
                        required: true
                    },
                    password_confirm: {
                        equalTo: "#user-password"
                    }
                }
            });
  
            if (!form_2.valid()) {
                return;
            }

            var email_2 = document.getElementById('user-email').value;
            var password_2 = document.getElementById('user-old-password').value;
            var new_password = document.getElementById('user-password').value;
            var userName = document.getElementById('user-name').value;

            post_data = {
              'action'       : 'changePassword',
              'email'        : email_2,
              'password'     : password_2,
              'new_password' : new_password,
              'user_name'    : userName
            };

            form_2.ajaxSubmit({
                type: 'POST',
                url:  '../controllers/changePassword.php',
                data: post_data,
                success: function(response, status, xhr, $form) {
                  var data = JSON.parse(response);
                  if (data.success == 1) {
                    window.location.href = "../index.php";
                  } else {
                    alert("Something went wrong. Please try again.");
                  }
                }
            });
        });
    }

    var handleSignUpFormSubmit = function() {
        $('#m_login_signup_submit').click(function(e) {
            e.preventDefault();

            var btn = $(this);
            var form = $(this).closest('form');

            form.validate({
                rules: {
                    fullname: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true
                    },
                    rpassword: {
                        required: true
                    },
                    agree: {
                        required: true
                    }
                }
            });

            if (!form.valid()) {
                return;
            }

            btn.addClass('m-loader m-loader--right m-loader--light').attr('disabled', true);

            var name      = document.getElementById('signup_name').value;
            var email     = document.getElementById('signup_email').value;
            var password  = document.getElementById('signup_password').value;

            post_data = {
              'action'     : 'signup',
              'name'       : name,
              'email'      : email,
              'password'   : password
            };

            form.ajaxSubmit({
                type: 'POST',
                url:  '../controllers/login.php',
                data: post_data,
                success: function(response, status, xhr, $form) {
                   btn.removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
                   form.clearForm();
                   form.validate().resetForm();

                   // display signup form
                   displaySignInForm();
                   var signInForm = login.find('.m-login__signin form');
                   signInForm.clearForm();
                   signInForm.validate().resetForm();

                   showErrorMsg(signInForm, 'success', 'Thank you. You have been registered.');
                }
            });
        });
    }

    var handleForgetPasswordFormSubmit = function() {
        $('#m_login_forget_password_submit').click(function(e) {
            e.preventDefault();

            var btn = $(this);
            var form = $(this).closest('form');

            btn.addClass('m-loader m-loader--right m-loader--light').attr('disabled', true);

            var email     = document.getElementById('forgot_email').value;
            document.getElementById('reset-username').value = email;

            post_data = {
              'action'     : 'forgotPassword',
              'email'      : email
            };

            form.ajaxSubmit({
                type: 'POST',
                url:  '../controllers/login.php',
                data: post_data,
                success: function(response, status, xhr, $form) {
                  data = JSON.parse(response);
                	// similate 2s delay
                	setTimeout(function() {
                		btn.removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false); // remove
	                    form.clearForm(); // clear form
	                    form.validate().resetForm(); // reset validation states
                      if (data.success == 1) {
                        $('#m_modal_3').modal('show');
                      }
                	}, 2000);
                }
            });
        });
    }
    
    var handleResetPasswordSubmit = function() {
        $('#m_reset_password_submit').click(function(e) {
            e.preventDefault();
            var btn_reset = $(this);
            var form_reset = $('#reset-password');
            
            form_reset.validate({
                rules: {
                    password: {
                        required: true
                    },
                    password_confirm: {
                        equalTo: "#new-password"
                    }
                }
            });
  
            if (!form_reset.valid()) {
                return;
            }

            var confirmation_code = document.getElementById('confirmation-code').value;
            var new_password = document.getElementById('new-password').value;
            var reset_username = document.getElementById('reset-username').value;

            post_data_reset = {
              'action'            : 'resetPassword',
              'reset_username'    : reset_username,
              'confirmationCode'  : confirmation_code,
              'new_password'      : new_password
            };

            form_reset.ajaxSubmit({
                type: 'POST',
                url:  '../controllers/reset-password-handler.php',
                data: post_data_reset,
                success: function(response, status, xhr, $form) {
                  var data = JSON.parse(response);
                  if (data.success == 1) {
                    btn_reset.removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
                    form_reset.clearForm();
                    form_reset.validate().resetForm();
 
                    // display signup form
                    displaySignInForm();
                    var signInForm = login.find('.m-login__signin form');
                    signInForm.clearForm();
                    signInForm.validate().resetForm();
 
                    showErrorMsg(signInForm, 'success', 'Thank you. Your password has been changed.');
                    $('#m_modal_3').modal('hide');
                  } else {
                    alert("Something went wrong. Please try again.");
                  }
                }
            });
        });
    }

    //== Public Functions
    return {
        // public functions
        init: function() {
            handleFormSwitch();
            handleSignInFormSubmit();
            handleSignUpFormSubmit();
            handleResetPasswordSubmit();
            handleChangePasswordSubmit();
            handleForgetPasswordFormSubmit();
        }
    };
}();

//== Class Initialization
jQuery(document).ready(function() {
    SnippetLogin.init();
});
