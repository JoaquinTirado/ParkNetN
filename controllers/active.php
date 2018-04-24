<?php session_start();
include 'initialize.php';

	if($_SESSION['role'] != 'admin') {
		header('Location:../pages/login.php');
	} else {
		//Run page

		//Count Active Keys
		$sql = "SELECT COUNT(*) AS active FROM coco_keys WHERE active = 'true'";
		if ($result = pg_query($connec, $sql)) {
			while($row = pg_fetch_array($result)){
				$active_keys_count = $row['active'];
			}
		} else {
			echo "Query error";
		}
	}
}


?>
