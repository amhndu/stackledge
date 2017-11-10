<?php
    session_start();

	$loggedin = isset($_SESSION['username']);
	
	if($loggedin)
	{
        if(isset($_POST['logout'])) // logged in but logging out now
        {
            session_unset();
            session_destroy();
            $prompt = false;
            require('../templates/header_login.php');	
        }
        else // logged in
            require('../templates/header_user.php');
	}
	else if(!$loggedin && isset($_POST['username']) && isset($_POST['password'])) // ie. login attempt
	{
		require 'connect.php';		
		$stmt = $db_conn->prepare('SELECT passhash FROM User Where username = ?');
		$stmt->bind_param("s", $_POST['username']);

		$stmt->execute(); 
		$result = $stmt->get_result();
		$row = $result->fetch_array(MYSQLI_NUM);
		
		$_POST['password'] = str_replace(PHP_EOL, '', $_POST['password']);
		
		if($row[0] == hash('sha256', $_POST['password']))
		{
			$loginresult = true;
			$_SESSION['username'] = $_POST['username'];
			require('../templates/header_user.php');	
		}
		else
		{
			$loginresult = false;
			require('../templates/header_login.php');
		}
		$stmt->close();
	}
    else
    {
        $prompt = true;
        require('../templates/header_login.php');	
    }
?>
