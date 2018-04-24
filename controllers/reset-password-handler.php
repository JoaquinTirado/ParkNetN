<?php session_start();
include '../initialize.php';

$action = $_POST['action'];

if ($action = 'resetPassword') {

  if(!empty($_POST['reset_username'])) {

		include '../assets/aws-cognito/resetPasswordRequest.php';
		echo json_encode(array("success" => 1));

  } else {
    echo "No username posted";
  }

}

?>
