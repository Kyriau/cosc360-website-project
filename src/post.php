<?php

	session_start();
	
	if(!isset($_SESSION['userid'])) {
		$redirectURI = $_POST['redirect'];
		header("Location: $redirectURI");
		die();
	}
	
	include 'database.php';
	
	insert_thread($_SESSION['userid'], $_POST['forumid'], $_POST['title'], $_POST['replytext']);
	
	$redirectURI = $_POST['redirect'];
	header("Location: $redirectURI");
	die();

?>