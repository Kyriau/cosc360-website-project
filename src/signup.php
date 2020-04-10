<?php

	session_start();
	
	// Permit this page only if no user is signed in
	if(isset($_SESSION['userid'])) {
		$userID = $_SESSION['userid'];
		header("Location: profile.php?id=$userID");
		die();
	}
	
	include_once 'database.php';
	
?>

<!DOCTYPE html>
<html lang=en>
	<head>
		<title>Kyriau's Forum Website</title>
		<link rel="stylesheet" type="text/css" href="css/reset.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>
	<body>
		
		<div class="header">
			<div class="left-header">
				<h1>The Great Forum</h1>
				<nav>
					<a class="header-nav" href="main.php">Home</a>
					<a class="header-nav" href="https://www.google.com">Google</a>
					<a class="header-nav" href="html/404.html">Other</a>
				</nav>
			</div>
			<?php include 'userinfo.php'; ?>
		</div>
		
		<div class="main">
			
			<div class="sidebar">
				<h2>Site News</h2>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Sem nulla pharetra diam sit amet nisl suscipit adipiscing. Quis risus sed vulputate odio ut enim blandit volutpat. Sed sed risus pretium quam. Fermentum dui faucibus in ornare quam viverra orci sagittis eu. Risus sed vulputate odio ut. Purus viverra accumsan in nisl. Vitae congue eu consequat ac felis donec et. Nulla porttitor massa id neque. Dictum non consectetur a erat nam at lectus urna duis. Non tellus orci ac auctor augue mauris augue neque gravida. Elementum pulvinar etiam non quam lacus suspendisse faucibus. Et tortor consequat id porta nibh venenatis cras. Hac habitasse platea dictumst vestibulum rhoncus est pellentesque elit. Libero volutpat sed cras ornare arcu.</p>
			</div>
			
			<div class="content">
			
				<h2>Sign Up</h2>
				<form action="newuser.php" method="POST" enctype="multipart/form-data">
					<table>
					<tr><h4>
						<td><label for="username">Username:</label></td>
						<td><input type="text" name="username" id="username" maxlength="64" required></td>
					</h4></tr>
					<tr><h4>
						<td><label for="email">Email:</label></td>
						<td><input type="email" name="email" id="email" required></td>
					</h4></tr>
					<tr><h4>
						<td><label for="password">Password:</label></td>
						<td><input type="password" name="password" id="password" required></td>
					</h4></tr>
					<tr><h4>
						<td><label for="userimg">User Image:</label></td>
						<td><input type="file" id="userimg" name="userimg" accept="image/png"></td>
					</h4>
					<tr><h4>
						<td><input type="submit" value="Submit"></td>
					</h4></tr>
					</table>
				</form>
			
			</div>
			
		</div>
		
		<div class="footer">
			<h3>&copy; 2020 Jeff Thomson</h3>
		</div>
		
	</body>
</html>