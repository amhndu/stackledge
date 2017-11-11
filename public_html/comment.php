<?php session_start(); 
	if(!isset($_SESSION['username'])) 
	header('Location: index.php');

	require_once('../php/connect.php');	
	require('../php/header.php');

	function displaycomment($cid, $db_conn)
    {
        $stmt = $db_conn->prepare('SELECT * FROM Comment where comment_id ='.$cid);
        $stmt->execute();
        $result = $stmt->get_result();
    	$row = $result->fetch_assoc();
        
        $post_owner = $row['owner'];
        $post_vote = $row['upvotes'] - $row['downvotes'];
        $post_time = $row['submission_time'];
        $post_comment = $row['text'];
        include("../templates/comment_template.php");
        
        $stmt = $db_conn->prepare('SELECT comment_id FROM Comment where parent_id ='.$cid);
        $stmt->execute();
        $result = $stmt->get_result();
        while($row = $result->fetch_assoc()) { displaycomment($row['comment_id'], $db_conn); }
        
        echo '</div>';
	}
	
	
    $stmt = $db_conn->prepare('SELECT comment_id FROM Comment where parent_id is NULL and post_id = ? ');
    $stmt->bind_param("i", $_GET['p']);
    $stmt->execute();
    $result = $stmt->get_result();
    
	while($row = $result->fetch_assoc()) displaycomment($row['comment_id'], $db_conn);
?>

