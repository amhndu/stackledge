<!doctype html>
<html>
    <head>
        <title>Stackledge - The stack of knowledge</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
		<title>Header login/register</title>

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

<div>
<?php require_once('../php/header.php')?>
</div>
<div class="posts">
<?php
    require_once('../php/connect.php');
    require_once('../php/feed.php');
    generate_feed($db_conn, FEED_ALL | FEED_TRENDING);
    $db_conn->close();
?>
</div>

</body>
</html>
