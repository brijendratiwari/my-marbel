<?php
	require_once '../functions.php';
	sec_session_start();
	if (isset($_POST['reset_request_email'])) {
		$email = $_POST['reset_request_email'];
		$login = sendPasswordResetEmail($email, $db);
		echo $login;
	} else if (isset($_POST['reset_key'])) {		
		$password = updatePassword($_POST['reset_email'], $_POST['reset_key'], $_POST['reset_password'], $db);
		echo $password;
	}
?>