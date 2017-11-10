<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Header login/register</title>

    <link rel="stylesheet" href="assets/header-login-signup.css">
    <link href='http://fonts.googleapis.com/css?family=Cookie' rel='stylesheet' type='text/css'>
    <link href="css/bootstrap.css" rel="stylesheet">

  	<link href="css/header-login-register.css" rel="stylesheet">
  	<link rel="stylesheet" href="css/font-awesome.css">

  	<script src="js/jquery-1.10.2.js.download" type="text/javascript"></script>
  	<script src="js/bootstrap.js.download" type="text/javascript"></script>
  	<script src="js/login-register.js.download" type="text/javascript"></script>

</head>
<body class="" style="">
  <header class="header-login-signup">
  	<div class="header-limiter">
  		<h1><a href="#">Stack<span>ledge</span></a></h1>
  		<nav>
  			<a href="#">Home</a>
  			<a href="#" class="selected">Blog</a>
  			<a href="#">Pricing</a>
  		</nav>
  		<ul>
           <a href="javascript:void(0)" onclick="openLoginModal();"><?php echo $_SESSION['username']; ?></a>
           |
           <form method = 'post' style="display:inline-block;" action = '../php/header.php' id = 'form' >
           <input type = 'hidden' name = 'logout' value = '1'>
           <a href="" data-toggle="modal" onclick = 'document.getElementById("form").submit();'>Logout</a>
           </form>
           </div>
  		</ul>
  	</div>
  </header>
<?php //if(session_id()) print 'session started'; ?>
</body></html>
