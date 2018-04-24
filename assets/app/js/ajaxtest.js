jQuery(document).ready(function() {
  post_data = {
    'action' : 'registerUser'
  };
  $.ajax({
      type: 'POST',
      url:  'controllers/login.php',
      data: post_data,
      success: function(response) {
        data = JSON.decode(response);
        console.log(data);
      }
  });
});
