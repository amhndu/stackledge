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
       <form method = 'post' style="display:inline-block;" action = 'index.php' id = 'form' >
       <input type = 'hidden' name = 'logout' value = '1'>
       <a href="" data-toggle="modal" onclick = 'document.getElementById("form").submit();'>Logout</a>
       </form>
       </div>
	</ul>
</div>
</header>

