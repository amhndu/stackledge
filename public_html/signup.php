<?php
	session_start();
	
	if(($_POST['newuser']) && ($_POST['username']) && ($_POST['email']) && ($_POST['password']) && ($_POST['password_confirmation']) && ($_POST['password'] == $_POST['password_confirmation']))
	{
		require '../php/connect.php';			
		$_POST['password'] = str_replace(PHP_EOL, '', $_POST['password']);
		$passhash = hash('sha256', $_POST['password']);
		$rep = 0;
		$stmt = $db_conn->prepare('INSERT INTO User values(?, ?, ?, ?, ?)');
		$stmt->bind_param("sssis", $_POST['username'], $_POST['email'], date("Y/m/d"), $rep, $passhash);
		$stmt->execute();
		
		if($stmt->affected_rows == -1)
		{
			$_SESSION['errorMsg'] = 'username taken';
		}
		else if($stmt->affected_rows == 1)
			$_SESSION['username'] = $_POST['username'];
	}
	else
	{ 
	 	$_SESSION['errorMsg'] = 'parameter error';
	}
	
	header('Location: index.php');

?>
