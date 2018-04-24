<?php session_start();
include '../initialize.php';
// phpinfo();
echo nl2br("Id-Token: \n" . $_SESSION['IdToken']);
echo nl2br("Access-Token: \n" . $_SESSION['AccessToken']);
echo nl2br("Refresh-Token: \n" . $_SESSION['RefreshToken']);

?>
