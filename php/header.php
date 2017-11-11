<?php
    session_start();
?>

<!doctype html>
<html>
    <head>
        <title>Stackledge - The stack of knowledge</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">

		<link rel="stylesheet" href="css/header-login-signup.css">
		<link href='http://fonts.googleapis.com/css?family=Cookie' rel='stylesheet' type='text/css'>
		<link href="css/bootstrap.css" rel="stylesheet">

	  	<link href="css/header-login-register.css" rel="stylesheet">
	  	<link rel="stylesheet" href="css/font-awesome.css">

	  	<script src="js/jquery-1.10.2.js.download" type="text/javascript"></script>
	  	<script src="js/bootstrap.js.download" type="text/javascript"></script>
	  	<script src="js/login-register.js.download" type="text/javascript"></script>
    </head>
<body>


<?php
	$loggedin = isset($_SESSION['username']);
	
    $prompt = false;
	if($loggedin)
	{
        if(isset($_POST['logout'])) // logged in but logging out now
        {
            session_unset();
            session_destroy();
            require('../templates/header_login.php');	
        }
        else // logged in
            require('../templates/header_user.php');
    }
    else if (isset($_SESSION['loginfailed']))
    {
        $loginresult = false;
        $prompt = true;
        require('../templates/header_login.php');
    }
    else
    {
        $prompt = true;
        require('../templates/header_login.php');	
    }
?>
