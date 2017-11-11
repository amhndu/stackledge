<?php

	session_start();
	require('connect.php');
	
	$stmt = $db_conn->prepare('INSERT INTO Post(url, submission_time, upvotes, downvotes, owner, category, title) values(?, ?, ?, ?, ?, ?, ?)');
	
	$url = $_POST['url'];
	$datetime = date('Y-m-d H:i:s');
	$uv = 0;
	$dv = 0;
	$owner = $_SESSION['username'];
	$category = $_POST['category'];
	$title = $_POST['title'];
	
	$stmt->bind_param("ssiisss", $url, $datetime, $uv, $dv, $owner, $category, $title);
	$stmt->execute();
	echo $stmt->affected_rows;
	
	if($stmt->affected_rows != 1)
		{ echo 'error posting'; exit();}
		
	else echo 'done';
?>
