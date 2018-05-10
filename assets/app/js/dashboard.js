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
        //Send data to php file in order to confirm
        //that there are no phone duplicates
        $.post('../../../CHANGE.php', {
          postData : telInput.val()
        }, function(data, status){

          //document.write(data); <- used for debugging
          if(data == 'taken'){
          $('#new-user-phone').val('');
          validMsg.text('Phone number in use');
          validMsg.css('color', '#ed145b');
          validMsg.removeClass("hidden"); 
          }
        });

        if ($.trim(telInput.val())) {
          if (telInput.intlTelInput("isValidNumber")) {
            validMsg.text('✓ Valid');
            validMsg.css('color', '#24e370');
            validMsg.removeClass("hidden");
          } else {
            telInput.addClass("error");
            errorMsg.removeClass("hidden");
          }
        }
      });
  
      // on keyup / change flag: reset
      telInput.on("keyup change", reset);

      //Initialize the variables for user input and error msg
      var usrInput = $("#new-user-username"),
          usrErrorMsg = $("#new-user-error-message");

      //Clean up old error msg:
      var resetUsrErrorMsg = function(){
        usrErrorMsg.addClass("hidden");
      }    

      //When the user clicks away (out of focus), check his input 
      usrInput.blur(function(){
        resetUsrErrorMsg();

        //Check if the user actually type in something
        if (usrInput.val().length == 0 ){
          usrInput.val('');
          usrErrorMsg.text('Null not accepted, please type something');
          usrErrorMsg.css('color', '#ed145b');
          usrErrorMsg.removeClass("hidden");
        }
        //Check if the password is at least 8 chars in length
        else if (usrInput.val().length < 8 ) {
          usrInput.val('');
          usrErrorMsg.text('Password must be at least 8 characters');
          usrErrorMsg.css('color', '#ed145b');
          usrErrorMsg.removeClass("hidden");       
        }
        //check if there is whitespace in the string
        else if (usrInput.val().indexOf(' ') !== -1) {
          usrInput.val('');
          usrErrorMsg.text('No whitespace allowed');
          usrErrorMsg.css('color', '#ed145b');
          usrErrorMsg.removeClass("hidden");   
        }
        //If everything is right, greet the user with friendly msg:
        else {
          usrErrorMsg.text('Fits rules');
          usrErrorMsg.css('color', '#24e370');
          usrErrorMsg.removeClass("hidden");  
        }
        


      });
      //Initialize email variables 
      var usrEmail = $('#new-user-email'),
          usrEmailErrMsg = $('#new-user-email-error');

    //Function that wipes email error mesages
      function resetUsrEmailErr(){
        usrEmailErrMsg.addClass('hidden');
      }


      usrEmail.blur(function(){
        resetUsrEmailErr();
        //Verify that there are no email duplicates
        $.post('../../../CHANGE.php', {
          postData : usrEmail.val()
        }, function(data, status){

          //document.write(data); <- used for debugging
          if(data == 'taken'){
          usrEmail.val('');
          usrEmailErrMsg.text('Email in use');
          usrEmailErrMsg.css('color', '#ed145b');
          usrEmailErrMsg.removeClass("hidden"); 
          }
          else{
          usrEmailErrMsg.text('Unique');
          usrEmailErrMsg.css('color', '#24e370');
          usrEmailErrMsg.removeClass("hidden"); 
          }
        });




      });


    }
});
