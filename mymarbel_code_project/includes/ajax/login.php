<?php
require_once '../functions.php';

sec_session_start();

$email = $_POST['login__email'];
$password = $_POST['login__password'];
$redirect = $_POST['redirect'];
$login = login($email, $password, $db);
if ($login > 0) {
	echo $login;
}else{
        if (!isLoginSessionExpired())
	{       
		echo '/'.$_SESSION['marbel_user']['type'].'/'.$redirect;
        }else{
            
            echo '/logout';
        }
}
?>