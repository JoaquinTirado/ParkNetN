//== Class definition
var Dashboard = function() {

    var logout = function() {
      $('#logout').click(function(e) {
          e.preventDefault();
          $.ajax({
              type: 'POST',
              url:  'controllers/logout.php',
              success: function() {
                location.reload();
              }
          });
      });
    }
    
    var handleChangeOfPassword = function() {
      $('#m_new_password_sub').click(function(e) {
          e.preventDefault();
          var btn = $(this);
          var form = $('#changeOfPassword');

          form.validate({
              rules: {
                  new_password: {
                      required: true
                  },
                  password_confirm: {
                      equalTo: "#new_password"
                  }
              }
          });

          if (!form.valid()) {
              return;
          }
          
          var email       = document.getElementById('user-email').value;
          var newPassword = document.getElementById('new_password').value;
          var oldPassword = document.getElementById('old_password').value;
    
          post_data = {
            'action'      : 'changeOfPassword',
            'email'       : email,
            'newPassword' : newPassword,
            'oldPassword' : oldPassword
          };
    
          $.ajax({
              type: 'POST',
              url:  'controllers/new-password-handler.php',
              data: post_data,
              success: function(response) {
                data = JSON.parse(response);
                console.log(data);
              }
          });
      });
    }
    
    var handleNewUser = function() {
      $('#m_new_user_submit').click(function(e) {
          e.preventDefault();
          var btn = $(this);
          var form = $('#newUser');
          
          var email        = document.getElementById('new-user-email').value;
          var phone        = $("#new-user-phone").intlTelInput("getNumber");
          var username     = document.getElementById('new-user-username').value;
    
          post_data = {
            'action'       : 'registerUser',
            'email'        : email,
            'phone'        : phone,
            'username'     : username
          };
    
          $.ajax({
              type: 'POST',
              url:  'controllers/login.php',
              data: post_data,
              success: function(response) {
                data = JSON.parse(response);
                if (data.success == 1) {
                  $('#success-user-message').removeClass('hidden');
                  // similate 2s delay
                	setTimeout(function() {
                    location.reload();
                	}, 3000);
                }
              }
          });
      });
    }

    return {
        //== Init demos
        init: function() {
            // init charts
            logout();
            handleChangeOfPassword();
            handleNewUser();
        }
    };
}();

//== Class initialization on page load
jQuery(document).ready(function() {
    Dashboard.init();
    
    var pageid = document.getElementById('pageid').value;
    if (pageid == 'new-user') {
      document.getElementById('new-user-phone').addEventListener('keyup',function(evt){
        var phoneNumber = document.getElementById('new-user-phone');
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        phoneNumber.value = phoneFormat(phoneNumber.value);
      });
      
      // A function to format text to look like a phone number
      function phoneFormat(input){
        // Strip all characters from the input except digits
        input = input.replace(/\D/g,'');
        // Trim the remaining input to ten characters, to preserve phone number format
        // input = input.substring(0,10);
        return input; 
      }
      
      var telInput = $("#new-user-phone"),
        errorMsg = $("#error-msg"),
        validMsg = $("#valid-msg");
        
      var reset = function() {
        telInput.removeClass("error");
        errorMsg.addClass("hidden");
        validMsg.addClass("hidden");
      };
  
      // on blur: validate
      telInput.blur(function() {
        reset();
        if ($.trim(telInput.val())) {
          if (telInput.intlTelInput("isValidNumber")) {
            validMsg.removeClass("hidden");
          } else {
            telInput.addClass("error");
            errorMsg.removeClass("hidden");
          }
        }
      });
  
      // on keyup / change flag: reset
      telInput.on("keyup change", reset);
    }
});
