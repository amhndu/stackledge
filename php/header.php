<?php
	if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!doctype html>
<html>
    <head>
      <title>Stackledge - The stack of knowledge</title>

    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link href='http://fonts.googleapis.com/css?family=Cookie' rel='stylesheet' type='text/css'>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="js/jquery-1.10.2.js.download" type="text/javascript"></script>
    <script src="js/bootstrap.js.download" type="text/javascript"></script>
    <script src="js/login-register.js.download" type="text/javascript"></script>
    <script src="js/vote.js" type="text/javascript"></script>

    </head>
<body>


<?php
    require_once('../php/connect.php');
    require_once('../php/functions.php');

	$loggedin = isset($_SESSION['username']);

    // create an array of categories
    $result = $db_conn->query("SELECT name FROM Category;");
    $categories = [];
    if ($result->num_rows > 0)
    {
        while ($row = $result->fetch_assoc())
            array_push($categories, $row['name']);
    }
    else
        $category = ["none found"];

	if($loggedin)
	{
        $prompt = false;
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
        unset($_SESSION['loginfailed']);
        $prompt = true;
        require('../templates/header_login.php');
    }
    else
    {
        if (isset($_SESSION['login-prompt']))
        {
            $prompt = $_SESSION['login-prompt'];
            unset($_SESSION['login-prompt']);
        }
        else
            $prompt = false;
        require('../templates/header_login.php');
    }
?>
