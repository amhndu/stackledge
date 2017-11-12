<div class="newpost">
  <form action="submitpost.php" method="post">

    <label for="title">Title</label>
    <input type="text" id="title" name="title" placeholder="Title..">

    <label for="url">URL</label>
    <input type="text" id="url" name="url" placeholder="http://..">

    <label for="category">Category</label>
    <select name="category">
          <?php
            foreach ($categories as $cat)
                echo "<option value='$cat'>$cat</option>";
		  ?>
		</select>

    <input type="submit" value="Submit">
  </form>
</div>
