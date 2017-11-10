<?php
	$loggedin = isset($_SESSION['username']);
	
	if($loggedin)
	{
		require './header_user.php';
	}
	else if(!$loggedin && isset($_POST['username']) && isset($_POST['password']))
	{
		require 'php/connect.php';		
		$stmt = $conn->prepare('SELECT passhash FROM User Where username = ?');
		$stmt->bind_param("s", $_POST['username']);

		$stmt->execute(); 
		$result = $stmt->get_result();
		$row = $result->fetch_array(MYSQLI_NUM);
		
		$_POST['password'] = str_replace(PHP_EOL, '', $_POST['password']);
		
		if($row[0] == hash('sha256', $_POST['password']))
		{
			$loginresult = true;
			session_start();
			$_SESSION['username'] = $_POST['username'];
			require './header/header_user.php';	
		}
		else
		{
			$loginresult = false;
			require './header/header_login.php';
		}
		$stmt->close();
		$conn->close();	
	}
	else 
	{
		if(isset($_POST['logout']) && session_id()) session_destroy();
		require './header/header_login.php';	
	}	
?>
