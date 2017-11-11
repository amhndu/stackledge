<header class="header-login-signup">
<div class="header-limiter">
	<h1><a href="#">Stack<span>ledge</span></a></h1>
	<nav>
		<a href="#">Home</a>
		<a href="#" class="selected">Blog</a>
		<a href="#">Pricing</a>
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
                        <div class="content registerBox" style="display:none;">
                         <div class="form">
                            <form method="post" html="{:multipart=&gt;true}" data-remote="true" action="index.php" accept-charset="UTF-8">
                            <input id="username" class="form-control" type="text" placeholder="Username" name="username">
                            <input id="email" class="form-control" type="text" placeholder="Email" name="email">
                            <input id="password" class="form-control" type="password" placeholder="Password" name="password">
                            <input id="password_confirmation" class="form-control" type="password" placeholder="Repeat Password" name="password_confirmation">
                            <input type = 'hidden' name = 'newuser' value = 'true'>
                            <input class="btn btn-default btn-register" type="submit" >
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
<?php
if($prompt)
{
    echo '<script type="text/javascript">
     $(document).ready(function(){
        openLoginModal();' .
        (isset($loginresult) and !$loginresult ? 'shakeModal();' : '') .
     ' }); </script>';
}
?>
