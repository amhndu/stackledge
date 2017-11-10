<?php

	if(isset($_POST['newuser']) && isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password_confirmation']) && ($_POST['password'] == $_POST['password_confirmation']))
	{
		require 'php/connect.php';			
		$_POST['password'] = str_replace(PHP_EOL, '', $_POST['password']);
		$passhash = hash('sha256', $_POST['password']);
		$rep = 0;
		$stmt = $conn->prepare('INSERT INTO User values(?, ?, ?, ?, ?)');
		$stmt->bind_param("sssis", $_POST['username'], $_POST['email'], date("Y/m/d"), $rep, $passhash);
		$stmt->execute();
		
		if($stmt->affected_rows == 0)
		{
			echo 'username taken';
			die();
		}
		
		echo 'Welcome to StackLedge';
		session_start();
		$_SESSION['username'] = $_POST['username'];
	}
	else
	 echo 'Error';
?>
