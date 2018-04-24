//== Class definition
var SendKey = function() {

    var getKeyId = function() {
      post_data = {
        'action' : 'getKey'
      };
      $.ajax({
          type: 'POST',
          url:  'controllers/send.php',
          data: post_data,
          success: function(response) {
            var data = JSON.parse(response);
            document.getElementById('keyid').value = data.parknetKey;
          }
      });
    }

    var getTimestamp = function() {
      post_data = {
        'action' : 'getTimestamp'
      };
      $.ajax({
          type: 'POST',
          url:  'controllers/send.php',
          data: post_data,
          success: function(response) {
            var data = JSON.parse(response);
            document.getElementById('puertoRicoTimestamp').value = data.timestamp;
          }
      });
    }

    var handleSubmitKey = function() {
        $('#m_key_submit').click(function(e) {
            e.preventDefault();
            var btn = $(this);
            var form = $(this).closest('form');

            var endTimestampVal = 0;
            var startTimestampVal = 0;

            btn.addClass('m-loader m-loader--right m-loader--light').attr('disabled', true);

            var keyid = document.getElementById('keyid').value;
            var name  = document.getElementById('recipient-name').value;
            var createdTimestamp = document.getElementById('puertoRicoTimestamp').value;

            var keytype = $("input:radio[name='keytype']:checked").val();
            if (keytype == 'period') {
              getStartTimestamp();
              var startTimestamp = startTimestampVal;
              getEndTimestamp();
              var endTimestamp = endTimestampVal;
            } else {
              var startTimestamp = document.getElementById('startTimestamp').value;
              var endTimestamp = document.getElementById('endTimestamp').value;
            }

            var sendTo = $("input:radio[name='sendTo']:checked").val();
            if (sendTo == 'email') {
              var receiver = document.getElementById('recipient-email').value;
            } else if (sendTo == 'text') {
              var intlNumber = $("#recipient-phone").intlTelInput("getNumber");
              var receiver = intlNumber.replace('+','');
            }

            function getEndTimestamp() {
              var endVal = document.getElementById('m_datetimepicker_2').value;
              endTimestampVal = Math.round(new Date(endVal).getTime()/1000);
            }
            function getStartTimestamp() {
              var startVal = document.getElementById('m_datetimepicker_3').value;
              startTimestampVal = Math.round(new Date(startVal).getTime()/1000);
            }

            post_data = {
              'action'     : 'submitKey',
              'keyid'      : keyid,
              'keytype'    : keytype,
              'name'       : name,
              'receiver'   : receiver,
              'createdTimestamp' : createdTimestamp,
              'startTimestamp'   : startTimestamp,
              'endTimestamp'     : endTimestamp,
              'sendTo'           : sendTo
            };


            form.ajaxSubmit({
                type: 'POST',
                url:  'controllers/send.php',
                data: post_data,
                success: function(response) {
                  sendKeyEndPoint();
                }
            });

            post_data2 = {
              'action'           : 'sendKey',
              'keyId'            : keyid,
              'keytype'          : keytype,
              'visitorName'      : name,
              'visitorReceiver'  : receiver,
              'createdTimestamp' : createdTimestamp,
              'startTimestamp'   : startTimestamp,
              'endTimestamp'     : endTimestamp,
              'sendTo'           : sendTo
            };

            function sendKeyEndPoint() {
              $.ajax({
                type: 'POST',
                url:  'controllers/send.php',
                data: post_data2,
                success: function(response) {
                  window.location.href = "active.php";
                }, error: function() {
                  window.location.href = "active.php";
                }
              });
            }
        });
    }

    var handleSubmitBulk = function() {

        $('#m_bulk_submit').click(function(e) {
            e.preventDefault();
            var btn = $(this);
            var form = $(this).closest('form');

            var endTimestampVal = 0;
            var startTimestampVal = 0;

            btn.addClass('m-loader m-loader--right m-loader--light').attr('disabled', true);

            var createdTimestamp = document.getElementById('puertoRicoTimestamp').value;

            var keytype = $("input:radio[name='keytype']:checked").val();
            if (keytype == 'period') {
              getStartTimestamp();
              var startTimestamp = startTimestampVal;
              getEndTimestamp();
              var endTimestamp = endTimestampVal;
            } else {
              var startTimestamp = document.getElementById('startTimestamp').value;
              var endTimestamp = document.getElementById('endTimestamp').value;
            }

            function getEndTimestamp() {
              var endVal = document.getElementById('m_datetimepicker_2').value;
              endTimestampVal = Math.round(new Date(endVal).getTime()/1000);
            }
            function getStartTimestamp() {
              var startVal = document.getElementById('m_datetimepicker_3').value;
              startTimestampVal = Math.round(new Date(startVal).getTime()/1000);
            }

            function sendKey(post_data, post_data2) {
              form.ajaxSubmit({
                  type: 'POST',
                  url:  'controllers/send.php',
                  data: post_data,
                  success: function(response) {
                    sendKeyEndPoint(post_data2);
                  }
              });
            }

            function sendKeyEndPoint(post_data2) {
              $.ajax({
                type: 'POST',
                url:  'controllers/send.php',
                data: post_data2,
                success: function(response) {
                  window.location.href = "active.php";
                }, error: function() {
                  window.location.href = "active.php";
                }
              });
            }

            function checkIfEmail(text) {
                var re = /(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))/;
                return re.test(text);
            }

            var bulk = document.getElementById('bulk-keys');
            Papa.parse(bulk.files[0], {
            	complete: function(results) {
            		keys = results.data;
                keys.forEach(function(key, index) {
                  if (index < 1) return;

                  post_data_key = {
                    'action' : 'getKey'
                  };
                  $.ajax({
                      type: 'POST',
                      url:  'controllers/send.php',
                      data: post_data_key,
                      success: function(response) {
                        var data = JSON.parse(response);
                        keyid = data.parknetKey;
                        name = key[0];
                        receiver = key[1];

                        if (checkIfEmail(receiver) == true) {
                          sendTo = 'email';
                        } else {
                          sendTo = 'text';
                        }

                        post_data = {
                          'action'     : 'submitKey',
                          'keyid'      : keyid,
                          'keytype'    : keytype,
                          'name'       : name,
                          'receiver'   : receiver,
                          'createdTimestamp' : createdTimestamp,
                          'startTimestamp'   : startTimestamp,
                          'endTimestamp'     : endTimestamp,
                          'sendTo'           : sendTo
                        };

                        post_data2 = {
                          'action'           : 'sendKey',
                          'keyId'            : keyid,
                          'keytype'          : keytype,
                          'visitorName'      : name,
                          'visitorReceiver'  : receiver,
                          'createdTimestamp' : createdTimestamp,
                          'startTimestamp'   : startTimestamp,
                          'endTimestamp'     : endTimestamp,
                          'sendTo'           : sendTo
                        };

                        sendKey(post_data, post_data2);
                      }
                  });
                });
            	}
            });
        });
    }

    var dateTimePicker = function() {
      var rad = document.sendForm.keytype;
      var prev = null;
      for(var i = 0; i < rad.length; i++) {
          rad[i].onclick = function() {
              if(this !== prev) {
                  prev = this;
              }
              if (this.value == 'period') {
                $('#datepickers').removeClass('hidden');
              } else {
                $('#datepickers').addClass('hidden');
              }
          };
      }
    }

    var sendToPicker = function() {
      var rad = document.sendForm.sendTo;
      var prev = null;
      for(var i = 0; i < rad.length; i++) {
          rad[i].onclick = function() {
              if(this !== prev) {
                  prev = this;
              }
              if (this.value == 'email') {
                $('#receiver-email').removeClass('hidden');
                $('#receiver-text').addClass('hidden');
              } else {
                $('#receiver-text').removeClass('hidden');
                $('#receiver-email').addClass('hidden');
              }
          };
      }
    }

    return {
        //== Init demos
        init: function() {
            // init key
            var pageid = document.getElementById('pageid').value;
            if (pageid == 'send') {
              getKeyId();
              handleSubmitKey();
              dateTimePicker();
              sendToPicker();
            } else if (pageid == 'send-bulk') {
              handleSubmitBulk();            
              dateTimePicker();
            }
        }
    };
}();

//== Class initialization on page load
jQuery(document).ready(function() {
    SendKey.init();

    var pageid = document.getElementById('pageid').value;
    if (pageid == 'send' || pageid == 'send-bulk') {
      document.getElementById('recipient-phone').addEventListener('keyup',function(evt){
        var phoneNumber = document.getElementById('recipient-phone');
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

      var telInput = $("#recipient-phone"),
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
