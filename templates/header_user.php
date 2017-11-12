<header class="header-login-signup">
<div class="header-limiter">
	<h1><a href="index.php">Stack<span>ledge</span></a></h1>
	<nav>
		<a href="index.php">Home</a>
		<a href="newpost.php" class="selected">New Post</a>

		<div class="dropdown">
			<button class="dropbtn">Categories ▾</button>
              <div class="dropdown-content">
                <?php
                foreach ($categories as $category)
                    echo "<a href='category.php?c=$category'>$category</a>";
                ?>
			</div>
		 </div>
	</nav>
	<ul>
       <a href="user.php?u=<?php echo $_SESSION['username']?>"><?php echo $_SESSION['username']; ?></a>
       |
       <form method = 'post' style="display:inline-block;" action = "<?php echo $_SERVER['REQUEST_URI']?>" id = 'form' >
       <input type = 'hidden' name = 'logout' value = '1'>
       <a href="" data-toggle="modal" onclick = 'document.getElementById("form").submit();'>Logout</a>
       </form>
       </div>
	</ul>
</div>
</header>

<center>
    <h1><?php echo $content_heading?></h1>
    <h4 <?php if(isset($hide_sort)) echo 'style="display: none"'?> >
        <a href="<?php echo set_GET_parameter("s", "trend")?>">Trending</a> |
        <a href="<?php echo set_GET_parameter("s", "new")?>">New</a> |
        <a href="<?php echo set_GET_parameter("s", "top")?>">Top</a></h4>
</center>
<hr>
