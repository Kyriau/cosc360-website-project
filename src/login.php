<?php

	include_once 'database.php';
	
	$user1 = get_user_by_username($_POST['username']);
	
	if($user1[3] == password_hash($_POST['password'], PASSWORD_DEFAULT)) {
		$_SESSION['userid'] = $user1[0];
		$_SESSION['password'] = $user1[3];
	}
	
	$redirectURI = $_POST['redirect'];
	header("Location: $redirectURI");
	die();

?>