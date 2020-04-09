<?php
	
	include_once 'database.php';
	
	if(strlen($_POST['username']) <= 64) {
		$username = $_POST['username'];
	} else {
		header("Location: signup.php?error=1");
		die();
	}
	
	// password_hash() will take care of length
	$password = $_POST['password'];
	
	if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$email = $_POST['email'];
	} else {
		header("Location: signup.php?error=2");
		die();
	}
	
	$rval = insert_user($username, $password, $email);
	
	if($rval > 0) {
		$userID = $_SESSION['userid'];
		header("Location: profile.php?ID=$userID");
		die();
	} else {
		header("Location: signup.php?error=$rval");
		die();
	}

?>