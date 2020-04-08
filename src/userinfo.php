<?php
	
	include_once 'database.php';
	
	session_start();

	echo "<div class=\"right-header\">";
	
	if(isset($_SESSION['userid'])) {
		
		get_user_by_id($_SESSION['userid']);
		
		//TODO: Authenticate
		
		echo "<a href=\"html/profile.html\">";
		echo "<img class=\"profile-pic\" src=\"img/Duck.png\">";
		echo "</a>";
		echo "<h3>";
		//echo "<a href=\"profile.php?ID=$user['ID']\">$user['Username']</a>";
		echo "</h3>";
		
	} else {
		
		$requestURI = $_SERVER['REQUEST_URI'];
		
		echo "<form action=\"login.php\" method=\"POST\">";
		echo "<input type=\"text\" id=\"username\" name=\"username\" placeholder=\"Username\">";
		echo "<input type=\"password\" id=\"password\" name=\"password\" placeholder=\"Password\">";
		echo "<input type=\"submit\" value=\"Login\">";
		echo "<input type=\"hidden\" id=\"redirect\" name=\"redirect\" value=\"$requestURI\">";
		echo "<a href=\"signup.php\">Sign Up</a>";
		echo "</form>";
		
	}
	
	echo "</div>";
	
?>