<?php
	
	// DB Setup
	$dbuser = 'root';
	$dbpass = '';
	$dbname = 'forum';
	$db = new mysqli('localhost', $dbuser, $dbpass, $dbname);
	
	// Setup prepared statements
	$usernameQuery = $db->prepare("SELECT * FROM Users WHERE Username = ?;");
	$userIDQuery = $db->prepare("SELECT * FROM Users WHERE ID = ?;");
	$userEmailQuery = $db->prepare("SELECT * FROM Users WHERE Email = ?;");
	$forumQuery = $db->prepare("SELECT ID, Name, Description FROM Forums WHERE Parent = ? ORDER BY UpdateTime;");
	$threadQuery = $db->prepare("SELECT ID, Title FROM Threads WHERE ForumID = ? ORDER BY UpdateTime;");
	$commentQuery = $db->prepare("SELECT ID, Content FROM Comments WHERE ThreadID = ? ORDER BY UpdateTime LIMIT ?;");
	$userCommentQuery = null;
	
	function get_user_by_username($username) {
		
		$usernameQuery->bind_param("s", $username);
		$usernameQuery->execute();
		$user = $usernameQuery->get_result()->fetch_row();
		
	}
	
	function get_user_by_id($userID) {
		
	}
	
	function get_user_by_email($email) {
			
	}
	
	// Echo a list of subforums to this forum
	function forum_list($parentID) {
		
		global $forumQuery;
		
		$forumQuery->bind_param("i", $parentID);
		$forumQuery->execute();
		$forums = $forumQuery->get_result();
		
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
		
		global $threadQuery, $commentQuery;
		
		$threadQuery->bind_param("i", $forumID);
		$threadQuery->execute();
		$threads = $threadQuery->get_result();
		
		while($threadRow = $threads->fetch_row()) {
			
			echo "<div class=\"content-row\">";
			echo "<div class=\"post-title\">";
			echo "<h4><a href=\"post.php?id=" . $threadRow[0] . "\">" . $threadRow[1] . "</a></h4>";
			echo "</div>";
			echo "<div class=\"post-preview\">";
			echo "<h4>" . "Unimplemented" . "</h4>"; //TODO: Post preview (based on recent comment?)
			echo "</div>";
			echo "</div>";
			
		}
		
		$threads->close();
		
		// TODO: User actions
		
	}
	
?>