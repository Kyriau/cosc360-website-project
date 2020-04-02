<?php
	
	// DB Setup
	$user = 'root';
	$pass = '';
	$dbname = 'forum';
	$db = new mysqli('localhost', $user, $pass, $dbname);
	
	// Setup prepared statements
	$forumQuery = $db->prepare("SELECT ID, Name, Description FROM Forums WHERE Parent = ? ORDER BY UpdateTime;");
	$threadQuery = $db->prepare("SELECT ID, Title FROM Threads WHERE ForumID = ? ORDER BY UpdateTime;");
	$commentQuery = $db->prepare("SELECT ID, Content FROM Comments WHERE ThreadID = ? ORDER BY UpdateTime LIMIT ?;");
	$userCommentQuery = null;
	
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
	function post_list($forumID) {
		
		global $threadQuery, $commentQuery;
		
		$threadQuery->bind_param("i", $forumID);
		$threadQuery->execute();
		$threads = $threadQuery->get_result();
		
		while($threadRow = $threads->fetch_row()) {
			
			echo "<div class=\"content-row\">";
			echo "<div class=\"post-title\">";
			echo "<h4><a href=\"post.php?id=" . $row[0] . "\">" . $row[1] . "</a></h4>";
			echo "</div>";
			echo "<div class=\"post-preview\">";
			echo "<h4>" . "Unimplemented" . "</h4>"; //TODO: Post preview (based on recent comment?)
			echo "</div>";
			echo "</div>";
			
		}
		
		$threads->close();
		
		// TODO: Administrator actions
		
	}
	
?>