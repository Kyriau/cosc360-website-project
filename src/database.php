<?php
	
	// DB Setup
	$dbuser = 'root';
	$dbpass = '';
	$dbname = 'forum';
	$db = new mysqli('localhost', $dbuser, $dbpass, $dbname);
	
	// Setup prepared statements
	$usernameQuery = $db->prepare("SELECT * FROM Users WHERE Username = ?;");
	$userIDQuery = $db->prepare("SELECT * FROM Users WHERE ID = ?;");
	$forumQuery = $db->prepare("SELECT ID, Name, Description FROM Forums WHERE Parent = ? ORDER BY UpdateTime;");
	$threadQueryByForum = $db->prepare("SELECT * FROM Threads WHERE ForumID = ? ORDER BY UpdateTime;");
	$threadQueryByThread = $db->prepare("SELECT * FROM Threads WHERE ID = ?;");
	$commentQueryByThread = $db->prepare("SELECT * FROM Comments WHERE ThreadID = ? ORDER BY UpdateTime LIMIT ?;");
	$commentQueryByUser = $db->prepare("SELECT * FROM Comments WHERE PosterID = ? ORDER BY UpdateTime LIMIT ?;");
	//$userCommentQuery = $db->prepare("SELECT * FROM UserComments WHERE PosterID = ?;");
	
	$userInsert = $db->prepare("INSERT INTO Users(Username, Email, Password, Administrator) VALUE (?, ?, ?, FALSE);");
	
	function get_user_by_username($username) {
		
		global $usernameQuery;
		
		$usernameQuery->bind_param("s", $username);
		$usernameQuery->execute();
		$result = $usernameQuery->get_result();
		
		if($user = $result->fetch_row()) {
			return $user;
		} else {
			return null;
		}
	}
	
	function get_user_by_id($userID) {
		
		global $userIDQuery;
		
		$userIDQuery->bind_param("i", $userID);
		$userIDQuery->execute();
		$result = $userIDQuery->get_result();
		
		if($user = $result->fetch_row()) {
			return $user;
		} else {
			return null;
		}
		
	}
	
	// Echo a list of subforums to this forum
	function forum_list($parentID) {
		
		global $forumQuery;
		
		$forumQuery->bind_param("i", $parentID);
		$forumQuery->execute();
		$forums = $forumQuery->get_result();
		
		if($forums->num_rows > 0) {
			echo "<h2>Forums</h2>";
		}
		
		while($forumRow = $forums->fetch_row()) {
			echo "<div class=\"content-row\">";
			echo "<div class=\"post-title\">";
			echo "<h4><a href=\"forum.php?id=" . $forumRow[0] . "\">" . $forumRow[1] . "</a></h4>";
			echo "</div>";
			echo "<div class=\"post-preview\">";
			echo "<h4>" . $forumRow[2] . "</h4>";
			echo "</div>";
			echo "</div>";
		}
		
		$forums->close();
		
		//TODO: Administrator actions
		
	}
	
	// Echo a list of posts in this forum
	function thread_list($forumID) {
		
		global $threadQueryByForum, $commentQueryByThread;
		
		$threadQueryByForum->bind_param("i", $forumID);
		$threadQueryByForum->execute();
		$threads = $threadQueryByForum->get_result();
		
		$amount = 1;
		$commentQueryByThread->bind_param("ii", $threadID, $amount);
		
		echo "<h2>Threads</h2>";
		
		while($threadRow = $threads->fetch_row()) {
			
			$threadID = $threadRow[0];
			$threadTitle = $threadRow[3];
			
			$commentQueryByThread->execute();
			$commentQueryByThread->get_result()->fetch_row();
			
			echo "<div class=\"content-row\">";
			echo "<div class=\"post-title\">";
			echo "<h4><a href=\"post.php?id=$threadID\">$threadTitle</a></h4>";
			echo "</div>";
			echo "<div class=\"post-preview\">";
			echo "<p>" . "Unimplemented" . "</p>"; //TODO: Post preview (based on recent comment?)
			echo "</div>";
			echo "</div>";
			
		}
		
		$threads->close();
		
		// TODO: User actions
		if(isset($_SESSION['userid'])) {
			
		}
		
	}
	
	function comment_list($threadID) {
		
		global $threadQueryByThread, $commentQueryByThread;
		
		$threadQueryByThread->bind_param("i", $threadID);
		$threadQueryByThread->execute();
		$thread = $threadQueryByThread->get_result();
		
		if($thread->num_rows == 0) {
			header("Location: main.php");
			die();
		} else {
			$threadTitle = $thread->fetch_row()[3];
		}
		
		$amount = 10;
		
		$commentQueryByThread->bind_param("ii", $threadID, $amount);
		$commentQueryByThread->execute();
		$comments = $commentQueryByThread->get_result();
		
		echo "<h2>$threadTitle</h2>";
		
		while($comment = $comments->fetch_row()) {
			
			$posterID = $comment[1];
			$posterName = get_user_by_id($posterID)[1];
			$postBody = $comment[4];
			
			echo "<div class=\"content-row\">";
			echo "<div class=\"profile-pic\">";
			echo "<a href=\"profile.php?id=$posterID\"><img class=\"profile-pic\" src=\"img/Duck.png\"></a>";
			echo "<h3><a href=\"profile.php?id=$posterID\">$posterName</a></h3>";
			echo "</div>";
			echo "<div class=\"post-comment\">";
			echo "<p>$postBody</p>";
			echo "</div>";
			echo "</div>";
			
		}
		
		// TODO: Post reply
		if(isset($_SESSION['userid'])) {
			
		}
		
	}
	
	function user_profile($userID) {
		
		global $commentQueryByUser, $threadQueryByThread;
		
		$user = get_user_by_id($userID);
		$username = $user[1];
		
		echo "<h2>$username</h2>";
		echo "<div class=\"content-row\">";
		echo "<div class=\"profile-pic\">";
		echo "<img class=\"profile-pic-large\" src=\"img/Duck.png\">";
		echo "</div>";
		echo "<div class=\"profile-desc\">";
		echo "<p>TODO: User Description Here</p>"; //TODO: User Description
		echo "</div>";
		echo "</div>";
		
		$amount = 10;
		
		$commentQueryByUser->bind_param("ii", $user[0], $amount);
		$commentQueryByUser->execute();
		$comments = $commentQueryByUser->get_result();
		
		if($comments->num_rows > 0) {
			echo "<h2>Activity</h2>";
		}
		
		while($comment = $comments->fetch_row()) {
			
			$threadQueryByThread->bind_param("i", $comment[2]);
			$threadQueryByThread->execute();
			$thread = $threadQueryByThread->get_result()->fetch_row();
			
			$threadID = $thread[0];
			$threadTitle = $thread[3];
			$commentContent = $comment[4];
			
			echo "<div class=\"content-row\">";
			echo "<div class=\"post-title\">";
			echo "<h4><a href=\"post.php?id=$threadID\">$threadTitle</a></h4>";
			echo "</div>";
			echo "<div class=\"post-preview\">";
			echo "<p>$commentContent</p>";
			echo "</div>";
			echo "</div>";
			
		}
		
	}
	
	function insert_user($username, $password, $email) {
		
		global $userInsert;
		
		$password = password_hash($password, PASSWORD_DEFAULT);
		
		$userInsert->bind_param("sss", $username, $email, $password);
		$userInsert->execute();
		
		echo $userInsert->affected_rows;
		
		if($userInsert->affected_rows > 0) {
			$result = $userInsert->get_result();
			session_start();
			$_SESSION['userid'] = $userInsert->insert_id;
			$_SESSION['passhash'] = $password;
		}
		
		return $userInsert->affected_rows;
		
	}
	
?>