<?php
	session_start();

	if(($_POST['newuser']) && ($_POST['username']) && ($_POST['email']) && ($_POST['password']) && ($_POST['password_confirmation']) && ($_POST['password'] == $_POST['password_confirmation']))
	{
		require '../php/connect.php';
		$_POST['password'] = str_replace(PHP_EOL, '', $_POST['password']);
		$passhash = hash('sha256', $_POST['password']);
		$stmt = $db_conn->prepare('INSERT INTO User (username, email, join_date, passhash) values (?, ?, ?, ?)');
		$stmt->bind_param("ssss", $_POST['username'], $_POST['email'], date("Y/m/d"), $passhash);
		$stmt->execute();

		if($stmt->affected_rows == -1)
		{
			$_SESSION['errorMsg'] = 'Username already taken';
		}
		else if($stmt->affected_rows == 1)
			$_SESSION['username'] = $_POST['username'];
	}
	else
	{
	 	$_SESSION['errorMsg'] = 'Invalid request';
        if ($_POST['password'] && $_POST['password_confirmation'] && ($_POST['password'] != $_POST['password_confirmation']))
            $_SESSION['errorMsg'] = 'Confirm password does not match';
	}

	header('Location: index.php');

?>
