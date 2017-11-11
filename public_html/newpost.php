<?php
	session_start();
	if(!isset($_SESSION['username']))
		header('Location: index.php');
		
	require('../php/header.php');
	
	echo '
	<div class="header" style="width:70%">
            <h1>New Post</h1>
    </div>
	<div style="width:100%;">
	<form action = ../php/submitpost.php method = "post">

	<label for="url">URL</label>
	<div class="form_input">
	<input type="text" name="url" placeholder="https://"/>
	</div>
	<br /><br />

	<label for="title">Title</label>
	<div class="form_input">
	<input type="text" name="title" placeholder="Title..." />
	</div>
	<br /><br />

	<label for="category">Category</label>
	<div class="form_input" style="padding-top:10px;">
		<select name="category">
		  <option value="compsci">foo</option>
		  <option value="saab">bar</option>
		  <option value="mercedes">test</option>
		</select>
	</div>

	<br /><br />	<br /><br />	<br /><br />
	<div style="text-align: right; width:50%">
		<input type="submit" value="Post">
    </div>
	</form>
</div>

	</body>
</html>'
	
?>
