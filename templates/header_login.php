<header class="header-login-signup">
<div class="header-limiter">
	<h1><a href="#">Stack<span>ledge</span></a></h1>
	<nav>
		<a href="#">Home</a>
		<a href="#" class="selected">New Post</a>

		<div class="dropdown">
			<button class="dropbtn">Categories ▾</button>
			<div class="dropdown-content">
				<a href="#">Category 1</a>
				<a href="#">Category 2</a>
				<a href="#">Category 3</a>
			</div>
		 </div>
	</nav>
	<ul>
       <a href="javascript:void(0)" onclick="openLoginModal();">Log in</a>
       |
       <a data-toggle="modal" href="javascript:void(0)" onclick="openRegisterModal();">Register</a></div>
	</ul>
</div>
</header>

<div class="container">
	 <div class="modal fade login" id="loginModal" aria-hidden="true" style="display: none;">
	      <div class="modal-dialog login animated">
		      <div class="modal-content">
		         <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Login with</h4>
                </div>
                <div class="modal-body">
                    <div class="box">
                         <div class="content">
                            <div class="error"></div>
                            <div class="form loginBox">
                                <form method="post"  accept-charset="UTF-8" action = 'login.php'>
                                <input id="username" class="form-control" type="text" placeholder="Username" name="username">
                                <input id="password" class="form-control" type="password" placeholder="Password" name="password">
                                <input class="btn btn-default btn-login" type="submit" value="Login" >
                                </form>
                            </div>
                         </div>
                    </div>
                    <div class="box">
                        <div class="content registerBox" style="display:none;" id="regModal">
                         <div class="form">
                            <form method="post" html="{:multipart=&gt;true}" data-remote="true" action="signup.php" accept-charset="UTF-8" id = "regform">
                            <input id="regusername" class="form-control" type="text" placeholder="Username" name="username">
                            <input id="regemail" class="form-control" type="text" placeholder="Email" name="email">
                            <input id="regpassword" class="form-control" type="password" placeholder="Password" name="password">
                            <input id="regpassword_confirmation" class="form-control" type="password" placeholder="Repeat Password" name="password_confirmation">
                            <input type = 'hidden' name = 'newuser' value = 'true'>
                            <input class="btn btn-default btn-register" type="button" onclick="validate()" value = "submit">
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="forgot login-footer">
                        <span>Looking to
                             <a href="javascript: showRegisterForm();">create an account</a>
                        ?</span>
                    </div>
                    <div class="forgot register-footer" style="display:none">
                         <span>Already have an account?</span>
                         <a href="javascript: showLoginForm();">Login</a>
                    </div>
                </div>
		      </div>
	      </div>
	  </div>
</div>

<script type = "text/javascript">
function validate(){
	if(document.getElementById('regpassword').value == document.getElementById('regpassword_confirmation').value)
		document.getElementById('regform').submit();
	else
		shakeModalRegister("Passwords don't match");
}
</script>

<?php
if($prompt)
{
    echo '<script type="text/javascript">
     $(document).ready(function(){
        openLoginModal();' .
        (isset($loginresult) and !$loginresult ? 'shakeModallogin();' : '') .
     ' }); </script>';
}

if(isset($_SESSION['errorMsg']))
{
	echo '<script type ="text/javascript">
	 $(document).ready(function(){
		 shakeModalRegister("'.$_SESSION['errorMsg'].'");
	 }); </script>';
	unset($_SESSION['errorMsg']);
}
?>
