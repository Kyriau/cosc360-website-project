<?php
	
	session_start();

	echo "<div class=\"right-header\">";
	
	if(isset($_SESSION['user'])) {
		
	} else {
		echo "Unrecognized User";
	}
	
	echo "</div>";
	
?>