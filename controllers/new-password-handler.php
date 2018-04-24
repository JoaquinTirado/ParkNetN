<?php session_start();
include '../initialize.php';

$action = $_POST['action'];

if ($action == 'changeOfPassword') {

	if(!empty($_POST['email'])){

		include '../assets/aws-cognito/changeOfPassword.php';

    if ($changePasswordStatus == 1) {
      echo json_encode(array("success" => 1));
    } else {
      echo json_encode(array("success" => 0));
    }

	} else {
		echo "No post data";
		exit;
	}

}
?>
