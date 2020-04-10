<?php

	session_start();
	
	if(!isset($_SESSION['userid'])) {
		$redirectURI = $_POST['redirect'];
		header("Location: $redirectURI");
		die();
	}
	
	include 'database.php';
	
	$userID = $_SESSION['userid'];
	
	
	$redirectURI = $_POST['redirect'];
	header("Location: $redirectURI");
	die();

?>